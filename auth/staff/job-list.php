<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'JOB LIST';
    if(isset($_GET['status']) && isset($_GET['name'])){

        if($_GET['status'] != ''){
            $condition = "WHERE j.status = $_GET[status] AND u.email LIKE '%$_GET[name]%'";
        }else{
            $condition = "WHERE u.email LIKE '%$_GET[name]%'";
        }

    }else{
        $condition = "";
    }

    $result = $db->query("SELECT *,j.id as job_id,u.id as user_id,s.fullname as handled_by,u.fullname as cname,u.email as cemail FROM jobs as j LEFT JOIN users as u ON j.customer_id=u.id LEFT JOIN users as s ON j.staff_id=s.id "." $condition ORDER BY status ASC");

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
                                        <label for="name" class="sr-only">Customer Nmae</label>
                                        <input type="text" name="name" id="name" class="form-control" value="<?= (isset($_GET['name']))? $_GET['name'] : '' ?>">
                                    </div>

                                    <div class="form-group mx-sm-3">
                                        <select class="custom-select " name="status">
                                            <option value="">All Status</option>
                                            <?php foreach (getJobStatus() as $key => $status){ ?>
                                                <option value="<?= $key ?>" <?= (isset($_GET['status']))? ($_GET['status'] == $key)? 'selected' : '' : '' ?>><?= $status; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                </form>


                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Name</th>
                                            <th>E-mail</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Handled By</th>
                                            <th>Created At</th>
                                            <th>Pickup Date</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($result->num_rows > 0){ while($job = $result->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $job['job_id']; ?></td>
                                                <td><?= $job['cname']; ?></td>
                                                <td><?= $job['cemail']; ?></td>
                                                <td><?= displayPrice($job['total_price']); ?></td>
                                                <td><?= getJobStatus($job['status']) ?></td>
                                                <td><?= $job['handled_by'] ?></td>
                                                <td><?= $job['created_at'] ?></td>
                                                <td><?= $job['pickup_date'] ?></td>
                                                <td><a class="text-info font-weight-bold" href="job-view.php?id=<?= $job['job_id']; ?>">View</a> </td>
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