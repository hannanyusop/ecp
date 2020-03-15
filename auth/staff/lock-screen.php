<!DOCTYPE html>
<html lang="en">
    
    <?php include_once('include/header.php'); ?>
    <?php include_once('../permission_staff.php') ?>

    <?php

        if(isset($_GET['locked'])){
            $_SESSION['locked'] = true;
        }

        if(isset($_POST['unlock'])){


        if (password_verify($_POST['password'], $user['password'])) {

            unset($_SESSION['locked']);
            echo "<script>alert('Welcome back!');window.location='dashboard.php'</script>";

        }else{
            echo "<script>alert('Invalid Password!');window.location='lock-screen.php'</script>";
        }

        }


    ?>


    <body class="bg-dark authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <h3 class="text-danger mb-4 mt-3">Locked!</h3>
                                </div>

                                <form method="post">


                                    <div class="text-center w-75 m-auto">
                                        <img src="../../assets/images/users/user-1.jpg" height="88" alt="user-image" class="rounded-circle shadow">
                                        <h4 class="text-dark-50 text-center mt-3">Hi ! <?= $user['fullname'] ?> </h4>
                                        <p class="text-muted mb-4">Enter your password to access the admin.</p>
                                    </div>


                                    <div class="form-group mb-3">
                                        <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button name="unlock" class="btn btn-primary btn-block" type="submit"> Unlock </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Not you? return <a href="../logout.php" class="text-white ml-1"><b>Login</b></a></p>
                            </div> <!-- end col -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php include_once('../include/footer.php'); ?>
        
    </body>

</html>