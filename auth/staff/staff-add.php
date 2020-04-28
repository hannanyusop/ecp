<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_manager.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'STAFF ADD';

$links = [
        'staff-list.php' => 'MANAGE STAFF'
];

if(isset($_POST['submit'])){

    if($_POST['email'] == '' || $_POST['full_name'] == ''){
        echo "<script>alert('Please insert required field!');window.location='staff-add.php'</script>";
    }

    $roles = array(1,2);

    if(!in_array($_POST['role'],$roles)){
        echo "<script>alert('Invalid role!');window.location='staff-add.php'</script>";
    }

    $user_q = $db->query("SELECT * FROM users WHERE email='$_POST[email]'");
    $job = $user_q->fetch_assoc();


    if($job){
        echo "<script>alert('Email already exist!');window.location='staff-add.php'</script>";
    }

    $fullname = strtoupper($_POST['full_name']);

    $default_password = password_hash("secret", PASSWORD_BCRYPT);
    if (!$db->query("INSERT INTO users (role_id, email, password, fullname, is_active, is_confirm, created_at) VALUES ($_POST[role], '$_POST[email]', '$default_password', '$fullname', 1, 1, CURRENT_TIMESTAMP)")) {
        echo "Error: Inserting user data." . $db->error; exit();
    }else{

        echo "<script>alert('Staff Created!');window.location='staff-add.php'</script>";
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
                                            <label for="role" class="col-3 col-form-label">Roles</label>
                                            <div class="col-9">
                                                <select id="role" name="role" type="custom-select">
                                                    <option value="1">MANAGER</option>
                                                    <option value="2" selected>STAFF</option>
                                                </select>
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
                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Add Staff</button>
                                                <a href="staff-list.php" class="btn btn-warning">Back</a>
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