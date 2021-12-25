<?php
include "conn.php";

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
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

<body id='req_body'>
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4" style="padding-top:15px;">
            <h1 class="h3 mb-0 text-gray-800" style="text-decoration: underline;">Resource usage summary</h1>

        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4" style="padding-top:15px;">
            <h3 class="h3 mb-0 text-gray-800">Generate Table</h3>

        </div>
        <div class="single_form_div">
            <form action="" method="POST" class="single_form">
                <label for="semester_name">Select semester</label>
                <select name="semester_name">

                    <?php

                    $sql = "SELECT DISTINCT semester FROM section";
                    $result = mysqli_query($conn, $sql);
                    echo "<option value= --select-->--select--</option>";

                    while ($rows =  mysqli_fetch_assoc($result)) {
                        $semester_name = $rows['semester'];
                        echo "<option value= '$semester_name'>$semester_name</option>";
                    }

                    ?>
                </select>
                <label for="year">Select Year</label>
                <select name="year">

                    <?php

                    $sql = "SELECT DISTINCT year FROM section";
                    $result = mysqli_query($conn, $sql);
                    echo "<option value= --select-->--select--</option>";

                    while ($rows =  mysqli_fetch_assoc($result)) {
                        $year = $rows['year'];
                        echo "<option value= '$year'>$year</option>";
                    }

                    ?>
                </select>
                <input type="submit" name="submit" value="Submit" style="margin-left: 200px;">
            </form>

        </div>


        <?php
        if (isset($_POST['submit'])) {
            $semester_name = $_POST['semester_name'];
            $year = $_POST['year'];
            // Student enrolled calculation
            $school = array("SBE", "SELS", "SETS", "SLASS", "SPPH");
            $sql = "SELECT enrolled_student FROM section WHERE semester = '$semester_name' AND year = '$year'";
            $result = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($result);

            $sql2 = "SELECT SUM(enrolled_student) FROM section WHERE semester = '$semester_name' AND year = '$year'";
            $result2 = mysqli_query($conn, $sql2);
            $data = mysqli_fetch_row($result2);
            // total enrolled student


            $total_enrolled = $data[0];
            $data_school_wise = [];
            $num_rows_school_wise = [];
            for ($i = 0; $i < sizeof($school); $i++) {
                $sql = "SELECT enrolled_student FROM section WHERE semester = '$semester_name' AND year = '$year'AND school_id = '$school[$i]'";
                $result = mysqli_query($conn, $sql);
                $num_rows_wise = mysqli_num_rows($result);
                array_push($num_rows_school_wise, $num_rows_wise);
                $sql2 = "SELECT SUM(enrolled_student) FROM section WHERE semester = '$semester_name' AND year = '$year' AND school_id = '$school[$i]'";
                $result2 = mysqli_query($conn, $sql2);
                $data_wise = mysqli_fetch_row($result2);
                array_push($data_school_wise, $data_wise[0]);
            }


            //Average enrolled total
            $avg_enrolled = round(intval($data[0]) / intval($num_rows), 2);
            $avg_enrolled_school_wise = [];

            // array of average enrolled school wise
            for ($i = 0; $i < sizeof($data_school_wise); $i++) {
                $avg = round(intval($data_school_wise[$i]) / intval($num_rows_school_wise[$i]), 2);
                array_push($avg_enrolled_school_wise, $avg);
            }


            //  Room Capacity calculation
            $sql3 = "SELECT SUM(classroom.room_capacity) FROM section 
        JOIN classroom ON section.classroom_id = classroom.classroom_id 
        WHERE semester = '$semester_name' AND year = '$year'";
            $result3 = mysqli_query($conn, $sql3);
            $sum_of_room_capacity = mysqli_fetch_row($result3);
            $sum_of_room_capacity = $sum_of_room_capacity[0];
            // total room capacity


            $room_capacity_school_wise = [];
            for ($i = 0; $i < sizeof($school); $i++) {
                $sql = "SELECT SUM(classroom.room_capacity) FROM section 
            JOIN classroom ON section.classroom_id = classroom.classroom_id
            WHERE semester = '$semester_name' AND year = '$year' AND school_id = '$school[$i]'";
                $result = mysqli_query($conn, $sql);
                $data_wise = mysqli_fetch_row($result);
                array_push($room_capacity_school_wise, $data_wise[0]);
            }
            // room capacity school wise


            $avg_room = round(intval($sum_of_room_capacity) / intval($num_rows), 2);
            $avg_room_school_wise = [];
            // avg room capacity

            // avg room capacity school wise
            for ($i = 0; $i < sizeof($data_school_wise); $i++) {
                $avg = round(intval($room_capacity_school_wise[$i]) / intval($num_rows_school_wise[$i]), 2);
                array_push($avg_room_school_wise, $avg);
            }

            // Difference calculation
            $differnce = [];
            for ($i = 0; $i < sizeof($school); $i++) {
                $diff = $avg_room_school_wise[$i] - $avg_enrolled_school_wise[$i];
                array_push($differnce, $diff);
            }

            // percentage calculation
            $percentage = [];
            for ($i = 0; $i < sizeof($school); $i++) {
                $percent = round($differnce[$i] / $avg_room_school_wise[$i], 2) * 100;
                array_push($percentage, $percent);
            }
            echo "<table class='table'";
            echo '<tr>
                <th>School</th>
                <th>Sum</th>
                <th>Avg Enrolled</th>
                <th>Avg Room</th>
                <th>Difference</th>
                <th>Unused % </th>

                </tr>';
            for ($i = 0; $i < sizeof($school); $i++) {
                echo '<tr>
                    <td>' . $school[$i] . '</td>
                    <td>' . $data_school_wise[$i] . '</td>
                    <td>' . $avg_enrolled_school_wise[$i] . '</td>
                    <td>' . $avg_room_school_wise[$i] . '</td>
                    <td>' . $differnce[$i] . '</td>
                    <td>' . $percentage[$i] . "%" . '</td>
                    </tr>';
            }
            echo '</table>';

            $total_differnce = $avg_room - $avg_enrolled;

            $total_unused = round($total_differnce / $avg_room, 2) * 100;

            echo "<table class='table'>
            <tr>
                <th>Total Enrolled</th>
                <td> $total_enrolled </td>
            </tr>
            <tr>
                <th>Avg Enrolled</th>
                <td> $avg_enrolled</td>
            </tr>
            <tr>
                <th>Avg Room</th>
                <td>$avg_room </td>
            </tr>
            <tr>
                <th>Difference</th>
                <td>$total_differnce</td>
            </tr>
            <tr>
                <th>Unused %</th>
                <td>$total_unused %</td>
            </tr>
        </table>";
        }

        ?>


    </div>

</body>

</html>