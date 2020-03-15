<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="../dashboard.php">DASHBOARD</a></li>
                        <?php if(isset($links)){ ?>
                            <?php foreach ($links as $link => $name){ ?>
                                <li class="breadcrumb-item"><a href="<?= $link ?>"><?= $name ?></a></li>
                            <?php } ?>
                        <?php } ?>
                        <li class="breadcrumb-item active"><?= (isset($page_title))? $page_title : "" ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?= (isset($page_title))? $page_title : "" ?></h4>
            </div>
        </div>
    </div>

</div>