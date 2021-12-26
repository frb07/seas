<?php
include "conn.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</head>

<body id="table_body">
    <div class="container">
        <table class='table'>
            <?php

            if (isset($_POST['submit'])) {
                echo '
        <tr>
            <th>Class Size</th>
            <th>Sections</th>
            <th>6 Slot</th>
            <th>7 Slot</th>
        </tr>';
                $semester_name = $_POST['semester_name'];
                $year = $_POST['year'];
                $range_of_cs = array("1-10", "11-20", "21-30", "31-35", "36-40", "41-50", "51-55", "56-65");
                $total_sections = 0;
                $sum_six_slot = 0;
                $sum_seven_slot = 0;
                for ($i = 0; $i < sizeof($range_of_cs); $i++) {
                    $val = explode("-", $range_of_cs[$i]);
                    $sql = "SELECT COUNT(section_no) FROM section 
            WHERE semester = '$semester_name' and year = '$year' AND enrolled_student BETWEEN '$val[0]' AND '$val[1]'";
                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_array($result);
                    echo '<tr>';
                    echo '
                <td>' . $range_of_cs[$i] . '</td>
                <td>' . $data[0] . '</td>';
                    $total_sections += $data[0];
                    echo '<td>' . round($data[0] / 12, 2) . '</td>';
                    $sum_six_slot += round($data[0] / 12, 2);
                    echo '<td>' . round($data[0] / 14, 2) . ' </td>';
                    $sum_seven_slot += round($data[0] / 14, 2);
                    echo '</tr>';
                }
                echo '<tr>
                <td>Total</td>
                <td>' . $total_sections . '</td>
                <td>' . $sum_six_slot . '</td>
                <td>' . $sum_seven_slot . '</td>
            </tr>';
            }
            ?>
        </table>
    </div>

</body>

</html>