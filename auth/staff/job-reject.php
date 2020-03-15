<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'JOB REJECT';

    $links = [
            'example.link' => 'JOB VIEW',
            "job-view.php?id=".$_GET['id'] => '#'.$_GET['id']
    ];


if(isset($_GET['id'])){

    $result = $db->query("SELECT * FROM jobs WHERE id=$_GET[id] AND status=1");

    $job = $result->fetch_assoc();

    if(!$job){
        echo "<script>alert('Job not found!');window.location='dashboard.php'</script>";
    }

    if(isset($_POST['reject'])){

        #customer details
        $customer_sql = $db->query("SELECT *,accounts.id as account_id,users.id as customer_id FROM users LEFT JOIN accounts ON users.id = accounts.user_id WHERE users.id=$job[customer_id]");
        $customer = $customer_sql->fetch_assoc();

        #update job status
        $update_job ="UPDATE jobs SET status=4, staff_id=$user_id,notes='$_POST[reasons]' WHERE id=$job[id]";

        if (!$db->query($update_job)) {
            echo "Error: " . $update_job . "<br>" . $db->error; exit();
        }

        #refund money
        $credit_balance = $customer['credit_balance']+$job['total_price'];


        $update_account = "UPDATE accounts SET credit_balance=$credit_balance WHERE user_id = $customer[customer_id]";

        if (!$db->query($update_account)) {
            echo "Error: " . $update_account . "<br>" . $db->error; exit();
        }

        #insert to credit transaction
        #type = 2  (payment)
        $credit_transaction = "INSERT INTO credit_transaction (account_id, job_id, staff_id, type, amount, current_balance, created_at) VALUES ($customer[account_id], $job[id], $user_id, 3, $job[total_price], $credit_balance, CURRENT_TIMESTAMP)";
        if (!$db->query($credit_transaction)) {
            echo "Error: " . $credit_transaction . "<br>" . $db->error; exit();
        }else{
            $body = "Your job #$job[id] created on $job[created_at] has been rejected due:<br>
                            <p>$_POST[reasons]</p><br>
                            For more information please log-in into your dashboard.                             
                            <br><br>
                            <small>
                                <i>This email was generate automatically by system. Don't reply this email
                                    <br>For inquiry please call our Customer Service 06-425635654543</i>
                            </small>
                            <br><br>
                            <small>
                                <i>'To give customers the most compelling printing experience possible' <br>- Hannan Yusop (Managing Director & Founder)</i>
                                <br>
                            </small>";

            #job transaction
            insertJobTransaction($job['id'], $user_id, 3, "JOB REJECTED");
            insertNotification($customer['id'], 'Job Have been rejected.', "Your job #$job[id] have been rejected. Please view the details.");

            sendEmail($customer['email'], "JOB #$job[id] Cancelled By Admin", $body);

            echo "<script>alert('Successfully rejected!');window.location='dashboard.php'</script>";

        }
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

                            <h3 class="text-success">Total Paid: <?= displayPrice($job['total_price']); ?></h3>

                            <br>Reason:<br><small class="text-info"> <?= $job['notes'] ?></small><br>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <a target="_blank" href="<?= $job['file']; ?>"> <i class="fa-8x fa fa-file-pdf m-2"></i></a>
                            <br><small>*click icon to view file</small>
                        </div>
                    </div>

                    <form method="post">
                        <div class="form-group">
                            <label for="reasons">Reason</label>
                            <textarea id="reasons" name="reasons" class="form-control" rows="10"></textarea>
                        </div>

                        <div class="clearfix mt-4">
                            <button type="submit" name="reject" class="btn btn-md btn-success">Reject Job & Refund Money</button>
                            <a href="job-view.php?id=<?=$_GET['id'];?>"  class="btn btn-md btn-warning">Back</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <?php include_once('include/footer.php') ?>
    </div>
</div>
</body>
</html>