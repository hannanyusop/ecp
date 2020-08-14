<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">



        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
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
                <a href="my-account.php" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>My Account</span>
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