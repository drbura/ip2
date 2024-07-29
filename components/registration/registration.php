<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DDU Student Registration Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Roboto', sans-serif;
            margin-top: 80px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: auto;


        }

        h2 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .form-label {
            color: #333;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .form-control, .form-control:focus {
            background-color: #e9ecef;
            color: #495057;
            border: 1px solid #ced4da;
            border-radius: 5px;
            height: calc(1.4em + 0.75rem + 2px);
            font-size: 0.9rem;
        }
        .form-check-label {
            font-size: 0.85rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .text-danger {
            color: red !important;
        }
        .error {
            border-color: red;
        }
        .error-message {
            color: red;
            font-size: 0.8em;
            display: none;
        }
        fieldset {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        legend {
            font-size: 1.2rem;
        }
    </style>
    <script>
        function populate(s1, s2) {
            var s1 = document.getElementById(s1);
            var s2 = document.getElementById(s2);
            s2.innerHTML = "";

            if (s1.value == "Medicine and Health Sciences") {
                var optionArray = ["select|Select", "nursing|Nursing", "clinical medicine|Clinical Medicine", "family medicine|Family Medicine", "public health|Public Health"];
            } else if (s1.value == "Law") {
                var optionArray = ["select|Select", "law|Law"];
            } else if (s1.value == "Business and Economics") {
                var optionArray = ["select|Select", "commerce|Commerce", "economics|Economics", "hospitality & tourism|Hospitality & Tourism"];
            } else if (s1.value == "Science, Engineering and Technology") {
                var optionArray = ["select|Select", "computer science|Computer Science", "information technology|Information Technology", "software engineering|Software Engineering"];
            } else if (s1.value == "Education") {
                var optionArray = ["select|Select", "education|Education", "biology|Biology", "mathematics|Mathematics"];
            } else if (s1.value == "Pharmacy") {
                var optionArray = ["select|Select", "pharmacy|Pharmacy"];
            } else if (s1.value == "Freshman") {
                var optionArray = ["select|Select", "natural|Natural", "social|Social"];
            }

            for (var option in optionArray) {
                var pair = optionArray[option].split("|");
                var newOption = document.createElement("option");
                newOption.value = pair[0];
                newOption.innerHTML = pair[1];
                s2.options.add(newOption);
            }
        }

        function validateForm() {
            let isValid = true;

            const studentIdField = document.getElementById('student_id');
            const studentId = studentIdField.value.trim();
            const regex = /^ddu\d{7}$/i;

            if (!regex.test(studentId)) {
                displayError(studentIdField, 'Student ID must start with "ddu" followed by exactly 7 digits.');
                isValid = false;
            } else {
                clearError(studentIdField);
            }

            const firstNameField = document.getElementById('first_name');
            const firstName = firstNameField.value.trim();
            if (firstName === '') {
                displayError(firstNameField, 'First Name is required.');
                isValid = false;
            } else {
                clearError(firstNameField);
            }

            const fatherNameField = document.getElementById('father_name');
            const fatherName = fatherNameField.value.trim();
            if (fatherName === '') {
                displayError(fatherNameField, 'Father Name is required.');
                isValid = false;
            } else {
                clearError(fatherNameField);
            }

            const gfatherNameField = document.getElementById('gfather_name');
            const gfatherName = gfatherNameField.value.trim();
            if (gfatherName === '') {
                displayError(gfatherNameField, 'Grandfather Name is required.');
                isValid = false;
            } else {
                clearError(gfatherNameField);
            }

            const schoolField = document.getElementById('slct1');
            const school = schoolField.value;
            if (school === 'select') {
                displayError(schoolField, 'Please select a valid school.');
                isValid = false;
            } else {
                clearError(schoolField);
            }

            const departmentField = document.getElementById('slct2');
            const department = departmentField.value;
            if (department === 'select') {
                displayError(departmentField, 'Please select a valid department.');
                isValid = false;
            } else {
                clearError(departmentField);
            }

            return isValid;
        }

        function displayError(element, message) {
            element.classList.add('error');
            let errorMessage = element.nextElementSibling;
            if (!errorMessage || !errorMessage.classList.contains('error-message')) {
                errorMessage = document.createElement('div');
                errorMessage.className = 'error-message';
                element.parentNode.insertBefore(errorMessage, element.nextSibling);
            }
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
        }

        function clearError(element) {
            element.classList.remove('error');
            const errorMessage = element.nextElementSibling;
            if (errorMessage && errorMessage.classList.contains('error-message')) {
                errorMessage.style.display = 'none';
            }
        }
    </script>
</head>
<body>

    <main>
    <div class="container mt-5">
        <h2 class="text-center">DDU STUDENT ADMISSION FORM</h2>
        <form action="insert.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
            <!-- Legend: Student Information -->
            <fieldset>
                <legend>Student Information</legend>
                <div class="form-row">
                    <div class="form-group col-md-4 form-section">
                        <label for="student_id" class="form-label">Student ID:</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" required minlength="10">
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="father_name" class="form-label">Father Name:</label>
                        <input type="text" class="form-control" id="father_name" name="father_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4 form-section">
                        <label for="gfather_name" class="form-label">Grandfather Name:</label>
                        <input type="text" class="form-control" id="gfather_name" name="gfather_name" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label class="form-label">Gender:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" required>
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" required>
                            <label class="form-check-label" for="gender_female">Female</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4 form-section">
                        <label for="enrolment_date" class="form-label">Enrolment Date:</label>
                        <input type="date" class="form-control" id="enrolment_date" name="enrolment_date" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="year" class="form-label">Year:</label>
                        <input type="number" class="form-control" id="year" name="year" min="1" max="6" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="semister" class="form-label">Semester:</label>
                        <input type="number" class="form-control" id="semister" name="semister" min="1" max="2" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4 form-section">
                        <label for="Marital_status" class="form-label">Marital Status:</label>
                        <select class="form-control" id="Marital_status" name="Marital_status" required>
                            <option value="">Select</option>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                            <option value="divorced">Divorced</option>
                            <option value="widowed">Widowed</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="Nationality" class="form-label">Nationality:</label>
                        <select class="form-control" id="Nationality" name="Nationality" required>
                            <option value="">Select</option>
                            <option value="ethiopian">Ethiopian</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
            </fieldset>
            
            <!-- Legend: Academic Information -->
            <fieldset>
                <legend>Academic Information</legend>
                <div class="form-row">
                    <div class="form-group col-md-6 form-section">
                        <label for="slct1" class="form-label">School:</label>
                        <select class="form-control" id="slct1" name="school" onchange="populate(this.id,'slct2')" required>
                            <option value="select">Select</option>
                            <option value="Medicine and Health Sciences">Medicine and Health Sciences</option>
                            <option value="Law">Law</option>
                            <option value="Business and Economics">Business and Economics</option>
                            <option value="Science, Engineering and Technology">Science, Engineering and Technology</option>
                            <option value="Education">Education</option>
                            <option value="Pharmacy">Pharmacy</option>
                            <option value="Freshman">Freshman</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6 form-section">
                        <label for="slct2" class="form-label">Department:</label>
                        <select class="form-control" id="slct2" name="department" required>
                            <option value="select">Select</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <!-- Legend: Amharic Information -->
            <fieldset>
                <legend>In Amharic</legend>
                <div class="form-row">
                    <div class="form-group col-md-4 form-section">
                        <label for="amharic_first_name" class="form-label">First Name:</label>
                        <input type="text" class="form-control" id="amharic_first_name" name="amharic_first_name" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="amharic_middle_name" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" id="amharic_middle_name" name="amharic_middle_name" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="amharic_last_name" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" id="amharic_last_name" name="amharic_last_name" required>
                    </div>
                </div>
            </fieldset>

            <!-- Legend: Family Information -->
            <fieldset>
                <legend>Family Information</legend>
                <div class="form-row">
                    <div class="form-group col-md-6 form-section">
                        <label for="mother_first_name" class="form-label">Mother's First Name:</label>
                        <input type="text" class="form-control" id="mother_first_name" name="mother_first_name" required>
                    </div>
                    <div class="form-group col-md-6 form-section">
                        <label for="mother_last_name" class="form-label">Mother's Last Name:</label>
                        <input type="text" class="form-control" id="mother_last_name" name="mother_last_name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 form-section">
                        <label for="father_occupation" class="form-label">Father's Occupation:</label>
                        <input type="text" class="form-control" id="father_occupation" name="father_occupation" required>
                    </div>
                    <div class="form-group col-md-6 form-section">
                        <label for="mother_occupation" class="form-label">Mother's Occupation:</label>
                        <input type="text" class="form-control" id="mother_occupation" name="mother_occupation" required>
                    </div>
                </div>
            </fieldset>

            <!-- Legend: Contact Information -->
            <fieldset>
                <legend>Contact Information</legend>
                <div class="form-row">
                    <div class="form-group col-md-6 form-section">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group col-md-6 form-section">
                        <label for="phone_number" class="form-label">Phone Number:</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                </div>
            </fieldset>

            <!-- Legend: Birth Information -->
            <fieldset>
                <legend>Birth Information</legend>
                <div class="form-row">
                    <div class="form-group col-md-6 form-section">
                        <label for="dob2" class="form-label">Date of Birth:</label>
                        <input type="date" class="form-control" id="dob2" name="dob2" required>
                    </div>
                    <div class="form-group col-md-6 form-section">
                        <label for="birth_place" class="form-label">Birth Place:</label>
                        <input type="text" class="form-control" id="birth_place" name="birth_place" required>
                    </div>
                </div>
            </fieldset>

            <!-- Legend: Other Information -->
            <fieldset>
                <legend>Other Information</legend>
                <div class="form-row">
                    <div class="form-group col-md-6 form-section">
                    <label for="religion" class="form-label">Religion:</label>
                    <select class="form-control" id="religion" name="religion" required>
                        <option value="muslim">Muslim</option>
                        <option value="christian">Christian</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group col-md-6 form-section">
                    <label for="ethnic" class="form-label">Ethnic:</label>
                    <select class="form-control" id="ethnic" name="ethnic" required>
                        <option value="oromo">Oromo</option>
                        <option value="amhara">Amhara</option>
                        <option value="tigray">Tigray</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </fieldset>

            <!-- Legend: Photo Upload -->
            <fieldset>
                <legend>Upload Photo</legend>
                <div class="form-row">
                    <div class="form-group col-md-12 form-section">
                        <label for="photo" class="form-label">Photo:</label>
                        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" required>
                    </div>
                </div>
            </fieldset>

            <!-- Buttons -->
            <div class="text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>
        </main>
    
    <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>DDU UNIVERSITY</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      <!-- <a href="https://bootstrapmade.com/"></a> -->
    </div>
  </footer><!-- End Footer -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
