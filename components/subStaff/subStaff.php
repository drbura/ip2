<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="subStaffStyle.css">
    <style>
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        .input-field {
            margin-bottom: 15px;
        }

        .input-field input, .input-field select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <title>User Page</title>
</head>
<body>
    <div class="container">
        <form id="registrationForm" action="submit_form.php" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Substaff Registration Form</span>
                    <div class="fields">
                        <div class="input-field">
                            <label>First Name</label>
                            <input type="text" placeholder="Enter first name" name="fName" id="fName" required>
                            <small class="error" id="fNameError"></small>
                        </div>
                        <div class="input-field">
                            <label>Middle Name</label>
                            <input type="text" placeholder="Enter middle name" name="mName" id="mName" required>
                            <small class="error" id="mNameError"></small>
                        </div>
                        <div class="input-field">
                            <label>Last Name</label>
                            <input type="text" placeholder="Enter last name" name="lName" id="lName" required>
                            <small class="error" id="lNameError"></small>
                        </div>
                       
                        <div class="input-field">
                            <label>College/School Name</label>
                            <select id="collegeName" name="collegeName" required>
                                <option value="" disabled selected>School/College</option>
                                <option value="computation">School of Computation</option>
                                <option value="law">School of Law</option>
                                <option value="medicine">College of Medicine</option>
                            </select>
                            <small class="error" id="collegeNameError"></small>
                        </div>
                       
                        <div class="input-field">
                            <label>Department</label>
                            <select id="department" name="department" required>
                                <option value="" disabled selected>Select Department</option>
                            </select>
                            <small class="error" id="departmentNameError"></small>
                        </div>
                       
                        <div class="input-field">
                            <label>Year</label>
                            <select id="year" name="year" required>
                                <option value="" disabled selected>Year</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                                <option value="5">5th Year</option>
                                <option value="6">6th Year</option>
                                <option value="7">7th Year</option>
                            </select>
                            <small class="error" id="yearError"></small>
                        </div>
                        
                        <div class="input-field">
                            <label>Semester</label>
                            <select id="semester" name="semester" required>
                                <option value="" disabled selected>Semester</option>
                                <option value="1">1st Semester</option>
                                <option value="2">2nd Semester</option>
                            </select>
                            <small class="error" id="semesterError"></small>
                        </div>
                        <div class="input-field">
                            <label>Position</label>
                            <select id="role" name="role" required>
                                <option value="" disabled selected>Select Position</option>
                                <option value="Advisor">Advisor</option>
                                <option value="LabAssistant">Lab Assistant</option>
                            </select>
                            <small class="error" id="roleError"></small>
                        </div>
                        <div class="input-field">
                            <label>Roll</label>
                            <input type="text" placeholder="Roll" name="position" id="position" required>
                            <small class="error" id="positionError"></small>
                        </div>
                        <div class="input-field">
                            <label>Mobile Number</label>
                            <input type="text" placeholder="Enter mobile number" name="phone" id="phone" required>
                            <small class="error" id="phoneError"></small>
                        </div>
                        <div class="input-field">
                            <label>Email</label>
                            <input type="email" placeholder="Enter email" name="email" id="email" required>
                            <small class="error" id="emailError"></small>
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" placeholder="Set password" name="password" id="password" required>
                            <small class="error" id="passwordError"></small>
                        </div>
                        <div class="input-field">
                            <label>Date</label>
                            <input type="date" name="date" id="date" required>
                            <small class="error" id="dateError"></small>
                        </div>
                    </div>
                </div>
                <div class="input-field">
                    <input type="submit" value="Add">
                    <br><br><br>
                </div>
                <div class="details ID">
                    <div class="fields">
                    </div>
                </div>
            
            
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const departmentOptions = {
                computation: [
                    { value: 'cs', text: 'Computer Science' },
                    { value: 'it', text: 'Information Technology' },
                    { value: 'se', text: 'Software Engineering' }
                ],
                law: [
                    { value: 'civil', text: 'Civil Law' },
                    { value: 'criminal', text: 'Criminal Law' }
                ],
                medicine: [
                    { value: 'general', text: 'General Medicine' },
                    { value: 'dentistry', text: 'Dentistry' }
                ]
            };

            document.getElementById('collegeName').addEventListener('change', function() {
                const college = this.value;
                const departmentSelect = document.getElementById('department');
                departmentSelect.innerHTML = '<option value="" disabled selected>Select Department</option>';

                if (departmentOptions[college]) {
                    departmentOptions[college].forEach(department => {
                        const option = document.createElement('option');
                        option.value = department.value;
                        option.textContent = department.text;
                        departmentSelect.appendChild(option);
                    });
                }
            });
        });

        function validateName(inputId, errorId) {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);
            const namePattern = /^[A-Za-z]+$/;
            if (!input.value.match(namePattern)) {
                error.textContent = 'Must be letters only.';
                return false;
            } else {
                error.textContent = '';
                input.value = input.value.toUpperCase();
                return true;
            }
        }

        function validatePosition() {
            const input = document.getElementById('role');
            const error = document.getElementById('roleError');
            const rolePattern = /^[A-Za-z\s]+$/;
            if (!input.value.match(rolePattern)) {
                error.textContent = 'Position must be letters only.';
                return false;
            } else {
                error.textContent = '';
                return true;
            }
        }

        function validatePhone() {
            const input = document.getElementById('phone');
            const error = document.getElementById('phoneError');
            const phonePattern = /^(07|09)\d{8}$/;
            if (!input.value.match(phonePattern)) {
                error.textContent = 'Must start with 07 or 09 and be 10 digits long.';
                return false;
            } else {
                error.textContent = '';
                return true;
            }
        }

        async function validateEmail() {
            const input = document.getElementById('email');
            const error = document.getElementById('emailError');
            const response = await fetch('check_email.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'email=' + encodeURIComponent(input.value),
            });
            const data = await response.text();
            if (data === 'exists') {
                error.textContent = 'Email is already taken.';
                return false;
            } else {
                error.textContent = '';
                return true;
            }
        }

        function validatePassword() {
            const input = document.getElementById('password');
            const error = document.getElementById('passwordError');
            if (input.value.length !== 6) {
                error.textContent = 'Password must be 6 digits long.';
                return false;
            } else {
                error.textContent = '';
                return true;
            }
        }

        function validateDate() {
            const input = document.getElementById('date');
            const error = document.getElementById('dateError');
            if (!input.value) {
                error.textContent = 'Please select a date.';
                return false;
            } else {
                error.textContent = '';
                return true;
            }
        }

        function validateSelect(selectId, errorId) {
            const select = document.getElementById(selectId);
            const error = document.getElementById(errorId);
            if (select.value === '') {
                error.textContent = 'Please make a selection.';
                return false;
            } else {
                error.textContent = '';
                return true;
            }
        }

        document.getElementById('fName').addEventListener('blur', () => validateName('fName', 'fNameError'));
        document.getElementById('mName').addEventListener('blur', () => validateName('mName', 'mNameError'));
        document.getElementById('lName').addEventListener('blur', () => validateName('lName', 'lNameError'));
        document.getElementById('role').addEventListener('blur', validateRole);
        document.getElementById('position').addEventListener('blur', validatePosition);
        document.getElementById('phone').addEventListener('blur', validatePhone);
        document.getElementById('email').addEventListener('blur', validateEmail);
        document.getElementById('password').addEventListener('blur', validatePassword);
        document.getElementById('date').addEventListener('blur', validateDate);
        document.getElementById('collegeName').addEventListener('blur', () => validateSelect('collegeName', 'collegeNameError'));
        document.getElementById('department').addEventListener('blur', () => validateSelect('department', 'departmentNameError'));
        document.getElementById('year').addEventListener('blur', () => validateSelect('year', 'yearError'));
        document.getElementById('semester').addEventListener('blur', () => validateSelect('semester', 'semesterError'));

        document.getElementById('registrationForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent default form submission

            let valid = true;
            valid = validateName('fName', 'fNameError') && valid;
            valid = validateName('mName', 'mNameError') && valid;
            valid = validateName('lName', 'lNameError') && valid;
            valid = validateRole() && valid;
            valid = validatePosition() && valid;
            valid = validatePhone() && valid;
            valid = await validateEmail() && valid;
            valid = validatePassword() && valid;
            valid = validateDate() && valid;
            valid = validateSelect('collegeName', 'collegeNameError') && valid;
            valid = validateSelect('department', 'departmentNameError') && valid;
            valid = validateSelect('year', 'yearError') && valid;
            valid = validateSelect('semester', 'semesterError') && valid;

            if (valid) {
                const formData = new FormData(document.getElementById('registrationForm'));
                fetch('submit_form.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User added successfully');
                        window.location.reload(); // Reload the form after user clicks "OK"
                    } else {
                        alert('There was an error adding the user.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error adding the user.');
                });
            }
        });
    </script>
</body>
</html>
