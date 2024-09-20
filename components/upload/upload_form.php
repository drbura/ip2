<!-- upload_form.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV/Excel File</title>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-left: 320px;
            margin-top: 50px;
        }
        .upload-container {
            background-color: #ffffff;
            border: 2px dashed #4763F1;
            border-radius: 10px;
            width: 900px;
            padding: 60px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, border-color 0.3s;
            position: relative;
        }
        .upload-container.dragover {
            background-color: #e6f0ff;
            border-color: #012970;
        }
        .upload-container h1 {
            color: #012970;
            margin-bottom: 20px;
        }
        .upload-container p {
            color: #4763F1;
            margin-bottom: 20px;
        }
        .upload-container input[type="file"] {
            display: none;
        }
        .upload-container label {
            background-color: #4763F1;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .upload-container label:hover {
            background-color: #012970;
        }
        .upload-container button {
            background-color: #012970;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .upload-container button:hover {
            background-color: #4763F1;
        }
        .progress {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 20px;
            display: none;
        }
        .progress-bar {
            height: 20px;
            background-color: #012970;
            width: 0%;
            transition: width 0.4s;
        }
        .file-info {
            margin-top: 20px;
            display: none;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #012970;
            font-size: 16px;
        }
        .file-info i {
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="upload-container" id="drop-area">
        <h1>Upload CSV or Excel File</h1>
        <p>Drag & Drop your file here or click to select</p>
        <form id="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
            <label for="file">Choose File</label>
            <input type="file" name="file" id="file" accept=".csv, .xlsx, .xls" required>
            <div class="file-info" id="file-info">
                <i id="file-icon" class=""></i>
                <span id="file-name"></span>
            </div>
            <button type="submit">Upload and Import</button>
            <div class="progress" id="progress-bar">
                <div class="progress-bar" id="bar"></div>
            </div>
        </form>
    </div>

    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file');
        const progressBar = document.getElementById('progress-bar');
        const bar = document.getElementById('bar');
        const fileInfo = document.getElementById('file-info');
        const fileIcon = document.getElementById('file-icon');
        const fileName = document.getElementById('file-name');

        // Function to set file icon based on type
        function setFileIcon(extension) {
            if (extension === 'csv') {
                fileIcon.className = 'fa-solid fa-file-csv';
                fileIcon.style.color = '#ff3f34';
            } else if (extension === 'xlsx' || extension === 'xls') {
                fileIcon.className = 'fa-solid fa-file-excel';
                fileIcon.style.color = '#28a745';
            } else {
                fileIcon.className = 'fa-solid fa-file';
                fileIcon.style.color = '#6c757d';
            }
        }

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.remove('dragover');
            }, false);
        });

        // Handle dropped files
        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length) {
                fileInput.files = files;
                displayFileInfo(files[0]);
            }
        });

        // Handle file selection via input
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                displayFileInfo(fileInput.files[0]);
            }
        });

        // Display file info with icon and name
        function displayFileInfo(file) {
            const extension = file.name.split('.').pop().toLowerCase();
            setFileIcon(extension);
            fileName.textContent = file.name;
            fileInfo.style.display = 'flex';
        }

        // Show progress bar on form submit
        const form = dropArea.querySelector('form');
        form.addEventListener('submit', (e) => {
            progressBar.style.display = 'block';
            bar.style.width = '0%';
        });

        // Animate progress bar (simulated)
        form.addEventListener('submit', () => {
            let width = 0;
            const interval = setInterval(() => {
                if (width >= 100) {
                    clearInterval(interval);
                } else {
                    width += 10;
                    bar.style.width = width + '%';
                }
            }, 300);
        });

        // SweetAlert AJAX
        // AJAX form submission with SweetAlert
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this);

            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Parse JSON response
            .then(result => {
                if (result.success) {
    Swal.fire({
        icon: 'success',
        title: 'Import Successful!',
        text: `Inserted records: ${result.inserted}`,
        footer: result.skipped > 0 ? `Skipped records: ${result.skipped}` : ''
    }).then(() => {
        form.reset(); // Resets the form
        fileInfo.style.display = 'none'; // Hide file info
        bar.style.width = '0%'; // Reset progress bar
    });
}
else {
                    // Error notification using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error Occurred',
                        text: result.message
                    });
                }
            })
            .catch(error => {
                // Handle any unexpected errors
                Swal.fire({
                    icon: 'error',
                    title: 'Unexpected Error',
                    text: 'Something went wrong. Please try again.'
                });
                console.error('Error:', error);
            });
        });

    </script>
</body>
</html>
