<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li class="menu-title">Navigation</li>

                <li>
                    <a href="dashboard.php">
                        <i class="fa fa-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                <li>
                    <a href="job-step-1.php">
                        <i class="fa fa-print"></i>
                        <span> Create Job </span>
                    </a>
                </li>
                <li>
                    <a href="job-list.php">
                        <i class="fa fa-list-ol"></i>
                        <span> Job List </span>
                    </a>
                </li>
                <li>
                    <a href="account.php">
                        <i class="fa fa-money-bill-wave"></i>
                        <span> Credit Transaction </span>
                    </a>
                </li>
                <li>
                    <a href="notification.php">
                        <i class="fas fa-bell"></i>
                        <span> Notification </span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>


<?php if($noty_2->num_rows > 0){ while($noty2 = $noty_2->fetch_assoc()){ ?>
<!-- sample modal content -->
<div id="noty-<?=$noty2?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="noty-<?=$noty2?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Modal Heading</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h6><?= $noty2['title'] ?></h6>
                <p><?= $noty2['messages'] ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                <form method="post">
                    <input type="hidden" name="cls_noty" value="<?= $noty2[id] ?>">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Mark As Read</button>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php } } ?>