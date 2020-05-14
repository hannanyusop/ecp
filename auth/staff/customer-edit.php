<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'CUSTOMER EDIT';

$links = [
        'customer-list' => 'MANAGE CUSTOMER'
];

if(isset($_GET['id'])){

    $cust_q = $db->query("SELECT * FROM users WHERE id=$_GET[id] AND role_id=3");
    $cust = $cust_q->fetch_assoc();

    if(!$cust){
        echo "<script>alert('Customer not exist!');window.location='customer-list.php'</script>";
    }

//    if(isset($_POST['submit'])){
//
//
//        $check_q = $db->query("SELECT * FROM users WHERE email='$_POST[email]' AND id <> $_GET[id]");
//        $check = $check_q->fetch_assoc();
//
//        if($check){
//            echo "<script>alert('Email already exist!');window.location='customer-edit.php?id=$_GET[id]'</script>";
//        }
//
//        $fullname = strtoupper($_POST['full_name']);
//
//
//        if (!$db->query("UPDATE users SET fullname='$fullname', email = '$_POST[email]' WHERE id=$_GET[id]")) {
//            echo "Error: Inserting user data." . $db->error; exit();
//        }else{
//
//            #add customer account
//            echo "<script>alert('Customer information updated!');window.location='customer-list.php'</script>";
//        }
//
//    }
    if (isset($_POST['reset_password'])){

        $default_password = password_hash("secret", PASSWORD_BCRYPT);

        if (!$db->query("UPDATE users SET password='$default_password' WHERE id=$_GET[id]")) {
            echo "Error: Updating customer password." . $db->error; exit();
        }else{

            #add customer account
            echo "<script>alert('Customer password has been reset!');window.location='customer-list.php'</script>";
        }
    }
}else{
    echo "<script>alert('Error : missing parameter!');window.location='customer-list.php'</script>";
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
                                                <input id="email" type="email" class="form-control" name="email" value="<?= $cust['email']; ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="full_name" class="col-3 col-form-label">Full Name</label>
                                            <div class="col-9">
                                                <input id="full_name" type="text" class="form-control" name="full_name" value="<?= $cust['fullname']; ?>" readonly>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>

                            <div class="card-box">
                                <div class="card-body">

                                    <h2 class="card-title">Reset Password</h2>

                                    <form class="form-horizontal" method="post">

                                        <div class="form-group row mb-3">
                                            <label for="full_name" class="col-3 col-form-label">Password</label>
                                            <div class="col-9">
                                                <input id="full_name" type="text" class="form-control" name="password" value="secret" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-9">
                                                <button onclick="return confirm('Are you sure want to reset password for this user?')" type="submit" name="reset_password" class="btn btn-danger waves-effect waves-light">Reset Customer Password</button>
                                                <a href="option-list.php" class="btn btn-warning">Back</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('include/footer.php') ?>

            </div>
        </div>
    </body>
</html>