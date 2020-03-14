<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'PAGE TITLE';

$links = [
        'example.link' => 'Example Title'
];

?>


<body>
 <div id="wrapper">

            <?php include('include/topbar.php'); ?>
            <?php include('include/aside.php'); ?>

            <div class="content-page">
                <div class="content">
                    <?php include('include/breadcrumb.php'); ?>
                </div>
                <?php include_once('include/footer.php') ?>

            </div>
        </div>
    </body>
</html>