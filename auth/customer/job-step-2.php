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

    $c = getOption('price_colour', 0.20);
    $bnw = getOption('price_black_and_white', 0.10);

    if(isset($_POST['submit'])){

        $mpdf = new \Mpdf\Mpdf();
        $target_dir = "../../assets/uploads/";

        $temp = explode(".", $_FILES["file"]["name"]);
        $rename = round(microtime(true)) . '.' . end($temp);
        $file_location = $target_dir.$rename;

        if(isset($_FILES['file']['type']) && $_FILES['file']['type'] == 'application/pdf'){


            #check if file more than 10MB
            if($_FILES['file']['size'] > 10000000){
                echo "<script>alert('Ops! Exceed file limit.(10MB)');window.location='job-step-1.php';</script>";
            }

            try{
                move_uploaded_file($_FILES["file"]["tmp_name"], $file_location);
            }catch (Exception $e){
                var_dump($e);exit();
            }

            try{

                $mpdf->SetImportUse();
                $totalPage = $mpdf->SetSourceFile($file_location);

            }catch (Exception $e){
               // echo "<script>alert('Ops! This system can\'t compress your PDF. Try another file.');window.location='job-step-1.php';</script>";
                exit();
            }


            $job = ['file' => $file_location, 'total_page' => $totalPage];
            $_SESSION['jobs'][$_SESSION['auth']['user_id']] = $job;

        }else{
            echo "<script>alert('Format File not supported!');window.location='job-step-1.php'</script>";exit();
        }


    }else{

        if(!isset($_SESSION['jobs'])){
            echo "<script>alert('Format File not supported!');window.location='job-step-1.php'</script>";exit();
        }
        $totalPage = $_SESSION['jobs'][$_SESSION['auth']['user_id']]['total_page'];
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


                            <form action="job-step-3.php" method="post">
                                <div class="content">

                                    <h4 class="header-title">STEP 2</h4>

                                    <h4 class="text-success">ACCOUNT BALANCE : <?= displayPrice($user['credit_balance']) ?></h4>
                                    Total Page : <?= $totalPage; ?><br><br>

                                    2. Select PICKUP date & time<br>

                                    <label for="pickup_date">Date</label><br>
                                    <input type="date" name="pickup_date" value="<?= (isset($_SESSION['jobs'][$_SESSION['auth']['user_id']]['date']))? $_SESSION['jobs'][$_SESSION['auth']['user_id']]['date'] : date("Y-m-d") ?>"><br>

                                    <label for="pickup_date">Time</label><br>
                                    <input type="time" name="pickup_time" value="<?= (isset($_SESSION['jobs'][$_SESSION['auth']['user_id']]['date']))? $_SESSION['jobs'][$_SESSION['auth']['user_id']]['time'] : date("H:i")?>">
                                    <small class="text-info text-sm"><br>Notes: Working Hour 10:00 AM - 10:00PM</small><br>
                                    <br>
                                    3. Select Printing Mode:<br><br>

                                    <div class="radio radio-success mb-2">
                                        <input id="mode-1" type="radio" name="colour" value="1" <?= (isset($_SESSION['jobs'][$_SESSION['auth']['user_id']]['colour']))? ($_SESSION['jobs'][$_SESSION['auth']['user_id']]['colour'] == 'colour')? "checked" : "" : ""; ?> required>
                                        <label for="mode-1">Colour (<?= displayPrice($c).'/page' ?>)</label>
                                    </div>
                                    <div class="radio radio-success mb-2">
                                        <input id="mode-2" type="radio" name="colour" value="0" <?= (isset($_SESSION['jobs'][$_SESSION['auth']['user_id']]['colour']))? ($_SESSION['jobs'][$_SESSION['auth']['user_id']]['colour'] == 'black & white')? "checked" : "" : ""; ?> required>
                                        <label for="mode-2">Black & White (<?= displayPrice($bnw).'/page' ?>)</label>
                                    </div>

                                    <br><h2 class="text-success m-2">Total Price : RM<span id="total_price">0.00</span></h2>


                                    <div class="clearfix text-right mt-3">
                                        <a href="job-step-1.php" class="btn btn-md btn-warning"><i class="mdi mdi-backspace mr-1"></i>Previous</a>
                                        <button type="submit" class="btn btn-success"> <i class="mdi mdi-send mr-1"></i> Next</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once('include/footer.php') ?>
                <script src="../../assets/libs/dropzone/dropzone.min.js"></script>
                <script src="../../assets/libs/dropify/dropify.min.js"></script>
                <script src="../../assets/js/pages/form-fileuploads.init.js"></script>
                <script type="text/javascript">
                    $('input[type=radio][name=colour]').change(function() {

                        var total_price, rate, total_page = <?= $totalPage; ?>;

                        if (this.value == '1') {
                            rate = <?= $c ?>;
                        }
                        else if (this.value == '0') {
                            rate = <?= $bnw ?>;
                        }

                        total_price = total_page*rate;
                        $('#total_price').text(parseFloat(total_price).toFixed(2));
                    });
                </script>

            </div>
        </div>
    </body>
</html>