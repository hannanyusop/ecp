<?php include_once('../permission_customer.php') ?>
<?php

    $user_id = $_SESSION['auth']['user_id'];
    $job = $_SESSION['jobs'][$user_id];

    #recheck credit balance
    if($user['credit_balance'] < $job['subtotal']){
        echo "<script>alert('Ops! not enough balance!');</script>";
        header('Location:job-step-2.php'); exit();
    }

    #inserting job
    $job_sql = "INSERT INTO jobs (customer_id, staff_id, file, total_page, printing_mode, printing_mode_price, status, total_price, pickup_date, created_at) 
                VALUES ($user_id , 0, '$job[file]',$job[total_page],$job[mode], $job[mode_price], 1, $job[subtotal],  '$job[datetime]' , CURRENT_TIMESTAMP)";

    if (!$db->query($job_sql)) {
        echo "Error: " . $job_sql . "<br>" . $db->error; exit();
    }

    $job_id = (int)$db->insert_id;

    #job transaction
    insertJobTransaction($job_id, 0, 1,1, "JOB CREATED on ".date('d F Y, h:i:s A'));

    #get data for current job
    $cq_q = $db->query("SELECT * FROM jobs as j LEFT JOIN users as u ON u.id=j.customer_id WHERE j.id=$job_id");
    $cq = $cq_q->fetch_assoc();

    #inserting job's add on
    foreach ($job['addOn'] as $add_on){
        #insert data to database;
        $add_on_sql = "INSERT INTO jobs_has_add_on(job_id, add_on_id, price) VALUES ($job_id, $add_on[id], $add_on[price])";

        if (!$db->query($add_on_sql)) {
            echo "Error: " . $add_on_sql . "<br>" . $db->error; exit();
        }
    }


    #deduct from credit account;
    $credit_balance = $user['credit_balance']-$_SESSION['jobs'][$user_id]['subtotal'];

    $update_account = "UPDATE accounts SET credit_balance=$credit_balance WHERE user_id = $user_id";

    if (!$db->query($update_account)) {
        echo "Error: " . $update_account . "<br>" . $db->error; exit();
    }

    #insert to credit transaction
    #type = 2  (payment)
    $credit_transaction = "INSERT INTO credit_transaction (account_id, job_id, staff_id, type, amount, current_balance, created_at) VALUES ($user[account_id], $job_id, 1, 2, $job[subtotal], $credit_balance, CURRENT_TIMESTAMP)";
    if (!$db->query($credit_transaction)) {
        echo "Error: " . $credit_transaction . "<br>" . $db->error; exit();
    }

    $body = "Customer Detail : $cq[fullname]<br>
            Job Cost : ".displayPrice($cq['total_price'])."<br>
            Link : <a href='http://$_SERVER[HTTP_HOST]/auth/staff/job-view.php?id=$job_id'>http://$_SERVER[HTTP_HOST]/auth/staff/job-view.php?id=$job_id</a>
            
            <br><br>
            <small>
                <i>This email was generated automatically by system. Don't reply this email
                    <br>For inquiry please call our Customer Service 06-425635654543</i>
            </small>
            <br><br>
            <small>
                <i>'To give customers the most compelling printing experience possible' <br>- Hannan Yusop (Managing Director & Founder)</i>
                <br>
            </small>";
    #all query successfully executed without error;
    try{
        sendEmail($GLOBALS['admin_email'], 'New Job Created', $body);
        echo "<script>alert('Job successfully created!');window.location='dashboard.php'</script>";
    }catch (Exception $e){
        echo "<script>alert('Job successfully created!');window.location='dashboard.php'</script>";
    }
?>