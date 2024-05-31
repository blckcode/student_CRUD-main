<?php

    session_start();

    if (!isset($_SESSION['teacher_logged_in']) || $_SESSION['teacher_logged_in'] !== true) {
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
    <title>TEACHER PANEL</title>
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
</style>
<body class="d-flex">

<?php require_once('./teacher_nav.php'); ?>

<main>
    <div class="container p-5">
        <p id="status" class="text-success"></p>
        <div id="student-table" class="shadow-none p-3 mb-5 bg-body-tertiary rounded"></div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $.ajax({
        type: "POST",
        url: "../ajax.php",
        data: {
            fetchStudents0: 1,
        },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                var student_data = response.student_data;
                var table =
                    '<table class="table" id="students_table"><thead><th>#</th><th>ID Number</th><th>First Name</th><th>Middle Name</th><th>Last Name</th><th>Email</th><th>Age</th><th>Action</th></thead><tbody>';
                $.each(student_data, function(index, student) {
                    table +=
                        '<tr><td>' + student.id +
                        '</td><td>' + student.id_number +
                        '</td><td>' + student.first_name +
                        '</td><td>' + student.middle_name +
                        '</td><td>' + student.last_name +
                        '</td><td>' + student.email +
                        '</td><td>' + student.current_age +
                        '</td><td>' +
                        '<button class="approve-btn btn btn-success btn-sm" data-id="' + student.id + '">Yes</button>' +
                        ' <button class="disapprove-btn btn btn-danger btn-sm" data-id="' + student.id + '">No</button>' +
                        '</td></tr>';
                });

                table += '</tbody></table>';
                $('#student-table').html(table);

                $('#students_table').DataTable();
            } else {
                $('#student-table').html(response.error);
            }
        },
        error: function() {
            $('#student-table').html('Error retrieving students data.');
        }
    });

    $('#student-table').on('click', '.approve-btn', function() {
        var studentId = $(this).data('id');
        if (confirm("Are you sure you want to approve this student?")) {
            updateApprovalStatus(studentId, 1);
        }
    });

    $('#student-table').on('click', '.disapprove-btn', function() {
        var studentId = $(this).data('id');
        if (confirm("Are you sure you want to disapprove this student?")) {
            updateApprovalStatus(studentId, 0);
        }
    });

    function updateApprovalStatus(studentId, status) {
        $.ajax({
            type: 'POST',
            url: '../ajax.php',
            data: {
                updateApproval: 1,
                student_id: studentId,
                approved: status
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    location.reload(); // Reload the page to reflect changes
                } else {
                    $('#status').html(response.error);
                }
            },
            error: function() {
                $('#status').html('Error updating approval status.');
            }
        });
    }
});
</script>
<?php require_once('./modals.php'); ?>
</body>
</html>
