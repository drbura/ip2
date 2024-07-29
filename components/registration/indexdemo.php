<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Student Registration</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Roboto', sans-serif;
        }
        .dashboard-container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }
        .registration-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
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

            const nationalityField = document.getElementById('nationality');
            const nationality = nationalityField.value.trim();
            if (nationality === '') {
                displayError(nationalityField, 'Nationality is required.');
                isValid = false;
            } else {
                clearError(nationalityField);
            }

            const phoneField = document.getElementById('phone_number');
            const phone = phoneField.value.trim();
            if (phone === '' || isNaN(phone)) {
                displayError(phoneField, 'Valid phone number is required.');
                isValid = false;
            } else {
                clearError(phoneField);
            }

            const emailField = document.getElementById('email');
            const email = emailField.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email === '' || !emailRegex.test(email)) {
                displayError(emailField, 'Valid email is required.');
                isValid = false;
            } else {
                clearError(emailField);
            }

            const cityField = document.getElementById('city');
            const city = cityField.value.trim();
            if (city === '') {
                displayError(cityField, 'City is required.');
                isValid = false;
            } else {
                clearError(cityField);
            }

            const woredaField = document.getElementById('woreda');
            const woreda = woredaField.value.trim();
            if (woreda === '') {
                displayError(woredaField, 'Woreda is required.');
                isValid = false;
            } else {
                clearError(woredaField);
            }

            const kebeleField = document.getElementById('kebele');
            const kebele = kebeleField.value.trim();
            if (kebele === '') {
                displayError(kebeleField, 'Kebele is required.');
                isValid = false;
            } else {
                clearError(kebeleField);
            }

            const houseNumberField = document.getElementById('house_number');
            const houseNumber = houseNumberField.value.trim();
            if (houseNumber === '') {
                displayError(houseNumberField, 'House Number is required.');
                isValid = false;
            } else {
                clearError(houseNumberField);
            }

            const dobField = document.getElementById('dob');
            const dob = dobField.value.trim();
            if (dob === '') {
                displayError(dobField, 'Date of Birth is required.');
                isValid = false;
            } else {
                clearError(dobField);
            }

            const pobField = document.getElementById('pob');
            const pob = pobField.value.trim();
            if (pob === '') {
                displayError(pobField, 'Place of Birth is required.');
                isValid = false;
            } else {
                clearError(pobField);
            }

            const genderField = document.querySelector('input[name="gender"]:checked');
            if (!genderField) {
                document.getElementById('genderError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('genderError').style.display = 'none';
            }

            const maritalStatusField = document.getElementById('marital_status');
            const maritalStatus = maritalStatusField.value;
            if (maritalStatus === '') {
                displayError(maritalStatusField, 'Marital status is required.');
                isValid = false;
            } else {
                clearError(maritalStatusField);
            }

            const disabilityField = document.querySelector('input[name="disability"]:checked');
            if (!disabilityField) {
                document.getElementById('disabilityError').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('disabilityError').style.display = 'none';
            }

            const emergencyContactNameField = document.getElementById('emergency_contact_name');
            const emergencyContactName = emergencyContactNameField.value.trim();
            if (emergencyContactName === '') {
                displayError(emergencyContactNameField, 'Emergency contact name is required.');
                isValid = false;
            } else {
                clearError(emergencyContactNameField);
            }

            const emergencyContactPhoneField = document.getElementById('emergency_contact_phone');
            const emergencyContactPhone = emergencyContactPhoneField.value.trim();
            if (emergencyContactPhone === '' || isNaN(emergencyContactPhone)) {
                displayError(emergencyContactPhoneField, 'Valid emergency contact phone number is required.');
                isValid = false;
            } else {
                clearError(emergencyContactPhoneField);
            }

            return isValid;
        }

        function displayError(field, message) {
            const errorMessage = field.nextElementSibling;
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
            field.classList.add('error');
        }

        function clearError(field) {
            const errorMessage = field.nextElementSibling;
            errorMessage.textContent = '';
            errorMessage.style.display = 'none';
            field.classList.remove('error');
        }

        function updateRecentEntry() {
            if (!validateForm()) {
                return false;
            }

            document.getElementById('recent-student-id').textContent = document.getElementById('student_id').value;
            document.getElementById('recent-first-name').textContent = document.getElementById('first_name').value;
            document.getElementById('recent-father-name').textContent = document.getElementById('father_name').value;
            document.getElementById('recent-gfather-name').textContent = document.getElementById('gfather_name').value;
            document.getElementById('recent-school').textContent = document.getElementById('slct1').value;
            document.getElementById('recent-department').textContent = document.getElementById('slct2').value;
            document.getElementById('recent-nationality').textContent = document.getElementById('nationality').value;
            document.getElementById('recent-phone-number').textContent = document.getElementById('phone_number').value;
            document.getElementById('recent-email').textContent = document.getElementById('email').value;
            document.getElementById('recent-city').textContent = document.getElementById('city').value;
            document.getElementById('recent-woreda').textContent = document.getElementById('woreda').value;
            document.getElementById('recent-kebele').textContent = document.getElementById('kebele').value;
            document.getElementById('recent-house-number').textContent = document.getElementById('house_number').value;
            document.getElementById('recent-dob').textContent = document.getElementById('dob').value;
            document.getElementById('recent-pob').textContent = document.getElementById('pob').value;
            document.getElementById('recent-gender').textContent = document.querySelector('input[name="gender"]:checked').value;
            document.getElementById('recent-marital-status').textContent = document.getElementById('marital_status').value;
            document.getElementById('recent-disability').textContent = document.querySelector('input[name="disability"]:checked').value;
            document.getElementById('recent-emergency-contact-name').textContent = document.getElementById('emergency_contact_name').value;
            document.getElementById('recent-emergency-contact-phone').textContent = document.getElementById('emergency_contact_phone').value;

            alert("Form submitted successfully!");
            return false; // Prevent form submission
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Dashboard Header -->
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1>Dashboard</h1>
            <nav>
                <a href="#" class="btn btn-secondary">Home</a>
                <a href="#" class="btn btn-secondary">Reports</a>
                <a href="#" class="btn btn-secondary">Settings</a>
            </nav>
        </header>

        <!-- Registration Form -->
        <div class="registration-container">
            <h2>Student Registration Form</h2>
            <form onsubmit="return updateRecentEntry()">
                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="form-group">
                        <label for="student_id" class="form-label">Student ID:</label>
                        <input type="text" id="student_id" name="student_id" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="father_name" class="form-label">Father Name:</label>
                        <input type="text" id="father_name" name="father_name" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="gfather_name" class="form-label">Grandfather Name:</label>
                        <input type="text" id="gfather_name" name="gfather_name" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="nationality" class="form-label">Nationality:</label>
                        <input type="text" id="nationality" name="nationality" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="phone_number" class="form-label">Phone Number:</label>
                        <input type="tel" id="phone_number" name="phone_number" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Address Information</legend>
                    <div class="form-group">
                        <label for="city" class="form-label">City:</label>
                        <input type="text" id="city" name="city" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="woreda" class="form-label">Woreda:</label>
                        <input type="text" id="woreda" name="woreda" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="kebele" class="form-label">Kebele:</label>
                        <input type="text" id="kebele" name="kebele" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="house_number" class="form-label">House Number:</label>
                        <input type="text" id="house_number" name="house_number" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Birth Information</legend>
                    <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="pob" class="form-label">Place of Birth:</label>
                        <input type="text" id="pob" name="pob" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Additional Information</legend>
                    <div class="form-group">
                        <label class="form-label">Gender:</label><br>
                        <input type="radio" id="male" name="gender" value="Male">
                        <label for="male" class="form-check-label">Male</label><br>
                        <input type="radio" id="female" name="gender" value="Female">
                        <label for="female" class="form-check-label">Female</label><br>
                        <div id="genderError" class="error-message">Gender is required.</div>
                    </div>
                    <div class="form-group">
                        <label for="marital_status" class="form-label">Marital Status:</label>
                        <select id="marital_status" name="marital_status" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                        </select>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Disability:</label><br>
                        <input type="radio" id="disability_yes" name="disability" value="Yes">
                        <label for="disability_yes" class="form-check-label">Yes</label><br>
                        <input type="radio" id="disability_no" name="disability" value="No">
                        <label for="disability_no" class="form-check-label">No</label><br>
                        <div id="disabilityError" class="error-message">Disability status is required.</div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>School Information</legend>
                    <div class="form-group">
                        <label for="slct1" class="form-label">School:</label>
                        <select id="slct1" name="slct1" class="form-control" onchange="populate('slct1','slct2')" required>
                            <option value="select">Select</option>
                            <option value="Medicine and Health Sciences">Medicine and Health Sciences</option>
                            <option value="Law">Law</option>
                            <option value="Business and Economics">Business and Economics</option>
                            <option value="Science, Engineering and Technology">Science, Engineering and Technology</option>
                            <option value="Education">Education</option>
                            <option value="Pharmacy">Pharmacy</option>
                            <option value="Freshman">Freshman</option>
                        </select>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="slct2" class="form-label">Department:</label>
                        <select id="slct2" name="slct2" class="form-control" required>
                            <option value="select">Select</option>
                        </select>
                        <div class="error-message"></div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Emergency Contact Information</legend>
                    <div class="form-group">
                        <label for="emergency_contact_name" class="form-label">Contact Name:</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group">
                        <label for="emergency_contact_phone" class="form-label">Contact Phone:</label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" class="form-control" required>
                        <div class="error-message"></div>
                    </div>
                </fieldset>

                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>

        <!-- Recent Entry -->
        <div class="registration-container mt-4">
            <h2>Recent Entry</h2>
            <div id="recent-entry">
                <p><strong>Student ID:</strong> <span id="recent-student-id"></span></p>
                <p><strong>First Name:</strong> <span id="recent-first-name"></span></p>
                <p><strong>Father Name:</strong> <span id="recent-father-name"></span></p>
                <p><strong>Grandfather Name:</strong> <span id="recent-gfather-name"></span></p>
                <p><strong>School:</strong> <span id="recent-school"></span></p>
                <p><strong>Department:</strong> <span id="recent-department"></span></p>
                <p><strong>Nationality:</strong> <span id="recent-nationality"></span></p>
                <p><strong>Phone Number:</strong> <span id="recent-phone-number"></span></p>
                <p><strong>Email:</strong> <span id="recent-email"></span></p>
                <p><strong>City:</strong> <span id="recent-city"></span></p>
                <p><strong>Woreda:</strong> <span id="recent-woreda"></span></p>
                <p><strong>Kebele:</strong> <span id="recent-kebele"></span></p>
                <p><strong>House Number:</strong> <span id="recent-house-number"></span></p>
                <p><strong>Date of Birth:</strong> <span id="recent-dob"></span></p>
                <p><strong>Place of Birth:</strong> <span id="recent-pob"></span></p>
                <p><strong>Gender:</strong> <span id="recent-gender"></span></p>
                <p><strong>Marital Status:</strong> <span id="recent-marital-status"></span></p>
                <p><strong>Disability:</strong> <span id="recent-disability"></span></p>
                <p><strong>Emergency Contact Name:</strong> <span id="recent-emergency-contact-name"></span></p>
                <p><strong>Emergency Contact Phone:</strong> <span id="recent-emergency-contact-phone"></span></p>
            </div>
        </div>
    </div>
</body>
</html>
