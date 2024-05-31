<?php

    session_start();
    if (isset($_SESSION['teacher_logged_in']) == true) {
        // Redirect to login page if the teacher is not logged in
        header("Location: ./teacher_dashboard.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEACHER PANEL</title>

</head>
<style>
    main{
        display: flex;
        flex-direction: column;
        max-height: 100vh;
        width: 100%;
        overflow: hidden;
        overflow-y: auto;
        width: 80%;
        background-color: #EEEEEE;
    }

    #form-teacher{
        margin: 0 auto;
    }
</style>
<body class="d-flex">

    <?php require_once('./teacher_nav.php'); ?>

    <main>
        <div class="container p-5">
            <div id="form-teacher" class="w-50">
                <p id="status"></p>
                <h3 class="mb-5">Create Teacher Account</h3>
                <form id="create-teacher-form">
                    <div class="row mb-3">
                        <div class="col">
                            <input id="teacher-name" name="name-teacher" type="text" class="form-control" placeholder="Name" aria-label="Teacher Name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input id="teacher-username" name="username-teacher" type="text" class="form-control" placeholder="Username" aria-label="Teacher Username" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input id="teacher-password" name="password-teacher" type="password" class="form-control" placeholder="Password" aria-label="Teacher Password" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Create Teacher</button>
                        <p>Already have an account? <a href="../teacher_login.php">Login here</a>.</p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function(){
            $('#create-teacher-form').on('submit', function(e){
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: '../ajax.php',
                data: {
                    createTeacher: 1,
                    name: $('input[name="name-teacher"]').val(),
                    username: $('input[name="username-teacher"]').val(),
                    password: $('input[name="password-teacher"]').val(),
                },
                dataType: 'json',
                success: function(response){
                    if(response.success){
                        $('#status').html(response.message);
                    } else {
                        $('#status').html(response.error);
                        console.error('Error: ' + response.error);
                    }
                },
                error: function(xhr, status, error){
                    $('#status').html(xhr.responseText);
                    console.error('AJAX Error: ' + xhr.responseText);
                }
            });

            // location.reload();
        });
        })
    </script>
</body>
</html>