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
            <h1 class="h3 mb-0 text-gray-800" style="text-decoration: underline;">Available resources summary</h1>

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
            $sql = "SELECT DISTINCT room_capacity FROM `classroom` ";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_all($result);
            $distinct_room_capacity = [];
            $sum_resource = 0;
            $sum_capacity = 0;
            foreach ($data as $value) {
                array_push($distinct_room_capacity, $value[0]);
            }
            $num_of_same_room_capacity = [];
            for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
                $sql = "SELECT COUNT(room_capacity) FROM classroom WHERE room_capacity = '$distinct_room_capacity[$i]'";
                $result = mysqli_query($conn, $sql);
                $value = mysqli_fetch_array($result);
                array_push($num_of_same_room_capacity, $value[0]);
                $sum_resource += $value[0];
            }
            echo "<table class='table'>";
            echo '<tr>';
            echo '<th>Class Size</th>';
            echo '<th>IUB Resource</th>';
            echo '<th>Capacity</th>';
            echo '</tr>';
            for ($i = 0; $i < sizeof($distinct_room_capacity); $i++) {
                echo '<tr>';
                echo '<td>' . $distinct_room_capacity[$i] . '</td>';
                echo '<td>' . $num_of_same_room_capacity[$i] . '</td>';
                echo '<td>' . $distinct_room_capacity[$i] * $num_of_same_room_capacity[$i] . '</td>';
                echo '</tr>';
                $sum_capacity += $distinct_room_capacity[$i] * $num_of_same_room_capacity[$i];
            }
            echo '<tr>';
            echo '<th>Total</th>';
            echo '<td>' . $sum_resource . '</td>';
            echo '<td>' . $sum_capacity . '</td>';
            echo '</tr>';
            echo "<table class='table'>
                <tr>
                    <th>Total Capacity with 6 slot 2 days</th>
                    <td>" . $sum_capacity * 12 . "</td>
                </tr>
                <tr>
                    <th>Total Capacity with 7 slot 2 days</th>
                    <td>" . $sum_capacity * 14 . "</td>
                </tr>
                <tr>
                    <th>Considering 3.5 average course load (6 slot)</th>
                    <td>" . round(($sum_capacity * 12) / 3.5, 2)  . "</td>
                </tr>
                <tr>
                    <th>Considering 3.5 average course load (7 slot)</th>
                    <td>" . round(($sum_capacity * 14) / 3.5, 2)  . "</td>
                </tr>
            </table>";
        }

        ?>
    </div>
</body>

</html>