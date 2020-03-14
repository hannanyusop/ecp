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

                    <form method="post" action="job-step-2.php" enctype="multipart/form-data">
                        <h4 class="header-title">STEP 1</h4>

                        <div class="col-md-12">
                            <div class="mt-3">
                                <input name="file" type="file" class="dropify" data-max-file-size="10M" />
                                <p class="text-muted text-center mt-2 mb-0">Max size : 10MB | File Type : PDF Only </p>
                            </div>
                        </div>

                        <div class="clearfix text-right mt-3">
                            <button type="submit" name="submit" class="btn btn-danger"> <i class="mdi mdi-send mr-1"></i> Submit</button>
                        </div>
                    </form>
                </div>
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