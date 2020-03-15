<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'JOB REJECT';

    $links = [
            'example.link' => 'JOB VIEW',
            '' => '#'.$_GET['id']
    ];





if(isset($_GET['id'])){


    $result = $db->query("SELECT * FROM jobs WHERE id=$_GET[id] AND status=1");
    $job = $result->fetch_assoc();

    if(!$job){
        echo "<script>alert('Job not found!');window.location='dashboard.php'</script>";
    }

    $customer_q = $db->query("SELECT * FROM users WHERE id=$job[customer_id]");
    $customer = $customer_q->fetch_assoc();


    #add on list
    $job_result = $db->query("SELECT * FROM jobs_has_add_on as a LEFT JOIN add_on as b ON a.add_on_id=b.id WHERE job_id=$job[id]");


    if(isset($_POST['accept'])){

        #update job status
        if($_POST['confirm_date'] == '1'){
            $update_job = "UPDATE jobs SET status=2, staff_id=$user_id WHERE id=$job[id]";

            $body = "Your job #$job[id] has approved<br>
                            For more information please log-in into your dashboard.                             
                            <br><br>
                            <small>
                                <i>This email was generate automatically by system. Don't reply this email
                                    <br>For inquiry please call our Customer Service 06-425635654543</i>
                            </small>
                            <br><br>";

        }else{

            $merge_date = $_POST['pickup_date']." ".$_POST['pickup_time'];

            if (new DateTime() > new DateTime($merge_date)) {
                echo "<script>alert('Ops! Please Date & Time Already passed');window.location='job-accept.php?id=".$job[id]."'</script>"; exit();
            }


            #working hour 10am to 10 pm
            if($_POST['pickup_time'] < "10:00" && $_POST['pickup_time'] > "22:00"){
                echo "<script>alert('Ops! Please select time between 10 AM to 10 PM');window.location='job-accept.php?id=".$job[id]."'</script>";exit();
            }


            $update_job = "UPDATE jobs SET status=2,notes='$_POST[reasons]',pickup_date='$merge_date',staff_id=$user_id WHERE id=$job[id]";

            $body = "Your job #$job[id] has approved but <b>PICKUP DATE has been changed to ".date("H:i A d/M/Y", strtotime($merge_date))." </b>:<br>
                            <p>$_POST[reasons]</p><br>
                            For more information please log-in into your dashboard.                             
                            <br><br>
                            <small>
                                <i>This email was generate automatically by system. Don't reply this email
                                    <br>For inquiry please call our Customer Service 06-425635654543</i>
                            </small>
                            <br><br>";

        }

        if (!$db->query($update_job)) {
            echo "Error: " . $update_job . "<br>" . $db->error; exit();
        }

        #job transaction
        insertJobTransaction($job['id'], $user_id, 2, "JOB RECEIVE");
        insertNotification($customer['id'], 'Job Have been receive.', "Your job #$job[id] have been receive and our staff will process your document.");

        sendEmail($customer['email'], "JOB #$job[id] Approved By Admin", $body);
        echo "<script>alert('Successfully!');window.location='job-view.php?id=".$job[id]."'</script>";

    }
}else{
    echo "<script>alert('Invalid action!');window.location='dashboard.php'</script>";
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

                        <div class="radio radio-info form-check-inline mb-2">
                            <div class="radio radio-success mr-2">
                                <input type="radio" name="confirm_date" id="yes" value="1" required>
                                <label for="yes">I'm okay with the</label>
                            </div>

                            <div class="radio radio-danger mr-2">
                                <input type="radio" name="confirm_date" id="no" value="0" require>
                                <label for="no">Choose another date</label>
                            </div>
                        </div>

                        <div id="other">
                            <div class="form-group">
                                <label for="date">Date</label>
                                <input class="form-control" id="date" type="date" name="pickup_date" value="<?= date("Y-m-d", strtotime($job['pickup_date'])) ?>" >
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="time">Time</label>
                                <input class="form-control" id="time" type="time" name="pickup_time" value="<?= date("H:i", strtotime($job['pickup_date'])) ?>" >
                            </div>

                            <div class="form-group">
                                <label for="reasons">Reason</label>
                                <textarea id="reasons" name="reasons" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="clearfix mt-4">
                            <button type="submit" name="accept" class="btn btn-md btn-success">Accept Job</button>
                            <a href="job-view.php?id=<?=$_GET['id']?>" class="btn btn-md btn-warning">Back</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <?php include_once('include/footer.php') ?>
        <script type="text/javascript">
            $('#other').hide();
            $('input[type=radio][name=confirm_date]').change(function() {

                if($(this).val()  == '1'){
                    $('#other').hide();
                }else{
                    $('#other').show();
                }
            });
        </script>
    </div>
</div>
</body>
</html>