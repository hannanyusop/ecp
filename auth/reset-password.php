<!DOCTYPE html>
<html lang="en">
    
    <?= include('include/header.php'); ?>

    <?php

    require_once '../env.php';

    if(isset($_GET['key'])){


        #check if key is exist
        $user_q = $db->query("SELECT * FROM users WHERE reset_password_key='$_GET[key]'");
        $user = $user_q->fetch_assoc();


        if(!$user){
            echo "<script>alert('Invalid Key!');window.location='forgot-password-request.php'</script>";
        }

        if(isset($_POST['reset'])){

            $hash_pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            if (!$db->query("UPDATE users SET password='$hash_pass',reset_password_key=null WHERE id='$user[id]'")) {
                echo "Error: Inserting user data." . $db->error; exit();
            }else{

                echo "<script>alert('Password successfully recovered!');window.location='login.php '</script>";
            }

        }

    }else{

        echo "<script>alert('Invalid URL');window.location='forgot-password-request.php '</script>";
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
                                    <p class="text-muted mb-4 mt-3">Enter your new password.</p>
                                </div>

                                <form method="post">

                                    <div class="form-group mb-3">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" name="email" type="email" value="<?= $user['email'] ?>" readonly>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">New Password</label>
                                        <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your new password">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Confirm New Password</label>
                                        <input class="form-control" type="password" required="" id="confirm_password" name="confirm_password" placeholder="Enter your new password">
                                        <small class="clearfix" id="message"></small>

                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button name="forgot" class="btn btn-primary btn-block" type="submit"> Change Password </button>
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
        <script type="text/javascript">

            $('#password, #confirm_password').on('keyup', function () {

                if($('#confirm_password').val() != '' || $('#password').val() != ''){

                    if ($('#password').val() == $('#confirm_password').val()) {
                        $('#message').html('Matching').css('color', 'green');
                    } else {
                        $('#message').html('Password Not Matching').css('color', 'red');

                    }
                }else{
                    $('#message').html('').css('color', 'green');
                }

            });
        </script>


    </body>

</html>