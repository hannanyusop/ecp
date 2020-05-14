<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'PAGE TITLE';

$links = [
        'example.link' => ''
];

$pending = $db->query("SELECT * FROM jobs WHERE status=1");
$in_progress = $db->query("SELECT * FROM jobs WHERE status=2");

?>


<body>
 <div id="wrapper">

            <?php include('include/topbar.php'); ?>
            <?php include('include/aside.php'); ?>

            <div class="content-page">
                <div class="content">
                    <?php include('include/breadcrumb.php'); ?>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card-box">
                                <h4 class="header-title">In Pogress Job</h4>
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
                                        <?php if($in_progress->num_rows > 0){ while($job = $in_progress->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $job['id']; ?></td>
                                                <td><?= displayPrice($job['total_price']); ?></td>
                                                <td><?= getJobStatus($job['status']) ?></td>
                                                <td><?= $job['created_at'] ?></td>
                                                <td><?= $job['pickup_date'] ?></td>
                                                <td><a href="job-view.php?id=<?= $job['id']; ?>">View</a> </td>
                                            </tr>
                                        <?php } }else{ ?>
                                            <tr>
                                                <td class="text-center" colspan="6">No data</td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-box">
                                <h4 class="header-title">Pending Job</h4>
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
                                        <?php if($pending->num_rows > 0){ while($pending_job = $pending->fetch_assoc()){ ;?>
                                            <tr>
                                                <td><?= $pending_job['id']; ?></td>
                                                <td><?= displayPrice($pending_job['total_price']); ?></td>
                                                <td><?= getJobStatus($pending_job['status']) ?></td>
                                                <td><?= $pending_job['created_at'] ?></td>
                                                <td><?= $pending_job['pickup_date'] ?></td>
                                                <td><a href="job-view.php?id=<?= $pending_job['id']; ?>">View</a> </td>
                                            </tr>
                                        <?php } }else{ ?>
                                            <tr>
                                                <td class="text-center" colspan="6">No data</td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    </tbody>
                                    </table>
                                    <div class="text-center mt-3">
                                        <a href="job-list-my.php?name=&status=1">
                                            <small class="text-success font-weight-bold">Show more</small>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5">

                        </div>
                    </div>
                </div>
                <?php include_once('include/footer.php') ?>

            </div>
        </div>
    </body>
</html>