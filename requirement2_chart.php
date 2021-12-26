<?php
include 'conn.php';
if (isset($_POST['submit'])) {
    $semester_name = $_POST['semester_name'];
    $year = $_POST['year'];
    $range = array("1-10", "11-20", "21-30", "31-35", "36-40", "41-50", "51-55", "56-65");
    $school = array("SBE", "SELS", "SETS", "SLASS", "SPPH");
    $data = [];
    $sbe = [];
    $sels = [];
    $sets = [];
    $slass = [];
    $spph = [];
    for ($i = 0; $i < sizeof($school); $i++) {
        for ($j = 0; $j < 8; $j++) {
            $val = explode("-", $range[$j]);
            $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  AND school_id = '$school[$i]' AND enrolled_student
        BETWEEN '$val[0]' AND '$val[1]'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);
            array_push($data, $num_rows);
        }
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SBE' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($sbe, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SELS' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($sels, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SETS' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($sets, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SLASS' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($slass, $num_rows);
    }
    for ($j = 0; $j < 8; $j++) {
        $val = explode("-", $range[$j]);
        $sql =  "SELECT * FROM section WHERE semester = '$semester_name' AND year = '$year'  
        AND school_id = 'SPPH' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        array_push($spph, $num_rows);
    }
    $total1 = $data[0] + $data[8] + $data[16] + $data[24] + $data[32];
    $total2 = $data[1] + $data[1 + 8] + $data[1 + 16] + $data[1 + 24] + $data[1 + 32];
    $total3 = $data[2] + $data[2 + 8] + $data[2 + 16] + $data[2 + 24] + $data[2 + 32];
    $total4 = $data[3] + $data[3 + 8] + $data[3 + 16] + $data[3 + 24] + $data[3 + 32];
    $total5 = $data[4] + $data[4 + 8] + $data[4 + 16] + $data[4 + 24] + $data[4 + 32];
    $total6 = $data[5] + $data[5 + 8] + $data[5 + 16] + $data[5 + 24] + $data[5 + 32];
    $total7 = $data[6] + $data[6 + 8] + $data[6 + 16] + $data[6 + 24] + $data[6 + 32];
    $total8 = $data[7] + $data[7 + 8] + $data[7 + 16] + $data[7 + 24] + $data[7 + 32];
    $arr_total = array($total1, $total2, $total3, $total4, $total5, $total6, $total7, $total8);
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <div id='chart' class='container-fluid' style="max-width: 1080px;"></div>
    <script>
        var array1 =
            <?php echo json_encode($sbe); ?>;
        var array2 =
            <?php echo json_encode($sels); ?>;
        var array3 =
            <?php echo json_encode($sets); ?>;
        var array4 =
            <?php echo json_encode($slass); ?>;
        var array5 =
            <?php echo json_encode($spph); ?>;
        var array6 =
            <?php echo json_encode($arr_total); ?>;
        var array7 =
            <?php echo json_encode($range); ?>;

        var options = {
            series: [{
                    name: 'SBE',
                    type: 'column',
                    data: array1
                },
                {
                    name: 'SELS',
                    type: 'column',
                    data: array2
                },
                {
                    name: 'SETS',
                    type: 'column',
                    data: array3
                },
                {
                    name: 'SLASS',
                    type: 'column',
                    data: array4
                },
                {
                    name: 'SPPH',
                    type: 'column',
                    data: array5
                }, {
                    name: 'Total',
                    type: 'line',
                    data: array6
                }
            ],
            chart: {
                height: 'auto',
                type: 'line',
            },
            stroke: {
                width: [0, 4]
            },
            xaxis: {
                categories: array7
            },
            yaxis: [{
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                },
                title: {
                    text: "Sections"
                }
            }]


        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
</body>

</html>