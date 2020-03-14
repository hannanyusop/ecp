<?php

require_once '../env.php';

    if(isset($_POST['register'])){

        #check if email is unique
        if(isset($_POST['email'])){

            #check if mail is valid
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('Ops! invalid password!');window.location='register.php '</script>";
                exit();
            }

            $user_q = $db->query("SELECT * FROM users WHERE email='$_POST[email]'");
            $job = $user_q->fetch_assoc();


            if($job){
                echo "<script>alert('Email already exist!');window.location='register.php'</script>";
            }
        }

        $fullname = strtoupper($_POST['full_name']);

        $password = randomPassword();
        $hash_pass = password_hash($password, PASSWORD_BCRYPT);
        if (!$db->query("INSERT INTO users (role_id, email, password, fullname, is_active, is_confirm, created_at) VALUES (3, '$_POST[email]', '$hash_pass', '$fullname', 1, 0, CURRENT_TIMESTAMP)")) {
            echo "Error: Inserting user data." . $db->error; exit();
        }else{

            #add customer account

            $last_user_id = (int)$db->insert_id;
            if(!$db->query("INSERT INTO accounts (user_id, credit_balance, credit_total, address) VALUES ($last_user_id, 0.00, 0.00, '')")){

                $db->query("DELETE FROM users WHERE id=$last_user_id");
                #delete prev customer
                echo "Error: Inserting user account." . $db->error; exit();
            }


            $body = "Hello $fullname,<br><br>
            <p>This email has been registered to e-centerprinting.my.<br>Temporary Password: $password<br><br>Please change this password to keep your account safe.
             If you not request this, please call Customer Service 06-425635654543 or drop an email at help@ecp.my</p>
            
            <br><br>
            <small>
                <i>This email was generated automatically by system. Don't reply this email
                    <br>For inquiry please call our Customer Service 06-425635654543</i>
            </small>
            <br><br>
            <small>
                <i>'To give customers the most compelling printing experience possible' <br>-(Managing Director & Founder)</i>
                <br>
            </small>";


            sendEmail($_POST['email'], "Activate ECP Account", $body);
            echo "<script>alert('Your account successfully registered! We\'ve send temporary password at your email');window.location='login.php '</script>";
        }

    }

?>