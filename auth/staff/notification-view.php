<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>
<?php

    $page_title = 'View Notification';

    $links = [
            'notification.php' => 'Notification'
    ];

    $result = $db->query("SELECT * FROM notifications WHERE user_id=$user_id AND id=$_GET[id]");

    $noti = $result->fetch_assoc();

    //set as seen if user view notification
    $db->query("UPDATE notifications SET seen=1 WHERE id=$_GET[id]");

    if(!$noti){
        echo "<script>alert('Notification not found!');window.location='notification.php'</script>";
    }

    if(isset($_GET['delete'])){
        $db->query("DELETE FROM notifications WHERE id=$_GET[id]");
        echo "<script>alert('Notification deleted!');window.location='notification.php'</script>";

    }
?>


<body>
 <div id="wrapper">

            <?php include('include/topbar.php'); ?>
            <?php include('include/aside.php'); ?>

            <div class="content-page">
                <div class="content">
                    <?php include('include/breadcrumb.php'); ?>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="card-box">
                                <div class="card-body">

                                    <h3 class="card-title">Notification</h3>

                                    <form class="form-horizontal" method="post">

                                        <div class="form-group row mb-3">
                                            <label for="title" class="col-3 col-form-label">Title</label>
                                            <div class="col-9">
                                                : <?= $noti['title']; ?>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="title" class="col-3 col-form-label">Status</label>
                                            <div class="col-9">
                                                : <?php  if($noti['seen'] == 0){
                                                    echo "<span class='badge badge-info'>Unread</span>";
                                                }else{
                                                    echo  "<span class='badge badge-dark'>Read</span>";
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="messages" class="col-3 col-form-label">Received On</label>
                                            <div class="col-9">
                                                : <?= getTimeAgo($noti['created_at']) ?>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="messages" class="col-3 col-form-label">Messages</label>
                                            <div class="col-9">
                                                    : <?= $noti['messages'] ?>
                                            </div>
                                        </div>



                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-9">
                                                <a href="notification.php" class="btn btn-success">Back</a>
                                                <a href="notification-view.php?id=<?= $_GET['id'] ?>&delete=true" onclick="return confirm('Are you sure want to delete this notification?')"  class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <?php include_once('include/footer.php') ?>

            </div>
        </div>
    </body>
</html>