<html lang="en">
<?php include_once('../permission_customer.php') ?>
<?php include_once('layout/header.php') ?>

<?php
    if(isset($_GET['id'])){

        $job_q = $db->query("SELECT * FROM jobs WHERE id=$_GET[id] AND customer_id = $user_id AND status = 1");
        $job = $job_q->fetch_assoc();
        $job_id = $job['id'];


        if($job){

            if (!$db->query("DELETE FROM jobs_has_add_on WHERE job_id=$_GET[id]") || !$db->query("DELETE FROM jobs WHERE id=$_GET[id]")) {
                echo "Error: Deleting  data." . $db->error; exit();
            }else{

                #detele credit transaction & refund

                #get transaction data
                $t_q = $db->query("SELECT * FROM credit_transaction WHERE job_id=$job_id");
                $t = $t_q->fetch_assoc();

                $amount = $t['amount'];

                #refund user money
                $db->query("UPDATE accounts SET credit_balance = credit_balance+$amount WHERE user_id=$user_id");
                $db->query("DELETE FROM credit_transaction WHERE job_id=$job_id");

                unlink($job['file']);

                echo "<script>alert('Job Deleted!');window.location='dashboard.php'</script>";
            }

        }else{
            echo "<script>alert('Error : missing parameter!');window.location='dashboard.php'</script>";
        }

    }else{
        echo "<script>alert('Error : missing parameter!');window.location='dashboard.php'</script>";
    }
?>

</html>