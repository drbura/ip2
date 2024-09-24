<?php
// upload.php

include '../upload/vendor/autoload.php'; // Autoload PhpSpreadsheet
include '../upload/config.php';          // Database connection

use PhpOffice\PhpSpreadsheet\IOFactory;

// Function to validate data
function validateData($studentID, $firstName, $fatherName, $gender, $legType, $registrationDate, $courseLoad, $regRemark, $permittedBy) {
    if (empty($studentID) || empty($firstName) || empty($fatherName)) {
        return false;
    }
    return true;
}

// Function to convert date from MM/DD/YYYY to YYYY-MM-DD
function convertDate($date) {
    $datetime = DateTime::createFromFormat('m/d/Y', $date);
    if ($datetime) {
        return $datetime->format('Y-m-d');
    }
    return null; // Return null if the date format is invalid
}

// Prepare JSON response
$response = ['success' => false, 'message' => 'An error occurred.'];

// Check if a file was uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName    = $_FILES['file']['name'];
        $fileSize    = $_FILES['file']['size'];
        $fileType    = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed file extensions
        $allowedExtensions = ['csv', 'xlsx', 'xls'];

        if (in_array($fileExtension, $allowedExtensions)) {
            // Initialize data array
            $data = [];

            try {
                if ($fileExtension === 'csv') {
                    // Handle CSV
                    if (($handle = fopen($fileTmpPath, 'r')) !== FALSE) {
                        // Get the header row
                        $header = fgetcsv($handle, 1000, ',');

                        // Check if headers match expected columns
                        $expectedHeaders = ['StudentID', 'First Name', 'Father Name', 'Gender', 'Leg. Type', 'Registration Date', 'Course Load', 'Reg. Remark', 'Permitted By'];
                        if ($header !== $expectedHeaders) {
                            throw new Exception("CSV headers do not match expected columns.");
                        }

                        // Read each data row
                        while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                            $data[] = [
                                'StudentID'         => trim($row[0]),
                                'First Name'        => trim($row[1]),
                                'Father Name'       => trim($row[2]),
                                'Gender'            => trim($row[3]),
                                'Leg. Type'         => trim($row[4]),
                                'Registration Date' => trim($row[5]),
                                'Course Load'       => trim($row[6]),
                                'Reg. Remark'       => trim($row[7]),
                                'Permitted By'      => trim($row[8]),
                            ];
                        }
                        fclose($handle);
                    } else {
                        throw new Exception("Unable to open the uploaded CSV file.");
                    }
                }

                // Prepare the SQL statement to check for existing StudentID
                $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM studentdata WHERE StudentID = :StudentID");
                // Prepare the SQL statement for insertion
                $stmt = $pdo->prepare("INSERT INTO studentdata (StudentID, `First Name`, `Father Name`, Gender, `Leg. Type`, `Registration Date`, `Course Load`, `Reg. Remark`, `Permitted By`) VALUES (:StudentID, :FirstName, :FatherName, :Gender, :LegType, :RegistrationDate, :CourseLoad, :RegRemark, :PermittedBy)");

                $inserted = 0;
                $skipped = 0;

                // Begin transaction
                $pdo->beginTransaction();

                foreach ($data as $entry) {
                    $studentID = $entry['StudentID'];
                    $firstName = $entry['First Name'];
                    $fatherName = $entry['Father Name'];
                    $gender = $entry['Gender'];
                    $legType = $entry['Leg. Type'];
                    $registrationDate = convertDate($entry['Registration Date']);  // Convert the date format
                    $courseLoad = $entry['Course Load'];
                    $regRemark = $entry['Reg. Remark'];
                    $permittedBy = $entry['Permitted By'];

                    // Validate data
                    if (validateData($studentID, $firstName, $fatherName, $gender, $legType, $registrationDate, $courseLoad, $regRemark, $permittedBy)) {
                        // Check if StudentID already exists
                        $checkStmt->execute([':StudentID' => $studentID]);
                        $exists = $checkStmt->fetchColumn();

                        if ($exists) {
                            $skipped++; // Increment skipped count if the StudentID exists
                            continue; // Skip the rest of the loop for this entry
                        }

                        // Execute the prepared statement
                        $stmt->execute([
                            ':StudentID'        => $studentID,
                            ':FirstName'        => $firstName,
                            ':FatherName'       => $fatherName,
                            ':Gender'           => $gender,
                            ':LegType'          => $legType,
                            ':RegistrationDate' => $registrationDate,
                            ':CourseLoad'       => $courseLoad,
                            ':RegRemark'        => $regRemark,
                            ':PermittedBy'      => $permittedBy,
                        ]);
                        $inserted++;
                    } else {
                        $skipped++;
                    }
                }

                // Commit transaction
                $pdo->commit();

                // Set success response
                $response['success'] = true;
                $response['inserted'] = $inserted;
                $response['skipped'] = $skipped;

            } catch (Exception $e) {
                // Rollback transaction on error
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                $response['message'] = $e->getMessage();
            }
        } else {
            $response['message'] = "Invalid file type. Please upload a CSV or Excel file.";
        }
    } else {
        $response['message'] = "No file uploaded or there was an upload error.";
    }
} else {
    $response['message'] = "Invalid request method.";
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
