<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_customer.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'JOB VIEW';

    $links = [
    ];


    if(isset($_GET['id'])){
        $result = $db->query("SELECT * FROM jobs WHERE customer_id=$user_id AND id=$_GET[id]");

        $job = $result->fetch_assoc();

        if(!$job){
            echo "<script>alert('Job not found!');window.location='dashboard.php'</script>";
        }

        #add on list
        $job_result = $db->query("SELECT * FROM jobs_has_add_on as a LEFT JOIN add_on as b ON a.add_on_id=b.id WHERE job_id=$job[id]");

        #job transaction
        $job_transaction = $db->query("SELECT * FROM job_transaction WHERE job_id=$job[id]");
    }else{
        echo "<script>alert('Invalid action!');window.location='dashboard.php'</script>";
    }
?>

<?php

    $trans = [];
    while($transaction = $job_transaction->fetch_assoc()) {

        $trans[$transaction['status']] = [
                'note' => $transaction['note'],
                'time' => $transaction['created_at']
        ];
    }

?>


<style type="text/css">
    .timeline {
        position: relative;
        margin: 4em 0 2em;
        padding: 1em;
    }

    .timeline:before {
        content: "";
        position: absolute;
        height: calc(100% + 2em);
        width: 1px;
        border-left: 4px dotted #c9c9c9;

        left: 20px;
        top: -1em;
        bottom: 0;
        z-index: 0;
    }

    .timeline li {
        list-style: none;
    }

    .timeline li:before {
        position: absolute;
        content: "·";
        font-size: 120px;
        vertical-align: middle;
        line-height: 8px;
        left: 8px;
    }

    .timeline p {
        margin-left: 2em;
    }

</style>

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

                            <div class="clearfix text-right mb-3">
                                <?php if($job['status'] == '3'){ ?>
                                    <a href="job-invoice.php?id=<?= $job['id'] ?>" class="btn btn-md btn-info">View Invoice</a>
                                <?php } ?>
                                <a href="job-list.php" class="btn btn-md btn-success">Back To List</a>
                            </div>

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

                            <?php if($job['status'] == 3){ ?>
                                <div class="row">
                                    <div class="col-12 text-center align-content-center">
                                        <h4>Pickup Security Code: </h4>

                                        <h4 class="font-weight-bold"><?= $job['pickup_code'] ?></h4>

                                        <p>or show this to counter</p>
                                        <?php echo '<img class="mt-2 mb-2" src="data:image/png;base64,' . base64_encode($barCodePNG->getBarcode($job['pickup_code'], $barCodePNG::TYPE_CODE_128)) . '">'; ?>
                                        <br>
                                        <small class="text-info">Pickup Security Code will be generate after job completed.</small>
                                    </div>
                                </div>
                            <?php } ?>

                            <ul class="timeline">
                                <?php foreach (getTrackListAccepted() as $key => $status) {; ?>
                                    <?php if(isset($trans[$key])){ ?>
                                        <li style="color: #20a80d;">
                                            <p><b><?= $trans[$key]['time'] ?></b> - <?= $status ?></p>
                                        </li>
                                <?php }else{ ?>
                                    <li style="color: #e71800;">
                                        <p><b><?= $status ?></b></p>
                                    </li>
                                <?php } } ?>
                            </ul>

                        </div>
                    </div>
                </div>
                <?php include_once('include/footer.php') ?>
            </div>
        </div>
    </body>
</html>