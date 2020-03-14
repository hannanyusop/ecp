<!DOCTYPE html>
<html lang="en">
    
    <?= include('include/header.php'); ?>

    <?php


        require_once '../env.php';

        if (isset($_POST['forgot'])) {

            if (isset($_POST['email'])) {

                $user_q = $db->query("SELECT * FROM users WHERE email='$_POST[email]'");
                $job = $user_q->fetch_assoc();


                if (!$job) {
                    echo "<script>alert('Email not exist!');window.location='forgot-password-request.php'</script>";
                }
            }

            $key = generateResetPasswordKey();
            if (!$db->query("UPDATE users SET reset_password_key='$key' WHERE email='$_POST[email]'")) {
                echo "Error: Inserting user data." . $db->error;
                exit();
            } else {

                $body = "Ops,<br><br>
                <p>You've request to recover password on " . date("m/d/Y h:i:s a", time()) . " <i>IP ADDRESS: $_SERVER[REMOTE_ADDR]</i><br>
                To recover password please click this <a href='http://$_SERVER[HTTP_HOST]/ecp/auth/forgot-password.php?key=$key'>Link</a>.
                If link not working, copy 'http://$_SERVER[HTTP_HOST]/ecp/auth/forgot-password.php?key=$key' and paste to your browser's address bar.
                 If you not request this, please call Customer Service 06-425635654543 or drop an email at ecenterprinting@yahoo.com</p>
                
                <br><br>
                <small>
                    <i>This email was generated automatically by system. Don't reply this email
                        <br>For inquiry please call our Customer Service 06-425635654543</i>
                </small>
                <br><br>
                <small>
                    <br>
                </small>";


                sendEmail($_POST['email'], "Recover Password", $body);
                exit();
//                echo "<script>alert('Please check your email.');window.location='login.php '</script>";
            }

        }


    ?>

    <body class="authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">
                                
                                <div class="text-center w-75 m-auto">
                                    <a href="index.html">
                                        <span><img src="../assets/images/logo-dark.png" alt=""></span>
                                    </a>
                                    <p class="text-muted mb-4 mt-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                                </div>

                                <form method="post">

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Enter your email">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button name="forgot" class="btn btn-primary btn-block" type="submit"> Reset Password </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Back to <a href="login.php" class="text-white ml-1"><b>Log in</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->


        <?= include('include/footer.php'); ?>
        
    </body>

</html>