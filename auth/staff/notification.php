<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_staff.php') ?>
<?php include('include/header.php'); ?>

<?php

    $page_title = 'NOTIFICATION';

    $result = $db->query("SELECT * FROM notifications WHERE user_id=$user_id ORDER BY seen ASC");

    if(isset($_GET['delete'])){
        $result = $db->query("SELECT * FROM notifications WHERE user_id=$user_id AND id=$_GET[delete]");

        $noti = $result->fetch_assoc();

        if(!$noti){
            echo "<script>alert('Notification not found!');window.location='notification.php'</script>";
        }else{
            $db->query("DELETE FROM notifications WHERE id=$_GET[delete]");
            echo "<script>alert('Notification deleted!');window.location='notification.php'</script>";
        }
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

                        <div class="col-md-12">
                            <div class="card-box">

                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th width="40%">Message</th>
                                            <th>Seen</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if($result->num_rows > 0){ while($notification = $result->fetch_assoc()){ ;?>
                                            <tr style="color: <?=($notification['seen'] == 0)? '#E71800' : '#0078e7' ?>">
                                                <td><?= $notification['title']; ?></td>
                                                <td><?= $notification['messages']; ?></td>
                                                <td>
                                                    <?php  if($notification['seen'] == 0){
                                                        echo "<span class='badge badge-info'>Unread</span>";
                                                    }else{
                                                       echo  "<span class='badge badge-dark'>Read</span>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= getTimeAgo($notification['created_at']) ?></td>
                                                <td>
                                                    <a class="btn btn-info btn-small" href="notification-view.php?id=<?= $notification['id'] ?>">View</a>
                                                    <a class="btn btn-danger btn-small " onclick="return confirm('Are you sure want to delete this notification?')" href="notification.php?delete=<?= $notification['id'] ?>">Delete</a>

                                                </td>
                                            </tr>
                                        <?php } }else{ ?>
                                            <tr>
                                                <td class="text-center" colspan="4">No data</td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end .table-responsive-->
                            </div> <!-- end card-box -->
                        </div>

                    </div>
                </div>
                <?php include_once('include/footer.php') ?>

            </div>
        </div>
    </body>
</html>