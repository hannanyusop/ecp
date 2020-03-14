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

    if(isset($_POST['colour'])){

        $user_id = $_SESSION['auth']['user_id'];

        $merge_date = $_POST['pickup_date']." ".$_POST['pickup_time'];


        $colour = (int)$_POST['colour'];
        $jobs = $_SESSION['jobs'][$user_id];

        #insert price to session
        $rate = ($colour == 1)? $c : $bnw;
        $price = $jobs['total_page']*$rate;

        $jobs['price'] = $price;
        $jobs['colour'] = ($colour == 1)? "colour" : "black & white";
        $jobs['mode'] = $colour;
        $jobs['mode_price'] = $rate;
        $jobs['date'] = $_POST['pickup_date'];
        $jobs['time'] = $_POST['pickup_time'];
        $jobs['datetime'] = $merge_date;

        #save to session;
        $_SESSION['jobs'][$user_id] = $jobs;

        if (new DateTime() > new DateTime($merge_date)) {
            echo "<script>alert('Ops! Please Date & Time Already passed');window.location='job-step-2.php'</script>"; exit();
        }

        #working hour 10am to 10 pm
        if($_POST['pickup_time'] < "10:00" || $_POST['pickup_time'] > "22:00"){
            echo "<script>alert('Ops! Please select time between 10 AM to 10 PM');window.location='job-step-2.php'</script>";exit();
        }

    }elseif (isset($_SESSION['jobs'][$user_id]['colour'])){
        $jobs = $_SESSION['jobs'][$user_id];
    }else{
        echo "<script>alert('Invalid action');window.location='job-step-1.php'</script>";
    }

    $result = $db->query("SELECT * FROM add_on WHERE is_active=1");



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

                    <form action="job-step-4.php" method="post" enctype="multipart/form-data">
                        <div class="content">
                            <h4 class="header-title">STEP 3</h4>


                            <h4 class="text-primary">ACCOUNT BALANCE : <?= displayPrice($user['credit_balance']) ?></h4>
                            <label>4. Pick Add-on</label>
                            <div id="pricelist" class="ml-2" >
                                <?php if($result->num_rows > 0){ while($add = $result->fetch_assoc()){ ;?>

                                    <div class="checkbox checkbox-success checkbox-circle mb-2">
                                        <input id="checkbox-<?= $add['id'] ?>" type="checkbox" name="add-on[]" value="<?= $add['id'] ?>" data-price="<?= $add['price']; ?>" <?= getCheckedAddOn($add['id']) ?>>
                                        <label for="checkbox-<?= $add['id'] ?>"><?= $add['name']."(".displayPrice($add['price']).")" ?></label>
                                    </div>

                                <?php } }else{ ?>
                                    <p>No Add On</p>
                                <?php } ?>
                            </div>

                            <br>
                            <h3 class="text-primary">Printing Mode Price : <?= displayPrice($jobs['price']); ?><br></h3>
                            <h2 class="text-primary">Total Price : <span id="subtotal"><?= displayPrice($jobs['price']); ?></h2>

                            <div class="clearfix text-right mt-3">
                                <a href="job-step-2.php" class="btn btn-md btn-warning"><i class="mdi mdi-backspace mr-1"></i>Previous</a>
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
        <script>
            function  cal() {
                $('input:checkbox').change(function () {

                    var total = <?= (float)$jobs['price'] ?>;
                    $('input:checkbox:checked').each(function(){
                        total += isNaN(parseInt($(this).val())) ? 0 : parseFloat($(this).data('price'));
                    });

                    $("#subtotal").text("RM "+parseFloat(total).toFixed(2));
                });
            }

            $('#pricelist :checkbox').click(function(){
                cal();
            });


            cal();

        </script>

    </div>
</div>
</body>
</html>