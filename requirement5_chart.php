<?php
include "conn.php";

if (isset($_POST['submit'])) {
    $semester_name = $_POST['semester_name'];
    $year = $_POST['year'];
    $sql = "SELECT DISTINCT room_capacity FROM `classroom` ";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_all($result);
    $distinct_room_capacity = [];
    $sum_resource = 0;
    foreach ($data as $value) {
        array_push($distinct_room_capacity, $value[0]);
    }
    sort($distinct_room_capacity);
    $num_of_same_room_capacity = [];
    for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
        $sql = "SELECT COUNT(room_capacity) FROM classroom WHERE room_capacity = '$distinct_room_capacity[$i]'";
        $result = mysqli_query($conn, $sql);
        $value = mysqli_fetch_array($result);
        array_push($num_of_same_room_capacity, $value[0]);
        $sum_resource += $value[0];
    }

    $enrolled_student = [];
    $total = 0;
    $total_difference = 0;
    for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
        if ($i == 0) {
            $sql = "SELECT COUNT(enrolled_student) FROM section WHERE semester = '$semester_name' 
            AND year = '$year' AND enrolled_student <= '$distinct_room_capacity[$i]'";
        } else {
            $val = $distinct_room_capacity[$i - 1];
            $sql = "SELECT COUNT(enrolled_student) FROM section WHERE semester = '$semester_name' 
            AND year = '$year' AND enrolled_student BETWEEN '$val'
            AND '$distinct_room_capacity[$i]'";
        }
        $result = mysqli_query($conn, $sql);
        $value = mysqli_fetch_array($result);
        array_push($enrolled_student, $value[0]);
    }
}


$data1y = array(
    round($enrolled_student[0] / 12, 2),  round($enrolled_student[1] / 12, 2),  round($enrolled_student[2] / 12, 2),
    round($enrolled_student[3] / 12, 2),  round($enrolled_student[4] / 12, 2),  round($enrolled_student[5] / 12, 2),
    round($enrolled_student[6] / 12, 2)
);
$data2y = array(
    $num_of_same_room_capacity[0], $num_of_same_room_capacity[1], $num_of_same_room_capacity[2],
    $num_of_same_room_capacity[3], $num_of_same_room_capacity[4], $num_of_same_room_capacity[5], $num_of_same_room_capacity[6]
);

$datax = [];
for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
    array_push($datax, $distinct_room_capacity[$i]);
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
            <?php echo json_encode($data1y); ?>;
        var array2 =
            <?php echo json_encode($data2y); ?>;
        var array3 =
            <?php echo json_encode($datax); ?>;


        var options = {
            series: [{
                    name: 'Resource available',
                    type: 'column',
                    data: array1
                },
                {
                    name: "Semester's Requirement",
                    type: 'column',
                    data: array2
                }
            ],
            chart: {
                height: 'auto',
                type: 'bar',
            },
            stroke: {
                width: [0, 4]
            },
            xaxis: {
                categories: array3,
                title: {
                    text: "Distinct Classroom"
                }
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