<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_manager.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'EDIT ADD-ON';

$links = [
        'option-list.php' => 'SYSTEM SETTING'
];

if(isset($_GET['id'])){

    $add_on_q = $db->query("SELECT * FROM add_on WHERE id=$_GET[id]");
    $add_on = $add_on_q->fetch_assoc();

    if(!$add_on){
        echo "<script>alert('Add on not exist!');window.location='option-list.php'</script>";
    }

    if(isset($_POST['submit'])){


        $check_q = $db->query("SELECT * FROM add_on WHERE name='$_POST[name]' AND id <> $_GET[id]");
        $check = $check_q->fetch_assoc();

        if($check){
            echo "<script>alert('Name already exist!');window.location='option-add-on-edit.php?id=$_GET[id]'</script>";
        }

        if(!is_numeric($_POST['price'])){
            echo "<script>alert('Invalid value for price!');window.location='option-add-on-edit.php?id=$_GET[id]'</script>";
        }

        $name = strtoupper($_POST['name']);

        $is_active = (isset($_POST['is_active']))? 1 : 0;

        if (!$db->query("UPDATE add_on SET name='$name',is_active = $is_active, description = '$_POST[description]', price = $_POST[price] WHERE id=$_GET[id]")) {
            echo "Error: Updating add on data." . $db->error; exit();
        }else{
            echo "<script>alert('Add on updated!');window.location='option-list.php'</script>";
        }

    }
}else{
    echo "<script>alert('Error : missing parameter!');window.location='option-list.php'</script>";
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
                                                <input id="name" type="text" class="form-control" name="name" value="<?= $add_on['name'] ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="price" class="col-3 col-form-label">Price</label>
                                            <div class="col-9">
                                                <input id="price" type="number" class="form-control" name="price" value="<?= $add_on['price'] ?>">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="description" class="col-3 col-form-label">Description</label>
                                            <div class="col-9">
                                                <textarea name="description" class="form-control" id="description"><?= $add_on['price'] ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="is_active" class="col-3 col-form-label"></label>
                                            <div class="col-9">
                                                <div class="checkbox checkbox-success checkbox-circle mb-2">
                                                    <input id="checkbox-10" type="checkbox" name="is_active" id="is_active"  <?= ($add_on['is_active'] == 1)? 'checked' : '' ?>>
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