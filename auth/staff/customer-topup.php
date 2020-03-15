<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'CUSTOMER TOPUP';

    $links = [
            'example.link' => 'JOB VIEW',
            '' => '#'.$_GET['id']
    ];

    if(isset($_GET['id'])){

        $customer_q = $db->query("SELECT *,users.id as user_id FROM users LEFT JOIN accounts ON users.id=accounts.user_id WHERE users.id=$_GET[id] AND role_id=3");
        $customer = $customer_q->fetch_assoc();


        #if customer data not exist
        if(!$customer_q){
            echo "<script>alert('Customer data not found!');window.location='customer-list.php'</script>";
        }

        if(isset($_POST['submit'])){

            if($_POST['amount'] <= 0){
                echo "<script>alert('Please insert valid amount!');window.location='customer-topup.php?id=".$_GET['id']."'</script>";
                exit();
            }

            $amount = (float)$_POST['amount'];

            $credit_balance = $customer['credit_balance']+$amount;
            $credit_total = $customer['credit_total']+$amount;

            if (!$db->query("UPDATE accounts SET credit_balance = $credit_balance, credit_total = $credit_total WHERE id=$customer[id]")) {
                echo "Error: Inserting updating credit balance." . $db->error; exit();
            }else{

                $credit_transaction = "INSERT INTO credit_transaction (account_id, job_id, staff_id, type, amount, current_balance, created_at) VALUES ($customer[id], 0, $user[id], 1, $amount, $credit_balance, CURRENT_TIMESTAMP)";
                if (!$db->query($credit_transaction)) {
                    echo "Error: " . $credit_transaction . "<br>" . $db->error; exit();
                }


                sleep(2);

                echo "<script>alert('Customer account charged!');</script>";
            }

        }
    }else{
        echo "<script>alert('Invalid action!');window.location='customer-list.php';window.location='customer-list.php'</script>";
    }
//    var_dump($result);exit();
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


                    <form method="post">
                        <div class="form-group">
                            <label for="date">Email</label>
                            <input type="text" class="form-control" name="email" value="<?= $customer['email'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="time">Full Name</label>
                            <input class="form-control" type="text" name="full_name" value="<?= $customer['fullname'] ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="time">Account Balance</label>
                            <input class="form-control" id="account_balance" type="text" value="<?= displayPrice($customer['credit_balance']) ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="time">Amount</label>
                            <input class="form-control form-control-lg" id="amount" name="amount" type="number" value="" required>
                        </div>

                        <div class="">
                            <small class="text-sm font-weight-bold text-success">Instant value : </small>
                            <a class="btn btn-sm btn-success text-white instant" data-value="5.00">RM5.00</a>
                            <a class="btn btn-sm btn-warning text-white instant" data-value="10.00">RM10.00</a>
                            <a class="btn btn-sm btn-danger text-white instant" data-value="15.00">R15.00</a>
                            <a class="btn btn-sm btn-info text-white instant" data-value="20.00">RM20.00</a>
                        </div>


                        <div class="clearfix mt-4">
                            <button type="submit" name="submit" class="btn btn-md btn-success">Recharge</button>
                            <a href="customer-list.php" class="btn btn-md btn-warning">Back</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <?php include_once('include/footer.php') ?>
        <script type="text/javascript">

            $(".instant").click(function () {
                $("#amount").val($(this).data('value'));
            });


        </script>
    </div>
</div>
</body>
</html>