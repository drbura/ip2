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
                                <option    value="" disabled selected >select staff</option>
                                <option value="BookStore">Book Store</option>
                                <option value="Library">Library</option>
                                <option value="Cafeteria">Cafeteria</option>
                                <option value="StudentLoan">Student Loan</option>
                                <option value="Dormitory">Dormitory</option>
                                <option value="StudentService">Student Service</option>
                                <option value="Store">Store</option>
                                <option value="AcademicEnrollment">Enrollment and Academic Record</option>
                                <option value="registrar">Registrar</option>
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
                    <input type="submit" value="Register">
                </div>
                <div class="details ID">
                    <div class="fields">
                </div>
            </div>
        </form>
    </div>
    <script>
    function toggleCollegeName() {
        const role = document.getElementById('staff').value;
        const collegeNameField = document.getElementById('collegeNameField');
        const collegeNameInput = document.getElementById('collegeName');
        
        if (role === 'SchoolDean') {
            collegeNameField.style.display = 'block';
            collegeNameInput.setAttribute('required', 'required');
        } else {
            collegeNameField.style.display = 'none';
            collegeNameInput.removeAttribute('required');
        }
    }

    // Call toggleCollegeName on page load to set the initial state
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
    
   

    async function validateStaff() {
    const staffSelect = document.getElementById('staff');
    const staffOptions = staffSelect.options;

    try {
        // Fetch the staff roles that have already been assigned
        const response = await fetch('check_staff.php');
        const assignedRoles = await response.json();

        // Iterate through the options and disable the assigned ones
        for (let i = 0; i < staffOptions.length; i++) {
            const option = staffOptions[i];

            if (assignedRoles.includes(option.value)) {
                option.disabled = true; // Disable the option if it has been assigned
            } else {
                option.disabled = false; // Enable the option if it hasn't been assigned
            }
        }

        // Ensure that the School Dean option is always enabled
       
        const schoolDeanOption = staffSelect.querySelector('option[value="SchoolDean"]');
        if (schoolDeanOption) {
            schoolDeanOption.disabled = false;
        }
    } catch (error) {
        console.error('Error validating staff:', error);
    }
}

// Call validateStaff on page load to set the initial state
document.addEventListener('DOMContentLoaded', validateStaff);

async function validateSchoolDean() {
    const staffSelect = document.getElementById('collegeName');
    const staffOptions = staffSelect.options;
    // const schoolDeanOption = staffSelect.querySelector('option[value="SchoolDean"]');

    try {
        // Fetch the school dean who is currently assigned
        const response = await fetch('check_school.php');
        const assignedDeans = await response.json();

        // Check if there are any assigned School Deans
        for (let i = 0; i < staffOptions.length; i++) {
            const option = staffOptions[i];

            if (assignedDeans.includes(option.value)) {
                option.disabled = true; // Disable the option if it has been assigned
            } else {
                option.disabled = false; // Enable the option if it hasn't been assigned
            }
        }
    } catch (error) {
        console.error('Error validating School Dean:', error);
    }
}

// Call validateSchoolDean on page load to set the initial state
document.addEventListener('DOMContentLoaded', validateSchoolDean);


      
    async function validateCollegeName(){
        const collegeNameField = document.getElementById('collegeNameField');
        const collegeNameInput = document.getElementById('collegeName');
        const role = document.getElementById('staff').value;
        if (role === 'SchoolDean') {
            if (!collegeNameInput.value) {
                document.getElementById('collegeNameError').textContent = 'Please select a college/school.';
                return false;
            } else {
                document.getElementById('collegeNameError').textContent = '';
                return true;
            }
        } else {
            document.getElementById('collegeNameError').textContent = '';
            return true;
        }
    }

    // Ensure to call these functions on relevant events
    document.getElementById('staff').addEventListener('change', async () => {
        toggleCollegeName();
        await validateStaff();
        await validateCollegeName();
    });

    document.getElementById('fName').addEventListener('blur', () => validateName('fName', 'fNameError'));
    document.getElementById('mName').addEventListener('blur', () => validateName('mName', 'mNameError'));
    document.getElementById('lName').addEventListener('blur', () => validateName('lName', 'lNameError'));
    document.getElementById('role').addEventListener('blur', validatePosition);
    document.getElementById('phone').addEventListener('blur', validatePhone);
    document.getElementById('email').addEventListener('blur', async () => await validateEmail());
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
    valid = await validateEmail() && valid; // Await the email validation
    valid = validatePassword() && valid;
    valid = validateDate() && valid;
    valid = await validateCollegeName() && valid; // Await the college name validation

    if (valid) {
        const formData = new FormData(this);
        const response = await fetch(this.action, {
            method: this.method,
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            alert('Form submitted successfully!');
            window.location.reload(); // Reload the page on successful submission
        } else {
            alert('Failed to submit the form. Please try again.');
        }
    } else {
        alert('Please fix the errors in the form before submitting.');
    }
});

</script>

</body>
</html>
