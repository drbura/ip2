


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
            margin-left: 250px;
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
            color: #012970;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.4rem;
            font-family: Tahoma;
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
        fieldset {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
        }
        legend {
            font-size: 1.2rem;
        }
        .error {
            color: red;
            font-size: 0.9em;
        }
        .input-error {
            border: 2px solid red;
        }
        .form-group.lable{
            font-family: Tahoma;
        }
    </style>
    <script>
        function populate(s1, s2) {
    var s1 = document.getElementById(s1);
    var s2 = document.getElementById(s2);
    s2.innerHTML = "";

    var placeholderOption = "<option value='' disabled selected>Select</option>";

    if (s1.value == "Business and Economics") {
        var optionArray = ["Accounting and Finance|Accounting and Finance", "Banking and Finance|Banking and Finance", "Logistics and supplies Chain Managment|Logistics and supplies Chain Managment", "Managment|Managment", "Marketing Management|Marketing Management", "Public Administration and Development Managment|Public Administration and Development Managment", "Economics|Economics", "Land and Real Property Valuation|Land and Real Property Valuation"];
    } else if (s1.value == "Electrical and computer engineering") {
        var optionArray = ["Electrical and computer engineering|Electrical and computer engineering"];
    } else if (s1.value == "School of Chemical and BioEngineering") {
        var optionArray = ["Food Processing engineering|Food Processing engineering", "Chemical engineering|Chemical engineering"];
    } else if (s1.value == "School of Textile and Fashion Design") {
        var optionArray = ["Textile engineering|Textile engineering", "Apparel and Fashion design|Apparel and Fashion design"];
    } else if (s1.value == "School of Civil Eng and Architecture") {
        var optionArray = ["Architecture|Architecture", "Civil engineering|Civil engineering", "Construction technology and managment|Construction technology and managment", "Surveying engineering|Surveying engineering"];
    } else if (s1.value == "School of Mechanical and Industrial Engineering") {
        var optionArray = ["Industrial engineering|Industrial engineering", "Mechanical engineering|Mechanical engineering"];
    } else if (s1.value == "School of Computing") {
        var optionArray = ["Software Engineering|Software Engineering", "Information technology|Information technology", "Computer Science|Computer Science"];
    } else if (s1.value == "College of medicine and health science") {
        var optionArray = ["Anesthesia|Anesthesia", "Laboratory|Laboratory", "Madicine|Madicine", "Midwifery|Midwifery", "Nursing|Nursing", "Psychiatry|Psychiatry", "public Health|public Health"];
    } else if (s1.value == "College of Law") {
        var optionArray = ["law|Law"];
    } else if (s1.value == "College of Natural and Computational Science") {
        var optionArray = ["Biology|Biology", "Chemistry|Chemistry", "Geology|Geology", "Physics|Physics", "Mathematics|Mathematics", "Statistics|Statistics", "Sport Science|Sport Science"];
    } else if (s1.value == "College of Social Science and Humanity") {
        var optionArray = ["AfSomali and Litrature|AfSomali and Litrature", "AfanOromo and Litrature|AfanOromo and Litrature", "Amharic Language and Litrature|Amharic Language and Litrature", "English Language and Litrature|English Language and Litrature", "Journalism and Communication|Journalism and Communication", "Geography and Enviromental Studies|Geography and Enviromental Studies", "History and Heritage Managment|History and Heritage Managment", "Sociology and Social Anthropology|Sociology and Social Anthropology", "Political Science and International Relation|Political Science and International Relation", "Civics and Ethical Studies|Civics and Ethical Studies", "Psychology|Psychology"];
    }

    // Add placeholder option
    s2.innerHTML = placeholderOption;
    

    // Add other options
    for (var option in optionArray) {
        var pair = optionArray[option].split("|");
        var newOption = document.createElement("option");
        newOption.value = pair[0];
        newOption.innerHTML = pair[1];
        s2.options.add(newOption);
    }
}


        </script>
         <script>
        var isStudentIdValid = false;  // Flag to track student ID validity

        function checkStudentId() {
            var studentId = document.getElementById('student_id').value;
            var errorMessage = document.getElementById('id_error');
            var studentIdField = document.getElementById('student_id');
            
            if (studentId.length > 0) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_id.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        if (xhr.responseText === 'exists') {
                            errorMessage.textContent = 'Student ID already in use.';
                            studentIdField.classList.add('input-error');
                            isStudentIdValid = false;  // Set flag to false
                        } else {
                            errorMessage.textContent = '';
                            studentIdField.classList.remove('input-error');
                            isStudentIdValid = true;  // Set flag to true
                        }
                    }
                };
                xhr.send('student_id=' + encodeURIComponent(studentId));
            } else {
                errorMessage.textContent = '';
                studentIdField.classList.remove('input-error');
                isStudentIdValid = false;  // Set flag to false
            }
        }

        function validateForm() {
            // Check if the student ID is valid before allowing form submission
            if (!isStudentIdValid) {
                alert('Please provide a unique student ID.');
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

    <main>
        <div class="container mt-5">
            <h2 class="text-center">STUDENT ADMISSION FORM</h2>
            <form action="insert.php" method="post" onsubmit="return validateForm()" enctype="multipart/form-data">

                <!-- Legend: Student Information -->
                <fieldset>
                    <legend>Student Information</legend>
                    <div class="form-row">
                        <div class="form-group col-md-4 form-section">
                            <label for="student_id" class="form-label">Student ID:</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" onkeyup="checkStudentId()" required pattern="^[A-Za-z]{3}\d{7}$" title="Student ID must start with three characters(ddu) followed by seven digits." minlength="10" maxlength="10">
                            <span id="id_error" class="error"></span>
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
    <input type="date" class="form-control" id="enrolment_date" name="enrolment_date" required min="2018-01-01">
</div>
                    <div class="form-group col-md-4 form-section">
                        <label for="year" class="form-label">Year:</label>
                        <input type="number" class="form-control" id="year" name="year" min="1" max="6" required>
                    </div>
                    <div class="form-group col-md-4 form-section">
                        <label for="semister" class="form-label">Semester:</label>
                        <input type="number" class="form-control" id="semister" name="semister" min="1" max="3" required>
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
                        <label for="slct1" class="form-label">College/School:</label>
                        <select class="form-control" id="slct1" name="school" onchange="populate(this.id,'slct2')" required>
                            <option value="select">Select</option>
                            <option value="Business and Economics">Business and Economics</option>
                            <option value="Electrical and computer engineering">Electrical and computer engineering</option>
                            <option value="School of Chemical and BioEngineering">School of Chemical and BioEngineering</option>
                            <option value="School of Textile and Fashion Design">School of Textile and Fashion Design</option>
                            <option value="School of Civil Eng and Architecture">School of Civil Eng and Architecture</option>
                            <option value="School of Mechanical and Industrial Engineering">School of Mechanical and Industrial Engineering</option>
                            <option value="School of Computing">School of Computing</option>
                            <option value="College of medicine and health science">College of medicine and health science</option>
                            <option value="College of Law">College of Law</option>
                            <option value="College of Natural and Computational Science">College of Natural and Computational Science</option>
                            <option value="College of Social Science and Humanity">College of Social Science and Humanity</option>
                           
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
    <input type="tel" class="form-control" id="phone_number" name="phone_number" pattern="^(09|07)[0-9]{8}$" required>
    <small class="form-text text-muted">The phone number should be 10 digits and start with 09 or 07.</small>
                  </div>

                </div>
            </fieldset>

            <!-- Legend: Birth Information -->
            <fieldset>
                <legend>Birth Information</legend>
                <div class="form-row">
                <div class="form-group col-md-6 form-section">
    <label for="dob2" class="form-label">Birth Date:</label>
    <input type="date" class="form-control" id="dob2" name="dob2" required max="2009-12-31" min="1984-01-01">
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

             <!-- Legend: Student Legistlation Type -->
             <fieldset>
                <legend>Student Legistlation Type</legend>
                <div class="form-row">
                    <div class="form-group col-md-6 form-section">
                    <label for="Student_Legistlation_Type" class="form-label">Student Legistlation Type:</label>
                    <select class="form-control" id="Student_Legistlation_Type" name="Student_Legistlation_Type" required>
                        <option value="Harmonized Modular">Harmonized Modular</option>
                        <option value="conventional">conventional</option>
                    </select>
                </div>
            </fieldset>
            <?php if (isset($_GET['error'])): ?>
		<p><?php echo $_GET['error']; ?></p>
	<?php endif ?>
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
                <button type="submit" class="btn btn-primary">Register</button>
                <button type="reset" class="btn btn-secondary">Clear Form</button>
            </div>
            <div id="registrationMessage" class="alert alert-success" style="display: none;"></div>

        </form>
    </div>
        </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
