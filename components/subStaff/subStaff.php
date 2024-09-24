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
                <b><span class="title">department staff information</span></b>
                   
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
                                <option value="LabAssistant">LabAssistant</option>
                            </select>
                            <small class="error" id="roleError"></small>
                        </div>
                        <!-- <div class="input-field">
                            <label>Role</label>
                            <input type="text" placeholder="Roll" name="position" id="position" required>
                            <small class="error" id="positionError"></small>
                        </div> -->
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
    
    try {
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
    } catch (err) {
        console.error('Error validating email:', err);
        error.textContent = 'Error validating email.';
        return false;
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
        try {
            // Fetch school name and department based on logged-in user
            const response = await fetch('fetch_user_details.php');
            const data = await response.json();

            if (data.error) {
                console.error(data.error);
                document.getElementById('collegeNameError').innerText = data.error;
                document.getElementById('departmentNameError').innerText = data.error;
                return;
            }

            const collegeNameSelect = document.getElementById('collegeName');
            const departmentSelect = document.getElementById('department');

            // Populate college name and department fields
            if (data.collegeName) {
                collegeNameSelect.innerHTML = `<option value="${data.collegeName}" selected>${data.collegeName}</option>`;
                collegeNameSelect.disabled = false; // Make it read-only
            } else {
                collegeNameSelect.innerHTML = '<option value="" disabled>No college name found</option>';
                collegeNameSelect.disabled = true; // Make it read-only
            }

            if (data.department) {
                departmentSelect.innerHTML = `<option value="${data.department}" selected>${data.department}</option>`;
                departmentSelect.disabled = false; // Make it read-only
            } else {
                departmentSelect.innerHTML = '<option value="" disabled>No department found</option>';
                departmentSelect.disabled = true; // Make it read-only
            }
        } catch (error) {
            console.error('Error fetching user details:', error);
        }
    });    

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
        // document.getElementById('position').addEventListener('blur', validatePosition);
        document.getElementById('phone').addEventListener('blur', validatePhone);
        document.getElementById('email').addEventListener('blur', validateEmail);
        document.getElementById('password').addEventListener('blur', validatePassword);
        document.getElementById('date').addEventListener('blur', validateDate);
        document.getElementById('collegeName').addEventListener('blur', () => validateSelect('collegeName', 'collegeNameError'));
        document.getElementById('department').addEventListener('blur', () => validateSelect('department', 'departmentNameError'));
        document.getElementById('year').addEventListener('blur', () => validateSelect('year', 'yearError'));
        document.getElementById('semester').addEventListener('blur', () => validateSelect('semester', 'semesterError'));

        document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('registrationForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent form from submitting the traditional way

        // Validate all the required fields
        const isValidFName = true; // Add your validation logic here
        const isValidMName = true; // Add your validation logic here
        const isValidLName = true; // Add your validation logic here
        const isValidPhone = true; // Add your validation logic here
        const isValidPassword = true; // Add your validation logic here
        const isValidDate = true; // Add your validation logic here
        const isValidEmail = true; // Add your validation logic here

        if (isValidFName && isValidMName && isValidLName && isValidPhone && isValidPassword && isValidDate && isValidEmail) {
            const formData = new FormData(this);
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                });
                const result = await response.json();
                if (result.status === 'success') {
                    alert('Form submitted successfully.');
                    window.location.reload(); // Reload the page after successful submission
                } else {
                    alert(`There was an error: ${result.message}`);
                }
            } catch (error) {
                console.error('Error submitting the form:', error);
                alert('There was an error processing your request.');
            }
        } else {
            alert('Please fill out all required fields correctly.');
        }
    });
});

    </script>
</body>
</html>
