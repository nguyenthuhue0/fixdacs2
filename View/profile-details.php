<?php
    include_once __DIR__ . '/../Model/database.php';
    include_once __DIR__ . '/../Model/user.php';
    include_once __DIR__ . '/../Model/userInfo.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $db = database::getDB();
    $user = new User($db);
    $userInfo = new userInfo($db);
    if (isset($_GET['id'])) {
        $userP = $user->getUserById($_GET['id']);
        $userInfo->getUserInfo($_GET['id']);
    }
    else{
        $userP = $user->getUserById($_SESSION['userId']);
        $userInfo->getUserInfo($_SESSION['userId']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Profile Details</title>
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
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Profile Details</h3>
                                </div>
                                <div class="card-body">
                                    <form id='profile-submit' action="../View/profile-details.php" method='post'>
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputUsername" name="inputUsername"
                                                        type="text" placeholder="Enter your first name" value="<?php echo isset($userP) ? $userP['username']: '' ?>" required/>
                                                    <label for="inputUsername">Username</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="inputEmail" type="email"
                                                placeholder="name@example.com" value="<?php echo isset($userP) ? $userP['email']: '' ?>" required/>
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputAddress" name="inputAddress"
                                                type="text" placeholder="" value="<?php echo isset($userInfo) ? $userInfo->getAddress(): '' ?>" required/>
                                            <label for="inputAddress">Address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPhoneNumber" name="inputPhoneNumber"
                                                type="text" placeholder="123-456-7890" value="<?php echo isset($userInfo) ? $userInfo->getPhoneNumber(): '' ?>" required/>
                                            <label for="inputPhoneNumber">Phone number</label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputFirstName"
                                                        name="inputFirstName" type="text"
                                                        placeholder="" value="<?php echo isset($userInfo) ? $userInfo->getFirstName(): '' ?>"required/>
                                                    <label for="inputFirstName">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputLastName" name="inputLastName"
                                                        type="text" placeholder="" value="<?php echo isset($userInfo) ? $userInfo->getLastName(): '' ?>" required/>
                                                    <label for="inputLastName">Last Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <input type="submit" class="btn btn-primary btn-block" value="Save profile">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $("#profile-submit").submit(function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: '../Controller/user-action/profile-saving.php',
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

</body>

</html>