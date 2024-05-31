<?php   
session_start();

if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
    header('Location: ../index.php'); // Redirect to the login page
    exit;
}

if(isset($_FILES["edit_picture"]) && $_FILES["edit_picture"]["error"] == 0) {
    $file_tmp = $_FILES["edit_picture"]["tmp_name"];
    $file_name = $_FILES["edit_picture"]["name"];
    // Process and move uploaded file to desired location
    move_uploaded_file($file_tmp, "uploads/" . $file_name);
}
$teacher_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <title>Teacher Dashboard</title>
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

        .teacher-card {

            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 500px; /* Occupy full width */

            flex-direction: row; /* Align items in a row */
        }

        .teacher-info {

            flex: 1;
            padding: 20px;
            font-size: small;
        }
        

        .teacher-picture {
            flex: 0 0 250px; /* Fix the width for the picture container */
            display: flex;
            justify-content: center;
            align-items: center;

            height: 200px;
        }

        .teacher-picture img {
            padding-top: -20px;
            width: 100%;
            height: auto;
            object-fit: cover;
            border: 2px solid black;
            max-width: 200px; /* Ensure the image doesn't exceed the container */
            max-height: 200px; /* Ensure the image doesn't exceed the container */
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

    <?php require_once('./teacher_nav.php'); ?>

    <main>
        <div class="container">
            <p id="status" class="text-success"></p>
            <div class="d-flex justify-content-between mb-3">
                <h3>Teacher Information</h3>
            </div>
            <div id="teacher-container">
                <!-- Teacher data will be appended here -->
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
    // Get the teacher ID from the PHP session
    var teacherId = <?php echo json_encode($teacher_id); ?>;

    if (teacherId) {
        $.ajax({
            type: "POST",
            url: "../ajax.php",
            data: { fetchTeacherData: true, id: teacherId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    var teacher = response.teacher[0]; // Access the first element of the array
                    var teacherCard = '<div class="teacher-card">';

                    // Construct teacher card HTML
                    teacherCard += '<div class="teacher-info">';
                    teacherCard += '<div class="teacher-picture">';
                        teacherCard += '<img src="../' + teacher.profile_picture + '" alt="Profile Picture">';
                        teacherCard += '</div>';
                        teacherCard += '<h3>' + teacher.first_name + ' ' + teacher.middle_name + ' ' + teacher.last_name + '</h3>';
                        teacherCard += '<p><strong>Email:</strong> ' + teacher.email + '</p>';
                        teacherCard += '<p><strong>Department:</strong> ' + teacher.department + '</p>';
                        teacherCard += '<button class="update-button" type="button" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="' + teacher.id + '">Update</button>';
                        teacherCard += '</div>';
                        teacherCard += '</div>';

                    // Append the teacher card HTML to the teacher-container div
                    $('#teacher-container').html(teacherCard);
                } else {
                    $('#status').html(response.error);
                }
            },
            error: function() {
                $('#status').html('Error retrieving teacher data.');
            }
        });

        $('#teacher-container').on('click', '.update-button', function() {
            var teacherId = $(this).data('id');
            // Handle the update functionality here
        });
    } else {
        $('#status').html('Teacher ID not found in session.');
    }
});

    </script>

</body>
<?php require_once('./teacher_modals.php'); ?>
</html>
