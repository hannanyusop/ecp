<!DOCTYPE html>
<html lang="en">

<?php include_once('../permission_manager.php') ?>
<?php include('include/header.php'); ?>

<?php
$page_title = 'SALE REPORT (By Total Sale)';

$year = 2019;
if(isset($_GET['year'])){

    #check if year is in range
    if(in_array($_GET['year'], getYear())){
        $year = $_GET['year'];
    }else{
        echo "<script>alert('Invalid year!');window.location='sale-report-total.php'</script>";
    }
}
$reject = $done = $income = array();
foreach (getStrMonth() as $key => $month){

    $query = $db->query("SELECT SUM(total_price) as total,COUNT(*) as count FROM jobs WHERE status in(3,5) AND YEAR(created_at)=$year AND MONTH(created_at)=$key");
    $result = $query->fetch_assoc();

    $total = (!is_null($result['total']))? $result['total'] : 0;


    array_push($income, $total);

}

$data_income = $income;
$income = json_encode($income); $labels = json_encode(array_values(getStrMonth()));

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

                                <form class="form-inline mb-4">

                                    <div class="form-group mx-sm-3">
                                        <select class="custom-select " name="year">
                                            <?php foreach (getYear() as $y): ?>
                                                <option value="<?= $y ?>" <?= ($year == $y)? 'selected' : '' ?>><?= $y ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Search</button>
                                    <button id="action-print" type="button" class="btn btn-success waves-effect waves-light">Print</button>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="row" id="print">
                        <div class="col-md-9">
                            <div class="card-box">
                                <div class="content">
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card-box">
                                <div class="content">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Income</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach (getStrMonth() as $key => $month){ ?>
                                            <tr>
                                                <td><?= $month ?></td>
                                                <td><?= displayPrice($data_income[$key-1]) ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
                <?php include_once('include/footer.php') ?>
                <script src="../../assets/js/chart.js"></script>
                <script type="text/javascript">
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'line',

                        data: {
                            labels: <?= $labels ?>,
                            datasets: [{
                                label: 'Income RM', borderColor: 'rgb(255,163,21)', backgroundColor: 'rgb(255,163,21)', data: <?= $income; ?>
                            }],
                        },

                        // Configuration options go here
                        options: {
                            title: {
                                display: true,
                                text: 'SALES REPORT FOR YEAR <?= $year ?>'
                            },
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        color: "rgba(0, 0, 0, 0)",
                                    }
                                }],
                                yAxes: [{
                                    gridLines: {
                                        color: "rgba(0, 0, 0, 0)",
                                    },
                                    ticks: {
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return 'RM ' + value.toFixed(2);
                                        }
                                    }
                                }]
                            }
                        }
                    });



                    $("#action-print").click(function(){


                        var canvas = document.getElementById("myChart");
                        var img    = canvas.toDataURL("image/png");
                        document.write('<img src="'+img+'"/>');

                        // var printContents = document.getElementById("print").innerHTML;
                        // var originalContents = document.body.innerHTML;
                        // document.body.innerHTML = printContents;
                        // window.print();
                        // document.body.innerHTML = originalContents;
                    });


                </script>
            </div>
        </div>
    </body>
</html>