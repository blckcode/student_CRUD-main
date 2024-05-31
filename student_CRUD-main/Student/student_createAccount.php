<?php
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
</head>
<style>
    main {
        background-color: #EEEEEE;
        display: flex;
        flex-direction: column;
        max-height: 100vh;
        width: 100%;
        overflow: hidden;
        overflow-y: auto;
        width: 80%;
    }

    #form-student {
        margin: 0 auto;
    }
</style>
<body class="d-flex">

    <?php require_once('./student_nav.php'); ?>

    <main>
        <div class="container p-5">
            <div id="form-student" class="w-50">
                <p id="status"></p>
                <h3 class="mb-5">Create Student Account</h3>
                <form id="create-student-form">
                    <div class="row mb-3">
                        <div class="col">
                            <!-- Fix: Use name="username" instead of name="username-student" -->
                            <input id="student-username" name="username" type="text" class="form-control" placeholder="Username" aria-label="Student Username" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input id="student-password" name="password" type="password" class="form-control" placeholder="Password" aria-label="Student Password" required>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Create Student</button>
                        <p>Already have an account? <a href="../student_login.php">Login here</a>.</p>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function(){
            $('#create-student-form').on('submit', function(e){
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '../ajax.php',
                    data: {
                        createStudent: 1,
                        // Fix: Use the correct key for username field
                        username: $('input[name="username"]').val(),
                        password: $('input[name="password"]').val(),
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
            });
        });
    </script>
</body>
</html>
