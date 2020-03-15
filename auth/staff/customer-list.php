<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'MANAGE CUSTOMER';


    if (isset($_GET['name']) && isset($_GET['email'])) {

        $condition = "AND fullname like '%$_GET[name]%' AND  email LIKE '%$_GET[email]%'";

    } else {
        $condition = "";
    }

    $result = $db->query("SELECT *,users.id as customer_id FROM users LEFT JOIN accounts ON users.id=accounts.user_id WHERE role_id=3 " . $condition);


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
                                        <label for="email" class="sr-only">Customer Email</label>
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Customer Email" value="<?= (isset($_GET['email']))? $_GET['email'] : '' ?>">
                                    </div>

                                    <div class="form-group mx-sm-3">
                                        <label for="name" class="sr-only">Customer Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Customer Name" value="<?= (isset($_GET['name']))? $_GET['name'] : '' ?>">
                                    </div>

                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-2">Search</button>
                                    <a href="customer-list.php" class="mr-2 btn btn-warning waves-effect waves-light">Reset</a>
                                    <a href="customer-add.php" class="mr-2 btn btn-success waves-effect waves-light float-right">Add Customer</a>
                                </form>


                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>E-MAIL</th>
                                            <th>FULL NAME</th>
                                            <th>CREDIT BALANCE</th>
                                            <th>REGISTERED DATE</th>
                                            <th>ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($result->num_rows > 0){ while($customer = $result->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $customer['id']; ?></td>
                                                <td><?= $customer['email']; ?></td>
                                                <td><?= $customer['fullname'] ?></td>
                                                <td class="font-weight-bold text-success"><?= displayPrice($customer['credit_balance']); ?></td>
                                                <td><?= $customer['created_at'] ?></td>
                                                <td>
                                                    <a href="customer-edit.php?id=<?= $customer['customer_id']; ?>" class="font-weight-bold text-info">Edit</a> |
                                                    <a href="customer-topup.php?id=<?= $customer['customer_id']; ?>" class="font-weight-bold text-success">Topup</a>
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