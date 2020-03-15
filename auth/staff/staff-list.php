<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_manager.php') ?>
<?php include('include/header.php'); ?>

<?php

if(isset($_GET['name']) && isset($_GET['role'])){

    $condition = "email LIKE '%$_GET[name]%'";

    $c_role = "AND role_id  IN(1,2)";

    if($_GET['role'] != ''){
        $c_role = "AND role_id = $_GET[role]";
    }

    $result = $db->query("SELECT * FROM users WHERE $condition $c_role");
}else{
    $result = $db->query("SELECT * FROM users WHERE role_id  IN(1,2) ");
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

                        <div class="col-md-12">
                            <div class="card-box">

                                <form class="form-inline mb-4">

                                    <div class="form-group mx-sm-3">
                                        <label for="name" class="sr-only">Customer Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name/Email" value="<?= (isset($_GET['name']))? $_GET['name'] : '' ?>">
                                    </div>

                                    <div class="form-group mx-sm-3">
                                        <select class="custom-select " name="role">
                                            <option value="">MANAGER / STAFF</option>
                                            <?php foreach (getBackendRole() as $key => $role){ ?>
                                                <option value="<?= $key ?>" <?= (isset($_GET['role']))? ($_GET['role'] == $key)? 'selected' : '' : '' ?>><?= $role; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-2">Search</button>
                                    <a href="staff-list.php" class="mr-2 btn btn-warning waves-effect waves-light">Reset</a>
                                </form>


                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>E-MAIL</th>
                                            <th>FULL NAME</th>
                                            <th>ROLE</th>
                                            <th>LAST LOGIN</th>
                                            <th>LAST IP ADDRESS</th>
                                            <th>ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($result->num_rows > 0){ while($customer = $result->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $customer['id']; ?></td>
                                                <td><?= $customer['email']; ?></td>
                                                <td><?= $customer['fullname'] ?></td>
                                                <td><?= getRole($customer['role_id']); ?></td>
                                                <td><?= $customer['last_login_at'] ?></td>
                                                <td><?= $customer['last_ip_address'] ?></td>
                                                <td>
                                                    <a href="staff-view.php?id=<?= $customer['id']; ?>" class="font-weight-bold text-info">View</a> |
                                                    <a href="staff-edit.php?id=<?= $customer['id']; ?>" class="font-weight-bold text-success">Edit</a>
                                                </td>
                                            </tr>
                                        <?php } }else{ ?>
                                            <tr>
                                                <td class="text-center" colspan="6">No data</td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive-->
                            </div> <!-- end card-box -->
                        </div>

                    </div>
                </div>
                <?php include_once('include/footer.php') ?>

            </div>
        </div>
    </body>
</html>