<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>dduStudent Registration Form</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f8f9fa;
        color: #333;
        font-family: 'Roboto', sans-serif;
    }
    .container {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Added box-shadow for shadow effect */
        max-width: 600px;
        margin: auto;
    }
    h1 {
        color: #007bff;
        font-weight: bold;
        margin-bottom: 30px;
    }
    .form-label {
        color: #333;
        font-weight: bold;
    }
    .form-section {
        margin-bottom: 20px;
    }
    .form-control, .form-control:focus {
        background-color: #e9ecef;
        color: #495057;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        border-radius: 5px;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        border-radius: 5px;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
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
            var optionArray = ["select|Select", "computer science |Computer Science ","information technology |information technology ", "software engineering|software engineering"];
        } else if (s1.value == "Education") {
            var optionArray = ["select|Select", "education|Education", "biology|biology", "mathematics|Mathematics"];
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
        const studentId = document.getElementById('student_id').value.trim();

        // Regular expression to match "ddu" followed by exactly 7 digits
        const regex = /^ddu\d{7}$/i;

        if (!regex.test(studentId)) {
            alert('Student ID must start with "ddu" followed by exactly 7 digits.');
            return false;
        }

        const firstName = document.getElementById('first_name').value;
        const fatherName = document.getElementById('father_name').value;
        const gfatherName = document.getElementById('gfather_name').value;
        const school = document.getElementById('slct1').value;
        const department = document.getElementById('slct2').value;

        if (firstName.trim() === '' || fatherName.trim() === '' || gfatherName.trim() === '') {
            alert('Please fill in all required fields.');
            return false;
        }

        if (school === 'select' || department === 'select') {
            alert('Please select a valid school and department.');
            return false;
        }

        // Additional validation checks as needed

        alert('Done');
        return true;
    }
</script>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">DIRE DAWA UNIVERSITY STUDENT ADMISSION FORM</h1>
    <form action="insert.php" method="post" onsubmit="return validateForm()">
        <div class="form-section">
            <label for="student_id" class="form-label">Student ID:</label>
            <input type="text" class="form-control" id="student_id" name="student_id" required minlength="10">
        </div>
        <div class="form-section">
            <label for="first_name" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-section">
            <label for="father_name" class="form-label">Father Name:</label>
            <input type="text" class="form-control" id="father_name" name="father_name" required>
        </div>
        <div class="form-section">
            <label for="gfather_name" class="form-label">Grandfather Name:</label>
            <input type="text" class="form-control" id="gfather_name" name="gfather_name" required>
        </div>
        <div class="form-section">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" class="form-control" id="dob" name="dob" required>
        </div>
        <div class="form-section">
            <label class="form-label">Sex:</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                <label class="form-check-label" for="male">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                <label class="form-check-label" for="female">Female</label>
            </div>
        </div>
        <div class="form-section">
            <label for="enrolment_date" class="form-label">Enrolment Date:</label>
            <input type="date" class="form-control" id="enrolment_date" name="enrolment_date" required>
        </div>
        <div class="form-section">
            <label for="slct1" class="form-label">School:</label>
            <select id="slct1" class="form-control" name="school" onchange="populate(this.id, 'slct2')" required>
                <option value="select">Select..</option>
                <option value="Freshman">Freshman</option>
                <option value="Medicine and Health Sciences">Medicine and Health Sciences</option>
                <option value="Law">Law</option>                                   
                <option value="Business and Economics">Business and Economics</option>
                <option value="Science, Engineering and Technology">Science, Engineering and Technology</option>
                <option value="Education">Education</option>
                <option value="Pharmacy">Pharmacy</option>
            </select>
        </div>
        <div class="form-section">
            <label for="slct2" class="form-label">Department/Stream:</label>
            <select id="slct2" class="form-control" name="slct2" required>
                <option value="select">Select</option>
            </select>
        </div>
        <div class="form-section text-center">
            <button type="reset" class="btn btn-secondary">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
