<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="style.css">
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
            background-color: #1b5bb1;
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
                    <span class="title"> <b>staff information</b> </span>
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
                            <label>Staff</label>
                            <select id="staff" name="staff" onchange="toggleCollegeName()" required>
                                <option value="" disabled selected>---Select Role---</option>
                                <option value="BookStore">Book Store</option>
                                <option value="Library">Library</option>
                                <option value="Cafeteria">Cafeteria</option>
                                <option value="StudentLoan">Student Loan</option>
                                <option value="Dormitory">Dormitory</option>
                                <option value="StudentService">Student Service</option>
                                <option value="Store">Store</option>
                                <option value="AcademicEnrollment">Enrollment and Academic Record</option>
                                <option value="SchoolDean">College/School</option>
                            </select>
                            <small class="error" id="staffError"></small>
                        </div>
                        <div class="input-field" id="collegeNameField" style="display:none;">
                            <label>College/School Name</label>
                            <select id="collegeName" name="collegeName" required>
                                <option value="" disabled selected>Select school or college</option>
                                <option value="Business and Economics">Business and Economics</option>
                                <option value="Electrical and computer engineering">Electrical and computer engineering</option>
                                <option value="School of Chemical and BioEngineering">School of Chemical and BioEngineering</option>
                                <option value="School of Textile and Fashion Design">School of Textile and Fashion Design</option>
                                <option value="School of Civil Eng and Architecture">School of Civil Eng and Architecture</option>
                                <option value="School of Mechanical and Industrial Engineering">School of Mechanical and Industrial Engineering</option>
                                <option value="School of Computing">School of Computing</option>
                                <option value="College of Medicine and health science">College of Medicine and health science</option>
                                <option value="College of Law">College of Law</option>
                                <option value="College of Natural and Computational Science">College of Natural and Computational Science</option>
                                <option value="College of Social Science and Humanity">College of Social Science and Humanity</option>
                            </select>
                            <small class="error" id="collegeNameError"></small>
                        </div>
                        
                        <div class="input-field">
                            <label>Role</label>
                            <input type="text" placeholder="Role" name="role" id="role" required>
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
                </div>
                <div class="details ID">
                    <div class="fields">
                </div>
            </div>
        </form>
    </div>
    <script>
    function toggleCollegeName() {
        const roll = document.getElementById('staff').value;
        const collegeNameField = document.getElementById('collegeNameField');
        const collegeNameInput = document.getElementById('collegeName');
        
        if (roll === 'SchoolDean') {
            collegeNameField.style.display = 'block';
            collegeNameInput.setAttribute('required', 'required');
        } else {
            collegeNameField.style.display = 'none';
            collegeNameInput.removeAttribute('required');
        }
    }

    // Ensure to call toggleCollegeName function on page load to set the initial state
    document.addEventListener('DOMContentLoaded', toggleCollegeName);

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
            error.textContent = 'Must be letters only.';
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

    // Function to validate staff role and disable options if already registered
    async function validateStaff() {
        const select = document.getElementById('staff');
        const collegeName = document.getElementById('collegeName').value;
        const error = document.getElementById('staffError');
        const staffRole = select.value;
        
        if (staffRole === '') {
            error.textContent = 'Please choose a staff role.';
            return false;
        }

        try {
            const response = await fetch('check_staff.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `role=${encodeURIComponent(staffRole)}&collegeName=${encodeURIComponent(collegeName)}`,
            });
            const data = await response.json();

            // Enable or disable options based on the server response
            const options = select.querySelectorAll('option');
            options.forEach(option => {
                if (data.staffExists && option.value === staffRole) {
                    option.disabled = true;
                    option.textContent = option.textContent.replace(' (Unavailable)', '') + ' (Unavailable)';
                } else {
                    option.disabled = false;
                    option.textContent = option.textContent.replace(' (Unavailable)', '');
                }
            });

            if (staffRole !== 'SchoolDean' && data.staffExists) {
                error.textContent = 'A staff member with this role already exists for this college/school.';
                return false;
            } else {
                error.textContent = '';
                return true;
            }
        } catch (error) {
            console.error('Error validating staff:', error);
            error.textContent = 'There was an error validating staff.';
            return false;
        }
    }

    // Function to validate college name and disable options if School Dean is already registered
    async function validateCollegeName() {
        const collegeNameSelect = document.getElementById('collegeName');
        const error = document.getElementById('collegeNameError');
        const staffRole = document.getElementById('staff').value;

        if (staffRole === 'SchoolDean') {
            if (collegeNameSelect.value === '') {
                error.textContent = 'Please select a college/school.';
                return false;
            }

            try {
                const response = await fetch('check_staff.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `collegeName=${encodeURIComponent(collegeNameSelect.value)}`,
                });
                const data = await response.json();

                // Disable the college/school option if a School Dean already exists
                const options = collegeNameSelect.querySelectorAll('option');
                options.forEach(option => {
                    if (data.schoolDeanExists && option.value === collegeNameSelect.value) {
                        option.disabled = true;
                        option.textContent = option.textContent.replace(' (Unavailable)', '') + ' (Unavailable)';
                    } else {
                        option.disabled = false;
                        option.textContent = option.textContent.replace(' (Unavailable)', '');
                    }
                });

                if (data.schoolDeanExists) {
                    error.textContent = 'A School Dean is already registered for this college/school.';
                    return false;
                } else {
                    error.textContent = '';
                    return true;
                }
            } catch (error) {
                console.error('Error validating college name:', error);
                error.textContent = 'There was an error validating the college/school name.';
                return false;
            }
        } else {
            error.textContent = '';
            return true;
        }
    }

    // Ensure to call these functions on relevant events
    document.getElementById('staff').addEventListener('change', validateCollegeName);
    document.getElementById('staff').addEventListener('change', validateStaff);

    document.getElementById('fName').addEventListener('blur', () => validateName('fName', 'fNameError'));
    document.getElementById('mName').addEventListener('blur', () => validateName('mName', 'mNameError'));
    document.getElementById('lName').addEventListener('blur', () => validateName('lName', 'lNameError'));
    document.getElementById('role').addEventListener('blur', validatePosition);
    document.getElementById('phone').addEventListener('blur', validatePhone);
    document.getElementById('email').addEventListener('blur', validateEmail);
    document.getElementById('password').addEventListener('blur', validatePassword);
    document.getElementById('date').addEventListener('blur', validateDate);

    document.getElementById('registrationForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Prevent default form submission

        let valid = true;
        valid = validateName('fName', 'fNameError') && valid;
        valid = validateName('mName', 'mNameError') && valid;
        valid = validateName('lName', 'lNameError') && valid;
        valid = validatePosition() && valid;
        valid = validatePhone() && valid;
        valid = await validateEmail() && valid; // Wait for validateEmail to complete
        valid = validatePassword() && valid;
        valid = validateDate() && valid;
        valid = await validateStaff() && valid; // Wait for validateStaff to complete
        valid = await validateCollegeName() && valid; // Wait for validateCollegeName to complete

        const staff = document.getElementById('staff').value;
        if (staff === 'SchoolDean') {
            valid = valid && document.getElementById('collegeName').value !== '';
        }

        if (valid) {
            const formData = new FormData(document.getElementById('registrationForm'));
            
            // Only include collegeName if staff is SchoolDean
            if (staff !== 'SchoolDean') {
                formData.delete('collegeName');
            }

            fetch('submit_form.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                try {
                    const data = JSON.parse(text);
                    if (data.success) {
                        alert('User added successfully');
                        window.location.reload(); // Reload the form after user clicks "OK"
                    } else {
                        console.error('Server error:', data.error);
                        alert('There was an error adding the user.');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    console.error('Response text:', text);
                    alert('There was an error processing the response from the server.');
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
