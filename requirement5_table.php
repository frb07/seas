<?php
include "conn.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
</head>

<body id="table_body">
    <div class="container">
        <table class='table'>
            <?php
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

                echo '<tr>';
                echo '<th>Class Size</th>';
                echo '<th>IUB Resource</th>';
                echo '<th>' . $semester_name . '</th>';
                echo '<th>Difference</th>';
                echo '</tr>';
                for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
                    $p = round($enrolled_student[$i] / 12, 2);
                    $q = $num_of_same_room_capacity[$i];
                    echo '<tr>';
                    echo '<td>' . $distinct_room_capacity[$i] . '</td>';
                    echo '<td>' . $num_of_same_room_capacity[$i] . '</td>';
                    echo '<td>' . round($enrolled_student[$i] / 12, 2) . '</td>';
                    $total +=  round($enrolled_student[$i] / 12, 2);
                    $res = $q - $p;
                    $total_difference += $res;
                    echo '<td>' .  $res  . '</td>';
                    echo '</tr>';
                }
                echo '<tr>';
                echo '<th>Total</th>';
                echo '<td>' . $sum_resource . '</td>';
                echo '<td>' . $total . '</td>';
                echo '<td>' . $total_difference . '</td>';
                echo '</tr>';
            }
            ?>
        </table>
    </div>
</body>

</html>