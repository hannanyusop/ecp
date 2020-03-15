<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_manager.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'ADD ADD-ON';

$links = [
        'option-list.php' => 'SYSTEM SETTING'
];

if(isset($_POST['submit'])){


    $check_q = $db->query("SELECT * FROM add_on WHERE name='$_POST[name]'");
    $check = $check_q->fetch_assoc();

    if($check){
        echo "<script>alert('Name already exist!');window.location='option-add-on-add.php'</script>";
    }

    if(!is_numeric($_POST['price'])){
        echo "<script>alert('Invalid value for price!');window.location='option-add-on-add.php'</script>";
    }

    $name = strtoupper($_POST['name'] );

    $is_active = (isset($_POST['is_active']))? 1 : 0;

    if (!$db->query("INSERT INTO add_on(name,price,description,is_active) VALUES ('$name', '$_POST[price]', '$_POST[description]', $is_active)")) {
        echo "Error: Inserting add-on data." . $db->error; exit();
    }else{
        echo "<script>alert('Add-on inserted!');window.location='option-list.php'</script>";
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
                        <div class="col-md-6 offset-md-3">
                            <div class="card-box">
                                <div class="card-body">
                                    <form class="form-horizontal" method="post">
                                        <div class="form-group row mb-3">
                                            <label for="name" class="col-3 col-form-label">Name</label>
                                            <div class="col-9">
                                                <input id="name" type="text" class="form-control" name="name">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="price" class="col-3 col-form-label">Price</label>
                                            <div class="col-9">
                                                <input id="price" type="number" class="form-control" name="price">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="description" class="col-3 col-form-label">Description</label>
                                            <div class="col-9">
                                                <textarea name="description" class="form-control" id="description"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="is_active" class="col-3 col-form-label"></label>
                                            <div class="col-9">
                                                <div class="checkbox checkbox-success checkbox-circle mb-2">
                                                    <input id="checkbox-10" type="checkbox" name="is_active" id="is_active">
                                                    <label for="checkbox-10">
                                                        Success
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0 justify-content-end row">
                                            <div class="col-9">
                                                <button type="submit" name="submit" class="btn btn-info waves-effect waves-light">Update Setting</button>
                                                <a href="option-list.php" class="btn btn-warning">Back</a>
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