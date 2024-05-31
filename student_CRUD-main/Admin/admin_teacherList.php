<?php

session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../index.php'); // Redirect to the login page
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <title>ADMIN PANEL</title>
</head>
<style>
    main {
        display: flex;
        flex-direction: column;
        max-height: 100vh;
        width: 100%;
        overflow: hidden;
        overflow-y: auto;
        width: 80%;
        background-color: #EEEEEE;
    }
    .edit-btn,
    .delete-btn {
        margin-right: 5px;
        width: 100px; /* Adjust the width as needed */
        height: 36px; /* Adjust the height as needed */
    }
</style>
<body class="d-flex">
    <?php require_once('./admin_nav.php'); ?>
    <main>
        <div class="container p-5">
            <p id="status" class="text-success"></p>
            <div class="d-flex justify-content-between mb-3">
                <h3>Teacher Record</h3>
                <button id="update_btn" class="edit-btn btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Create <i class="bi bi-plus"></i></button>
            </div>
            <div id="teacher-table" class="shadow-none p-3 mb-5 bg-body-tertiary rounded">
            </div>
        </div>
    </main>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "POST",
                url: "../ajax.php",
                data: {
                    fetchTeachers: 1,
                },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        var teacher_data = response.teacher_data;
                        var table = '<table class="table" id="teachers_table"><thead><th>#</th><th>ID Number</th><th>Name</th><th>Username</th><th>Action</th></thead><tbody>';
                        $.each(teacher_data, function(index, teacher) {
                            table += '<tr><td>' + teacher.id +
                                '</td><td>' + teacher.id +
                                '</td><td>' + teacher.first_name + " " + teacher.middle_name + " " + teacher.last_name +
                                '</td><td>' + teacher.username +
                                '</td><td>' + '<button class="edit-btn btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="'+ teacher.id +'">Update <i class="bi bi-pencil-square"></i></button>&nbsp;<button class="delete-btn btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#removeModal" data-id="'+ teacher.id +'">Delete <i class="bi bi-trash3-fill"></i></button>' +
                                '</td></tr>';
                        });
                        table += '</tbody></table>';
                        $('#teacher-table').html(table);
                        $('#teachers_table').DataTable();
                    } else {
                        $('#teacher-table').html('<p>' + response.error + '</p>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#teacher-table').html('<p>Error retrieving teachers data. Please try again later.</p>');
                }
            });
        });
    </script>
</body>
<?php require_once('./teacher_modals.php'); ?>
</html>
