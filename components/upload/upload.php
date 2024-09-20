<?php
// upload.php

include 'vendor/autoload.php'; // Autoload PhpSpreadsheet
include 'config.php';          // Database connection

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
                            throw new Exception("CSV headers do not match expected columns: StudentID, First Name, Father Name, Gender, Leg. Type, Registration Date, Course Load, Reg. Remark, Permitted By.");
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
                } else {
                    // Handle Excel (xlsx, xls)
                    $spreadsheet = IOFactory::load($fileTmpPath);
                    $sheet = $spreadsheet->getActiveSheet();
                    $rows = $sheet->toArray();

                    // Get the header row
                    $header = array_map('trim', $rows[0]);
                    $expectedHeaders = ['StudentID', 'First Name', 'Father Name', 'Gender', 'Leg. Type', 'Registration Date', 'Course Load', 'Reg. Remark', 'Permitted By'];
                    if ($header !== $expectedHeaders) {
                        throw new Exception("Excel headers do not match expected columns: StudentID, First Name, Father Name, Gender, Leg. Type, Registration Date, Course Load, Reg. Remark, Permitted By.");
                    }

                    // Read each data row
                    for ($i = 1; $i < count($rows); $i++) {
                        $row = $rows[$i];
                        // Skip empty rows
                        if (empty($row[0]) && empty($row[1]) && empty($row[2])) {
                            continue;
                        }
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
                }

                // Prepare the SQL statement
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

                echo "<h2>Import Successful!</h2>";
                echo "<p>Inserted records: $inserted</p>";
                if ($skipped > 0) {
                    echo "<p>Skipped invalid records: $skipped</p>";
                }

            } catch (Exception $e) {
                // Rollback transaction on error
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                echo "<h2>Error:</h2>";
                echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            echo "<h2>Invalid file type. Please upload a CSV or Excel file.</h2>";
        }
    } else {
        echo "<h2>No file uploaded or there was an upload error.</h2>";
    }
} else {
    echo "<h2>Invalid request method.</h2>";
}
