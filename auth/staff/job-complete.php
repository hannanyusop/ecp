<?php
    include_once('../permission_staff.php');

    if(isset($_GET['id'])){

        $result = $db->query("SELECT * FROM jobs WHERE id=$_GET[id] AND status=2 AND staff_id=$user_id");

        $job = $result->fetch_assoc();

        if(!$job){
            echo "<script>alert('Job not found!');window.location='dashboard.php'</script>";
        }

        $customer_q = $db->query("SELECT * FROM users WHERE id=$job[customer_id]");
        $customer = $customer_q->fetch_assoc();

        #add on list
        $job_result = $db->query("SELECT * FROM jobs_has_add_on as a LEFT JOIN add_on as b ON a.add_on_id=b.id WHERE job_id=$job[id]");

        #update job status
        $code = generateConfirmationCode();
        $update_job = "UPDATE jobs SET status=3,pickup_code='$code',staff_id=$user_id WHERE id=$job[id]";

        if (!$db->query($update_job)) {
            echo "Error: " . $update_job . "<br>" . $db->error; exit();
        }

        $body = "Your job #$job[id] completed. Come and pickup your document.<br>
                            <p>Pickup Security Code: <b>$code</b> <small>(Don't show this code to other person)</small></p><br>
                            Working Hours : 10:00 AM - 10:00PM<br>
                            Working Days : Everyday (Except Public Holiday)                             
                            <br><br>
                            <small>
                                <i>This email was generate automatically by system. Don't reply this email
                                    <br>For inquiry please call our Customer Service 06-425635654543</i>
                            </small>
                            <br><br>";

        insertJobTransaction($job['id'], $user_id, 4, "JOB COMPLETE");
        insertNotification($customer['id'], 'Job Have been completed.', "Your job #$job[id] have been completed and ready to pick.");

        sendEmail($customer['email'], "JOB #$job[id] Ready To Pickup", $body);
        echo "<script>alert('Job marked as completed!');window.location='job-view.php?id=".$job['id']."'</script>";

    }else{
        echo "<script>alert('Invalid action!');window.location='dashboard.php'</script>";
    }
?>