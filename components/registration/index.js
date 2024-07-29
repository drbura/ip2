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
        var optionArray = ["select|Select", "computer science |Computer Science ", "information technology |Information Technology", "software engineering|Software Engineering"];
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