<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'CUSTOMER ADD';

$links = [
        'customer-list.php' => 'MANAGE CUSTOMER'
];

if(isset($_POST['submit'])){

    if($_POST['email'] == '' || $_POST['full_name'] == ''){
        echo "<script>alert('Please insert required field!');window.location='customer-add.php'</script>";
    }

    $user_q = $db->query("SELECT * FROM users WHERE email='$_POST[email]'");
    $job = $user_q->fetch_assoc();


    if($job){
        echo "<script>alert('Email already exist!');window.location='customer-add.php'</script>";
    }

    $fullname = strtoupper($_POST['full_name']);

    $default_password = password_hash("secret", PASSWORD_BCRYPT);
    if (!$db->query("INSERT INTO users (role_id, email, password, fullname, is_active, is_confirm, created_at) VALUES (3, '$_POST[email]', '$default_password', '$fullname', 1, 1, CURRENT_TIMESTAMP)")) {
        echo "Error: Inserting user data." . $db->error; exit();
    }else{

        #add customer account

        $last_user_id = (int)$db->insert_id;
        if(!$db->query("INSERT INTO accounts (user_id, credit_balance, credit_total, address) VALUES ($last_user_id, 0.00, 0.00, '')")){

            $db->query("DELETE FROM users WHERE id=$last_user_id");
            #delete prev customer
            echo "Error: Inserting user account." . $db->error; exit();
        }

        $body = "Hye $fullname,<br>
            This email has been registered by admin. Below is your login credential:<br><br>
            E-mail : $_POST[email]<br>
            Password : secret <br>
            Account Balance : RM0.00<br>
            Login Link : <a href='http://$_SERVER[HTTP_HOST]/auth/login.php'>http://$_SERVER[HTTP_HOST]/auth/login.php</a>
            
            <br><br>
            <small>
                <i>This email was generated automatically by system. Don't reply this email
                    <br>For inquiry please call our Customer Service 06-425635654543</i>
            </small>
            <br><br>
            <small>";

        il($_POST['email'], 'Welcome to ezPrint', $body);
        echo "<script>alert('Customer Created!');window.location='customer-add.php'</script>";
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

                                    <form class="form-horizontal" method="post">

                                        <div class="form-group row mb-3">
                                            <label for="email" class="col-3 col-form-label">E-mail</label>
                                            <div class="col-9">
                                                <input id="email" type="email" class="form-control" name="email" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="full_name" class="col-3 col-form-label">Full Name</label>
                                            <div class="col-9">
                                                <input id="full_name" type="text" class="form-control" name="full_name" required>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="full_name" class="col-3 col-form-label">Password</label>
                                            <div class="col-9">
                                                <input id="full_name" type="text" class="form-control" name="password" value="secret" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-9">
                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Add Customer</button>
                                                <a href="customer-list.php" class="btn btn-warning">Back</a>
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