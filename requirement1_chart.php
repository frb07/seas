<?php
include "conn.php";
if (isset($_POST['submit'])) {

    $semester_name = $_POST['semester_name'];
    $year = $_POST['year'];
    $slot = $_POST['slot'];
    $range_of_cs = array("1-10", "11-20", "21-30", "31-35", "36-40", "41-50", "51-55", "56-65");
    $total_sections = 0;
    $six_slot = [];
    $seven_slot = [];
    $sum_six_slot = 0;
    $sum_seven_slot = 0;
    $data1 = [];
    $dataName = [];
    for ($i = 0; $i < sizeof($range_of_cs); $i++) {
        $val = explode("-", $range_of_cs[$i]);
        $sql = "SELECT COUNT(section_no) FROM section 
    WHERE semester = '$semester_name' and year = '$year' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($result);
        array_push($six_slot, round($data[0] / 12, 2));
        array_push($seven_slot, round($data[0] / 14, 2));
        $total_sections += $data[0];
        $sum_seven_slot += round($data[0] / 14, 2);
        $sum_six_slot += round($data[0] / 12, 2);
    }
    if ($slot == 6) {
        for ($i = 0; $i < sizeof($range_of_cs); $i++) {
            array_push($data1, round($six_slot[$i] / $sum_six_slot, 2) * 100);
            array_push($dataName, $range_of_cs[$i] . "," . $six_slot[$i]);
        }
    } elseif ($slot == 7) {
        for ($i = 0; $i < sizeof($range_of_cs); $i++) {
            array_push($data1, round($seven_slot[$i] / $sum_seven_slot, 2) * 100);
            array_push($dataName, $range_of_cs[$i] . "," . $seven_slot[$i]);
        }
    }
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
    <div id='chart' class='container' style="max-width: 1080px;"></div>
    <script>
        var array1 =
            <?php echo json_encode($data1); ?>;
        var array2 =
            <?php echo json_encode($dataName); ?>;
        var options = {
            chart: {
                type: 'pie'
            },
            series: array1,
            labels: array2
        }
        var chart = new ApexCharts(document.querySelector("#chart"), options);

        chart.render();
    </script>
</body>

</html>