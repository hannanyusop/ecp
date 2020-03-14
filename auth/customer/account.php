<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_customer.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'CREDIT TRANSACTION HISTORY';

    $result = $db->query("SELECT * FROM credit_transaction WHERE account_id=$user[account_id] ORDER BY created_at DESC");

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

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Job</th>
                                            <th>Amount</th>
                                            <th>Current Balance</th>
                                            <th>Created At</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($result->num_rows > 0){ while($transaction = $result->fetch_assoc()){ ;?>
                                            <tr style="color: <?=($transaction['type'] == 2)? '#E71800' : '#0078e7' ?>">
                                                <td><?= getTransactionType($transaction['type']); ?></td>
                                                <td>
                                                    <?php if($transaction['type'] == 2){ ?>
                                                        <a href="job-view.php?id=<?= $transaction['job_id']; ?>">#0<?= $transaction['job_id'] ?></a>
                                                    <?php } ?>
                                                </td>
                                                <td><?= ($transaction['type'] == 2)? "-".displayPrice($transaction['amount']) : "+".displayPrice($transaction['amount']);  ?></td>
                                                <td><?= displayPrice($transaction['current_balance']) ?></td>
                                                <td><?= $transaction['created_at'] ?></td>
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