<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_customer.php') ?>
<?php include('include/header.php'); ?>
<link href="../../assets/libs/dropzone/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="../../assets/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />


<?php
    $page_title = 'CREATE PRINTING JOB';

    $links = [
    ];

    $user_id = $_SESSION['auth']['user_id'];
    $jobs = $_SESSION['jobs'][$user_id];
    $jobs['addOn'] = [];

    $subtotal = $jobs['price'];

    if(isset($_POST['add-on'])){

        foreach ($_POST['add-on'] as $id){

            $result = $db->query("SELECT * FROM add_on WHERE is_active=1 AND id=".$id);
            $addOn = $result->fetch_assoc();

            if(!is_null($addOn)){

                $jobs['addOn'][$id]['id'] =  (int)$addOn['id'];
                $jobs['addOn'][$id]['price'] =  (float)$addOn['price'];
                $jobs['addOn'][$id]['name'] =  $addOn['name'];
                $subtotal += $addOn['price'];
            }
        }

    }


    #total price
    $jobs['subtotal'] = (float)$subtotal;

    if($jobs['subtotal'] > $user['credit_balance']){
        echo "<script>alert('Sorry! Credit balance not enough!');window.location='job-step-3.php'</script>";
    }

    #save to session;
    $_SESSION['jobs'][$user_id] = $jobs;

    $credit = (float)$user['credit_balance'];
?>

<body>
<div id="wrapper">

    <?php include('include/topbar.php'); ?>
    <?php include('include/aside.php'); ?>

    <div class="content-page">
        <div class="content">
            <?php include('include/breadcrumb.php'); ?>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <!-- Logo & title -->
                        <div class="clearfix">
                            <div class="float-left">
                                <img src="assets/images/logo-dark.png" alt="" height="20">
                            </div>
                            <div class="float-right">
                                <h4 class="m-0 d-print-none">Quotation</h4>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                            </div><!-- end col -->
                            <div class="col-md-4 offset-md-2">
                                <div class="mt-3 float-right">
                                    <p class="m-b-10"><strong>Order Date : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; <?= date('d F Y') ?></span></p>
                                    <p class="m-b-10"><strong>Order Status : </strong> <span class="float-right"><span class="badge badge-danger">Unpaid</span></span></p>
                                    <p class="m-b-10"><strong>Order No. : </strong> <span class="float-right">- </span></p>
                                </div>
                            </div><!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row mt-3">
                            <div class="col-sm-6">
                                <h6>Billing Address</h6>
                                <address>
                                    <?= $user['fullname']; ?><br>
                                    Email: <?= $user['email']; ?>
                                </address>
                            </div> <!-- end col -->

                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4 table-centered">
                                        <thead>
                                        <tr><th>#</th>
                                            <th>Item</th>
                                            <th style="width: 10%">Cost</th>
                                            <th style="width: 10%">Quantity</th>
                                            <th style="width: 10%" class="text-right">Total</th>
                                        </tr></thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <b>Print</b> <br/>
                                                Mode : <?=  $jobs['colour']; ?>
                                            </td>
                                            <td><?= displayPrice($jobs['mode_price'])?></td>
                                            <td><?= $jobs['total_page'] ?> pg(s)</td>
                                            <td class="text-right"><?= displayPrice($jobs['price']); ?></td>
                                        </tr>

                                        <?php foreach ($jobs['addOn'] as $job) { ?>
                                            <tr>
                                                <td>2</td>
                                                <td>
                                                    <b>Add-on: <?= $job['name'] ?></b>
                                                </td>
                                                <td><?= displayPrice($job['price']) ?></td>
                                                <td>1</td>
                                                <td class="text-right"><?= displayPrice($job['price']); ?></td>
                                            </tr>

                                        <?php } ?>

                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive -->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="clearfix pt-5">
                                    <h6 class="text-muted">Notes:</h6>

                                    <small class="text-muted">
                                        All accounts are to be paid within 7 days from receipt of
                                        invoice. To be paid by cheque or credit card or direct payment
                                        online. If account is not paid within 7 days the credits details
                                        supplied as confirmation of work undertaken will be charged the
                                        agreed quoted fee noted above.
                                    </small>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="float-right">
                                    <p><b>Sub-total:</b> <span class="float-right"><?= displayPrice($jobs['subtotal']) ?></span></p>
                                    <p><b>Tax (0%):</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; <?= displayPrice(0.00) ?></span></p>
                                    <h3><?= displayPrice($jobs['subtotal']) ?></h3>
                                </div>
                                <div class="clearfix"></div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <form action="job-step-2.php" method="post" enctype="multipart/form-data">
                            <div class="mt-4 mb-1">
                                <div class="text-right d-print-none">
                                    <a class="btn btn-md btn-warning" href="btn btn-warning waves-effect waves-light">Previous</a>
                                    <a href="job-step-confirm.php" class="btn btn-info waves-effect waves-light" type="submit">Confirm</a>
                                    <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-printer mr-1"></i> Print</a>
                                </div>
                            </div>
                        </form>

                    </div> <!-- end card-box -->
                </div> <!-- end col -->
            </div>
        </div>
        <?php include_once('include/footer.php') ?>
        <script src="../../assets/libs/dropzone/dropzone.min.js"></script>
        <script src="../../assets/libs/dropify/dropify.min.js"></script>
        <script src="../../assets/js/pages/form-fileuploads.init.js"></script>

    </div>
</div>
</body>
</html>