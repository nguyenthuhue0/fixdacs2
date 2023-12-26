<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include_once __DIR__ . '/../Model/database.php';
    include_once __DIR__ . '/../Model/user.php';
    $error="";
    if(isset($_POST["reset"])){
        $email = $_POST["inputEmail"];
        $db = database::getDB();
        $user = new User($db);
        if($user->isEmailTaken($email)){
            $newPass = substr(md5(rand(0,999999)),0,8);
            $user->updatePass($email, $newPass);

            require "../PHPMailer-master/src/PHPMailer.php"; 
            require "../PHPMailer-master/src/SMTP.php"; 
            require '../PHPMailer-master/src/Exception.php'; 
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            try {
                $mail->SMTPDebug = 0; //0,1,2: chế độ debug
                $mail->isSMTP();  
                $mail->CharSet  = "utf-8";
                $mail->Host = 'smtp.gmail.com';  //SMTP servers
                $mail->SMTPAuth = true; // Enable authentication
                $mail->Username = 'kietnca.22ds@vku.udn.vn'; // SMTP username
                $mail->Password = 'meft kluy jmkw ggli';   // SMTP password
                $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
                $mail->Port = 465;  // port to connect to                
                $mail->setFrom('kietnca.22ds@vku.udn.vn', 'admin' ); 
                $mail->addAddress($email); 
                $mail->isHTML(true);  // Set email format to HTML
                $mail->Subject = 'Reset password';
                $noidungthu = 'Your new password is '.$newPass; 
                $mail->Body = $noidungthu;
                $mail->smtpConnect( array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    )
                ));
                $mail->send();
                $_SESSION['reset_success'] = true;
                header("Location: ../Controller/index.php" );
                exit();
            } catch (Exception $e) {
                echo 'Error: ', $mail->ErrorInfo;
            }
        }
        else{
            $error = "The email you entered is not registered as a member.";
        }

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
    <title>Password Reset - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                                    <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-3 text-muted">Enter your email address and we will send you a password.</div>
                                    <form id="resetpass-submit" method="post">
                                        <?php if($error != "") :?>
                                        <div class="alert alert-danger"><?php echo $error?></div>
                                        <?php endif;?>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="inputEmail" id="inputEmail" type="email"
                                                placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="./login.php">Return to login</a>
                                            <button name="reset" class="btn btn-primary" href="login.html"
                                                type="submit">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="./register.php">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
</body>
</html>
