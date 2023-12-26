<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['reset_success']) && $_SESSION['reset_success']) {
        echo "<script>alert('Password reset successfully!');</script>";
        $_SESSION['reset_success'] = false;
    }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="../View/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form id='login' action="../View/login.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputUsername" name="inputUsername"
                                                placeholder="name@example.com" required/>
                                            <label for="inputUsername">Username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="inputPassword"
                                                type="password" placeholder="Password" required/>
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox"
                                                value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember
                                                Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="../View/forgot-password.php">Forgot Password?</a>
                                            <input class="btn btn-primary" name='dangnhap' type='submit' value="Login" >
                                        </div>
                                        <div class="card-footer text-center py-3">
                                            <div class="small"><a id="goToRegister">Need an account? Sign up!</a></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $("#login").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: '../Controller/login-action/action-login.php',
                data: $(this).serializeArray(),
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.status == 0) {
                            alert(response.message);
                        } else {
                            alert(response.message);
                            window.location.href = '../Controller/index.php';
                        }
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ajax request failed. Status:', status, 'Error:', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#goToRegister").click(function (event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '../Controller/login-action/set-action.php',
                    data: { action: 'register' },
                    success: function (response) {
                        try {
                            response = JSON.parse(response);
                            if (response.status == 0) {
                            } else {
                                window.location.href = '../Controller/index.php';
                            }
                        } catch (e) {
                            console.error('Error parsing JSON:', e);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Ajax request failed. Status:', status, 'Error:', error);
                    }
                });
            });
        });
    </script>

</body>

</html>