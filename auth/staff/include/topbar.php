<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">


        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="fe-bell noti-icon"></i>

                <?php if($noty_1->num_rows > 0){ ?>
                <span class="badge badge-info rounded-circle noti-icon-badge"><?= $noty_1->num_rows ?></span>
                <?php } ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                <div class="dropdown-item noti-title">
                    <h5 class="m-0">
                        <form method="post">
                            <span class="float-right">
                            <button type="submit" name="cls_noty_all" class="text-dark">
                                <small>Clear All</small>
                            </button>
                        </span>Notification
                        </form>
                    </h5>
                </div>

                <div class="slimscroll noti-scroll">

                    <?php if($noty_1->num_rows > 0){ while($noty1 = $noty_1->fetch_assoc()){ ;?>
                        <a class="dropdown-item notify-item" data-toggle="modal" data-target="#noty-<?=$noty1?>">
                            <div class="notify-icon bg-primary">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details"><?= $noty1['title'] ?>
                                <small class="text-muted"><?= strLimit($noty1['messages']); ?><small class="text-info"><?= getTimeAgo($noty1['created_at']) ?></small></small>
                            </p>
                        </a>

                    <?php } }else { ?>
                        <p  class="dropdown-item text-center text-primary notify-item notify-all">
                            No unread notification
                            <i class="fi-arrow-right"></i>
                        </p>
                    <?php } ?>
            </div>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="../../assets/images/users/user-1.jpg" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ml-1">
                                <?= $user['fullname']; ?> <i class="mdi mdi-chevron-down"></i>
                            </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome !</h6>
                </div>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Account</span>
                </a>

                <!-- item-->
                <a href="javascript:void(0);" class="dropdown-item notify-item">
                    <i class="fe-settings"></i>
                    <span>Settings</span>
                </a>

                <!-- item-->
                <a href="lock-screen.php?locked=true" class="dropdown-item notify-item">
                    <i class="fe-lock"></i>
                    <span>Lock Screen</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="../logout.php" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                </a>

            </div>
        </li>
    </ul>

    <div class="logo-box">
        <a href="index.html" class="logo text-center">
            <span class="logo-lg">
                <img src="../../assets/images/logo-light.png" alt="" >
            </span>
            <span class="logo-sm">
                <img src="../../assets/images/logo-sm.png" alt="" height="24">
            </span>
        </a>
    </div>

</div>


<?php
    if(isset($_POST['cls_noty'])){
        $db->query("UPDATE notifications SET seen=1 WHERE user_id=$user_id AND seen=0 AND id=$_POST[cls_noty]");
    }

    if(isset($_POST['cls_noty_all'])){
        $db->query("UPDATE notifications SET seen=1 WHERE user_id=$user_id AND seen=0");
    }
?>