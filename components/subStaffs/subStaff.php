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
                    <b><span class="title">Department Information</span></b>
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
                            <select id="collegeName" name="collegeName" required></select>
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
                            <label>Position</label>
                            <select id="role" name="role" required>
                                <option value="DepartmentHead">Department Head</option>
                            </select>
                            <small class="error" id="roleError"></small>
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

        document.addEventListener('DOMContentLoaded', async function () {
            const departmentOptions = {
                "Business and Economics": [
                    { value: 'Accounting and Finance', text: 'Accounting and Finance' },
                    { value: 'Banking and Finance', text: 'Banking and Finance' },
                    { value: 'Logistics and Supplies Chain Management', text: 'Logistics and Supplies Chain Management' },
                    { value: 'Management', text: 'Management' },
                    { value: 'Marketing Management', text: 'Marketing Management' },
                    { value: 'Public Administration and Development Management', text: 'Public Administration and Development Management' },
                    { value: 'Economics', text: 'Economics' },
                    { value: 'Land and Real Property Valuation', text: 'Land and Real Property Valuation' }
                ],
                "Electrical and computer engineering": [
                    { value: 'Electrical and computer engineering', text: 'Electrical and computer engineering' },
                ],
                "School of Chemical and BioEngineering": [
                    { value: 'Food Processing engineering', text: 'Food Processing engineering' },
                    { value: 'Chemical engineering', text: 'Chemical engineering' }
                ],
                "School of Textile and Fashion Design": [
                    { value: 'Textile engineering', text: 'Textile engineering' },
                    { value: 'Apparel and fashion design', text: 'Apparel and fashion design' }
                ],
                "School of Civil Eng and Architecture": [
                    { value: 'Architecture', text: 'Architecture' },
                    { value: 'Civil engineering', text: 'Civil engineering' },
                    { value: 'Construction technology and management', text: 'Construction technology and management' },
                    { value: 'Surveying engineering', text: 'Surveying engineering' }
                ],
                "School of Mechanical and Industrial Engineering": [
                    { value: 'Industrial engineering', text: 'Industrial engineering' },
                    { value: 'Mechanical engineering', text: 'Mechanical engineering' }
                ],
                "School of Computing": [
                    { value: 'Software Engineering', text: 'Software Engineering' },
                    { value: 'Information technology', text: 'Information technology' },
                    { value: 'Computer Science', text: 'Computer Science' }
                ],
                "College of medicine and health science": [
                    { value: 'Anesthesia', text: 'Anesthesia' },
                    { value: 'Laboratory', text: 'Laboratory' },
                    { value: 'Medicine', text: 'Medicine' },
                    { value: 'Nursing', text: 'Nursing' },
                    { value: 'Psychiatry', text: 'Psychiatry' },
                    { value: 'Public Health', text: 'Public Health' }
                ],
                
                "College of Law": [
                    { value: 'Law', text: 'Law' }
                ],
                "College of Natural and Computational Science": [
                    { value: 'Biology', text: 'Biology' },
                    { value: 'Chemistry', text: 'Chemistry' },
                    { value: 'Geology', text: 'Geology' },
                    { value: 'Physics', text: 'Physics' },
                    { value: 'Mathematics', text: 'Mathematics' },
                    { value: 'Statistics', text: 'Statistics' },
                    { value: 'Sport Science', text: 'Sport Science' }
                ],
                "College of Social Science and Humanity": [
                    { value: 'AfSomali and Literature', text: 'AfSomali and Literature' },
                    { value: 'AfanOromo and Literature', text: 'AfanOromo and Literature' },
                    { value: 'Amharic Language and Literature', text: 'Amharic Language and Literature' },
                    { value: 'English Language and Literature', text: 'English Language and Literature' },
                    { value: 'Journalism and Communication', text: 'Journalism and Communication' },
                    { value: 'Geography and Enviromental Studies', text: 'Geography and Enviromental Studies' },
                    { value: 'History and Heritage Management', text: 'History and Heritage Management' },
                    { value: 'Sociology and Social Anthropology', text: 'Sociology and Social Anthropology' },
                    { value: 'Political Science and International Relation', text: 'Political Science and International Relation' },
                    { value: 'Civics and Ethical Studies', text: 'Civics and Ethical Studies' },
                    { value: 'Psychology', text: 'Psychology' }


                    
                ]
            };

            async function fetchSchoolName() {
                try {
                    const response = await fetch('fetch_school_name.php');
                    const data = await response.json();
                    if (data.schoolName) {
                        const collegeNameSelect = document.getElementById('collegeName');
                        collegeNameSelect.innerHTML = `<option value="${data.schoolName}" selected>${data.schoolName}</option>`;
                        collegeNameSelect.disabled = false; // Make it read-only
                    } else {
                        document.getElementById('collegeNameError').innerText = 'Error fetching school name';
                    }
                } catch (error) {
                    document.getElementById('collegeNameError').innerText = 'Error fetching school name';
                }
            }

            function fetchDepartments() {
                const collegeName = document.getElementById('collegeName').value;
                const departmentSelect = document.getElementById('department');
                departmentSelect.innerHTML = '<option value="" disabled selected>Select Department</option>';
                if (departmentOptions[collegeName]) {
                    departmentOptions[collegeName].forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.value;
                        option.textContent = dept.text;
                        departmentSelect.appendChild(option);
                    });
                }
            }

            await fetchSchoolName();
            fetchDepartments();

            document.getElementById('collegeName').addEventListener('change', fetchDepartments);

            document.getElementById('registrationForm').addEventListener('submit', async function (e) {
                e.preventDefault();

                const isValidFName = validateName('fName', 'fNameError');
                const isValidMName = validateName('mName', 'mNameError');
                const isValidLName = validateName('lName', 'lNameError');
                const isValidPhone = validatePhone();
                const isValidPassword = validatePassword();
                const isValidDate = validateDate();
                const isValidEmail = await validateEmail();

                if (isValidFName && isValidMName && isValidLName && isValidPhone && isValidPassword && isValidDate && isValidEmail) {
                    const formData = new FormData(this);
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                    });
                    const result = await response.json();
                    if (result.status === 'success') {
                        alert('Form submitted successfully.');
                        window.location.reload();
                    } else {
                        alert('There was an error submitting the form.');
                    }
                }
            });
        });
    </script>
</body>
</html>
