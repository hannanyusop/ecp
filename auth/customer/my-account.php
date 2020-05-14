<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_customer.php') ?>
<?php include('include/header.php'); ?>
<?php

$page_title = 'MY ACCOUNT';

$links = [
];



if(isset($_POST['submit'])){


    $check_q = $db->query("SELECT * FROM users WHERE email='$_POST[email]' AND id <> $user_id");
    $check = $check_q->fetch_assoc();

    if($check){
        echo "<script>alert('Email already exist!');window.location='my-account.php'</script>";
    }


    $fullname = strtoupper($_POST['full_name']);

    if (!$db->query("UPDATE users SET fullname='$fullname', email = '$_POST[email]' WHERE id=$user_id")) {
        echo "Error: Inserting user data." . $db->error; exit();
    }else{

        echo "<script>alert('Information updated!');window.location='my-account.php'</script>";
    }

}elseif (isset($_POST['reset_password'])){

    $old = $_POST["old-password"];

    $new = $_POST["new-password"];

    if(strlen($new) < 5){
        echo "<script>alert('Please enter at least 5 character!!');window.location='my-account.php'</script>";
    }

    if (password_verify($old, $user['password'])) {

        if($new == $old){
            echo "<script>alert('Please enter different password!');window.location='my-account.php'</script>";
        }

        $password = password_hash($new, PASSWORD_BCRYPT);

        if (!$db->query("UPDATE users SET password='$password' WHERE id=$user_id")) {
            echo "Error: Updating password." . $db->error; exit();
        }else{
            echo "<script>alert('Password has been reset!');window.location='my-account.php'</script>";
        }
    }else{
        echo "<script>alert('Old password do not match!');window.location='my-account.php'</script>";
    }


}
?>


<body>
 <div id="wrapper">

            <?php include('include/topbar.php'); ?>
            <?php include('include/aside.php'); ?>

            <div class="content-page">
                <div class="content">
                    <?php include('include/breadcrumb.php'); ?>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card-box">
                                <div class="card-body">

                                    <h2 class="card-title">Basic Information</h2>

                                    <form class="form-horizontal" method="post">

                                        <div class="form-group row mb-3">
                                            <label for="email" class="col-3 col-form-label">E-mail</label>
                                            <div class="col-9">
                                                <input id="email" type="email" class="form-control" name="email" value="<?= $user['email']; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="full_name" class="col-3 col-form-label">Full Name</label>
                                            <div class="col-9">
                                                <input id="full_name" type="text" class="form-control" name="full_name" value="<?= $user['fullname']; ?>">
                                            </div>
                                        </div>



                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-9">
                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Update Details</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card-box">
                                <div class="card-body">

                                    <h2 class="card-title">Update Password</h2>

                                    <form class="form-horizontal" method="post">

                                        <div class="form-group row mb-3">
                                            <label for="old-password" class="col-3 col-form-label">Old Password</label>
                                            <div class="col-9">
                                                <input id="old-password" type="password" class="form-control" name="old-password" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="new-password" class="col-3 col-form-label">New Password</label>
                                            <div class="col-9">
                                                <input id="new-password" type="password" class="form-control" name="new-password" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="confirm-password" class="col-3 col-form-label">Confirm Password</label>
                                            <div class="col-9">
                                                <input id="confirm-password" type="password" class="form-control" name="confirm-password" required>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-9">
                                                <button type="submit" onclick="return Validate()" name="reset_password" class="btn btn-danger waves-effect waves-light">Change Password</button>
                                                <a href="option-list.php" class="btn btn-warning">Back</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    function Validate() {
                        var password = document.getElementById("new-password").value;
                        var confirmPassword = document.getElementById("confirm-password").value;
                        if (password != confirmPassword) {
                            alert("New Passwords and confirm password do not match!");
                            return false;
                        }
                        return true;
                    }
                </script>
                <?php include_once('include/footer.php') ?>

            </div>
        </div>
    </body>
</html>