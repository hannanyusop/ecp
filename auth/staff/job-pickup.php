<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'JOB ACCEPT';

    $links = [
            'example.link' => 'JOB VIEW',
            '' => '#'.$_GET['id']
    ];

    if(isset($_GET['id'])){

        $result = $db->query("SELECT * FROM jobs WHERE id=$_GET[id] AND status=3");
        $job = $result->fetch_assoc();

        if(!$job){
            echo "<script>alert('Job not found!');window.location='dashboard.php'</script>";
        }
        #add on list
        $job_result = $db->query("SELECT * FROM jobs_has_add_on as a LEFT JOIN add_on as b ON a.add_on_id=b.id WHERE job_id=$job[id]");


    }else{
        echo "<script>alert('Invalid action!');window.location='job-list.php'</script>";
    }


?>


<body>
<div id="wrapper">

    <?php include('include/topbar.php'); ?>
    <?php include('include/aside.php'); ?>

    <div class="content-page">
        <div class="content">
            <?php include('include/breadcrumb.php'); ?>
            <div class="col-md-6 offset-md-3">
                <div class="card-box">
                    <div class="clearfix mb-4 float-right">
                        <a href="job-list.php" class="btn btn-md btn-warning">Back</a>
                    </div>

                    <h3>Order Number: #<?= $job['id']; ?></h3>

                    <div class="row">

                        <div class="col-md-8 col-sm-12 lead">
                            Status: <?= getJobStatus($job['status']); ?><br>

                            <p>Add on:</p>
                            <ol>
                                <?php if($job_result->num_rows > 0){ while($add = $job_result->fetch_assoc()){ ;?>
                                    <li><?= strtoupper($add['name'])." - ".displayPrice($add['price']) ?></li>
                                <?php } }else{ ?>
                                    <p>No Add On</p>
                                <?php } ?>
                            </ol>

                            Total Paid: <?= displayPrice($job['total_price']); ?><br>

                            <br>Reason:<br><small class="text-info"> <?= $job['notes'] ?></small><br>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <a target="_blank" href="<?= $job['file']; ?>"> <i class="fa-8x fa fa-file-pdf m-2"></i></a>
                            <br><small>*click icon to view file</small>
                        </div>
                    </div>

                    <form method="post">

                        <?php
                        if(isset($_POST['check_code'])){

                            $_SESSION[$user_id]['code'] = $_POST['code'];

                            if($job['pickup_code'] == strtoupper($_POST['code'])){
                                $db->query("UPDATE jobs SET status=5 WHERE id=$job[id]");

                                insertJobTransaction($job['id'], $user_id, 5, "DOCUMENT HAS BEEN COLECTTED");
                                insertNotification($job['customer_id'], 'Job Have been collected.', "Your job #$job[id] has been collected.");

                                echo "<script>alert('Code Accepted!');window.location='job-view.php?id=$_GET[id]'</script>";
                            }else{ ?>

                                <div class="text-center text-danger font-weight-bold mb-2">Ops! You've entered wrong Pickup Security Code!</div>

                            <?php }
                        }
                        ?>

                        <div class="form-group">
                            <input class="form-control form-control-lg" minlength="5" name="code" placeholder="Pickup Security Code (EX: SH2R7)" value="<?= (isset($_SESSION[$user_id]['code']))? $_SESSION[$user_id]['code'] : "" ?>" required>
                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                        </div>


                        <div class="clearfix mt-4">
                            <button type="submit" name="check_code" class="btn btn-lg btn-success  btn-block">CHECK CODE</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <?php include_once('include/footer.php') ?>
        <script type="text/javascript">

        </script>
    </div>
</div>
</body>
</html>