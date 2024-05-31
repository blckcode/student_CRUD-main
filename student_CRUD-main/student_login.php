<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #EEEEEE;
        }

        .container {
            margin-top: 50px;
            border-radius: 10px;
            padding: 40px;
        }

        h3 {
            color: #000;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            color: #333333;
            margin-bottom: 5px;
        }

        .btn-primary {
            background-color: #000;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container w-75">
        <h3>STUDENT PORTAL</h3>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <p id="response" class="text-center text-danger"></p>
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4 class="card-title">Sign in</h4>
                    </div>
                    <div class="card-body">
                        <form id="login-form">
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Enter password" required>
                            </div>
                            <p>Don't have an account? <a href="Student/student_createAccount.php">Register here</a>.</p>
                            <button type="submit" class="btn btn-primary w-100 mb-3">Sign in</button>
                        </form>
                        <button onclick="window.location.href='index.php'" class="btn btn-secondary w-100">Back to Portal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $('#login-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: 'ajax.php',
                data: {
                    loginStudent: true,
                    username: $('#username').val(),
                    password: $('#password').val()
                },
                success: function(response) {
                    console.log("Response received:", response); // Log entire response object
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            $('#response').html(response.message);
                        }
                    } catch (e) {
                        console.error("JSON parsing error:", e);
                        $('#response').html("An error occurred while processing the response.");
                        console.log("Error response:", response); // Log error response for debugging
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX request failed:", error);
                }
            });
        });
    </script>

</body>

</html>
