<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_customer.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'JOB LIST';

?>

<?php
    if(isset($_GET['status']) && $_GET['status'] != ""){

        $condition = "AND status= $_GET[status]";

    }else{
        $condition = " ";
    }
    $result = $db->query("SELECT * FROM jobs  WHERE customer_id=$user_id $condition ORDER BY status ASC");
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