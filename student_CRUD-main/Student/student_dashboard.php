<?php   
session_start();

if (!isset($_SESSION['student_logged_in']) || $_SESSION['student_logged_in'] !== true) {
    header('Location: ../index.php'); // Redirect to the login page
    exit;
}

if(isset($_FILES["edit_picture"]) && $_FILES["edit_picture"]["error"] == 0) {
    $file_tmp = $_FILES["edit_picture"]["tmp_name"];
    $file_name = $_FILES["edit_picture"]["name"];
    // Process and move uploaded file to desired location
    move_uploaded_file($file_tmp, "uploads/" . $file_name);
}

// Get the ID of the logged-in student
$student_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <title>Student Dashboard</title>
    <style>
        body {
    display: flex;
    min-height: 100vh;
    width: 100vw;
    margin: 0;
}

main {
    display: flex;
    flex-direction: column;
    width: 100%;
    overflow: hidden;
    overflow-y: auto;
    padding-top: 20px;
    align-items: center;
    background-color: #d9dedd;
}

.container {
    padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 1000px; /* Adjust maximum width as needed */
            margin: 0 auto; /* Center the container */
}

.student-card {
    background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 500px; /* Occupy full width */

            flex-direction: row; /* Align items in a row */

}

.student-info {
    flex: 1;
    padding: 20px;
}

.student-picture {
    flex: 0 0 250px; /* Fix the width for the picture container */
    display: flex;
    justify-content: center;
    align-items: center;
    padding-bottom: 20px;
}

.student-picture img {
    width: 100%;
    height: auto;
    object-fit: cover;
    border: 2px solid black;
    max-width: 150px; /* Ensure the image doesn't exceed the container */
    max-height: 150px; /* Ensure the image doesn't exceed the container */
}

.update-button {
    margin-top: 10px;
    align-self: flex-end;
    background-color: black;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.update-button:hover {
    background-color: #333;
}

p {
    margin: 0;
}


    </style>
</head>
<body>

    <?php require_once('./student_nav.php'); ?>

    <main>
        <div class="container">
            <p id="status" class="text-success"></p>
            <div class="d-flex justify-content-between mb-3">
                <h3>Student Information</h3>
            </div>
            <div id="student-container">
                <!-- Student data will be appended here -->
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Get the student ID from the PHP session
            var studentId = <?php echo $student_id; ?>;

            $.ajax({
                type: "POST",
                url: "../ajax.php",
                data: { fetchStudentData: true, id: studentId },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        var student = response.student[0]; // Access the first element of the array
                        var approveStatus = student.approved;
                        var studentCard = '<div class="student-card">';
                        var yearMap = {
                            "1": "First Year",
                            "2": "Second Year",
                            "3": "Third Year",
                            "4": "Fourth Year",
                            "default": "Fifth Year"
                        };

                        var sectionMap = {
                            "1": "Section A",
                            "2": "Section B",
                            "3": "Section C",
                            "default": "Unknown Section"
                        };

                        var courseMap = {
                            "1": "BSIT",
                            "2": "BSComEng",
                            "3": "BSIS",
                            "default": "Unknown Course"
                        };

                        var course = courseMap[student.course] || courseMap["default"];
                        var year = yearMap[student.current_year] || yearMap["default"];
                        var section = sectionMap[student.current_section] || sectionMap["default"];
                        if (approveStatus == 1) {
                            studentCard += '<div class="student-info">';
                        studentCard += '<div class="student-picture">';
                        studentCard += '<img src="../' + student.profile_picture + '" alt="Profile Picture">';
                        studentCard += '</div>';
                        studentCard += '<h3>' + student.first_name + ' ' + student.middle_name + ' ' + student.last_name + '</h3>';
                        studentCard += '<p><strong>ID Number:</strong> ' + student.id + '</p>';
                        studentCard += '<p><strong>Email:</strong> ' + student.email + '</p>';
                        studentCard += '<p><strong>Current Year:</strong> ' + year +'</p>';
                        studentCard += '<p><strong>Current Section:</strong> ' + section + '</p>';
                        studentCard += '<p><strong>Course:</strong> ' + course + '</p>';
                            studentCard += '<button class="update-button" type="button" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="' + student.id + '">Update</button>';
                        } else {
                            studentCard += '<p><center>NOT APPROVE YET</center></p>'
                        }
                        studentCard += '</div>';

                        studentCard += '</div>';

                        // Append the student card HTML to the student-container div (if approveStatus === 1)
                        $('#student-container').html(studentCard);
                    } else {
                        $('#status').html(response.error);
                    }
                },
                error: function() {
                    $('#status').html('Error retrieving student data.');
                }
            });

        $('#student-container').on('click', '.update-button', function() {
            var studentId = $(this).data('id');

        });
        });
    </script>

</body>
<?php require_once('./modals.php'); ?>
</html>
