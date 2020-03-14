<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_customer.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'DASHBOARD';
    $result = $db->query("SELECT * FROM jobs WHERE customer_id=$user_id AND status !=5 ORDER BY status ASC LIMIT 10");

?>


<body>
 <div id="wrapper">

            <?php include('include/topbar.php'); ?>
            <?php include('include/aside.php'); ?>

            <div class="content-page">
                <div class="content">
                    <?php include('include/breadcrumb.php'); ?>

                    <div class="row">

                        <div class="col-md-8">
                            <div class="card-box">
                                <h4 class="header-title">Job List</h4>

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Order Number</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Pickup Date</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($result->num_rows > 0){ while($job = $result->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $job['id']; ?></td>
                                                <td><?= displayPrice($job['total_price']); ?></td>
                                                <td><?= getJobStatus($job['status']) ?></td>
                                                <td><?= $job['created_at'] ?></td>
                                                <td><?= $job['pickup_date'] ?></td>
                                                <td>
                                                    <a class="btn btn-xs btn-info" href="job-view.php?id=<?= $job['id']; ?>">View</a>
                                                    <?php if($job['status'] == 1){ ?>
                                                        <a class="btn btn-xs btn-danger"  onclick="return confirm('Are you sure want to delete this job?')" href="job-delete.php?id=<?= $job['id'] ?>">Delete</a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } }else{ ?>
                                            <tr>
                                                <td class="text-center" colspan="6">No data</td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="text-center mt-3">
                                        <small class="text-success font-weight-bold">Show more</small>
                                    </div>
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