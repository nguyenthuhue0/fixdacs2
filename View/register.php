<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
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
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form id='register' action="../View/register.php" method = 'post'>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputUsername" name="inputUsername" type="text" placeholder="Enter your first name" required/>
                                                        <label for="inputFirstName">Username</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="inputEmail" type="email"
                                                placeholder="name@example.com" required/>                                                
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Create a password" required/>
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" type="password" placeholder="Confirm password" required/>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <input type="submit" class="btn btn-primary btn-block" value ="Create Account">
                                            </div>
                                            <div class="card-footer text-center py-3">
                                                <div class="small"><a id="goToLogin">Have an account? Go to login</a></div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $("#register").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: '../Controller/login-action/action-register.php',
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
            $("#goToLogin").click(function (event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '../Controller/login-action/set-action.php',
                    data: { action: 'login' },
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
