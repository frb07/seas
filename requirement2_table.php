<?php
include "conn.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                $semester_name = $_POST['semester_name'];
                $year = $_POST['year'];
                $range = array("1-10", "11-20", "21-30", "31-35", "36-40", "41-50", "51-55", "56-65");
                $school = array("SBE", "SELS", "SETS", "SLASS", "SPPH");
                $data = [];
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
                echo '<th>
                Class Size
                </th>
                <th>
                    SBE
                </th>
                <th>
                    SELS
                </th>
                <th>
                    SETS
                </th>
                <th>
                    SLASS
                </th>
                <th>
                    SPPH
                </th>
                <th>
                    Total
                </th>';
                for ($i = 0; $i < 8; $i++) {
                    echo '<tr>';
                    echo '<td>';
                    echo $range[$i];
                    echo '</td>';
                    echo '<td>';
                    echo $data[$i];
                    echo '</td>';
                    echo '<td>';
                    echo $data[$i + 8];
                    echo '</td>';
                    echo '<td>';
                    echo $data[$i + 16];
                    echo '</td>';
                    echo '<td>';
                    echo $data[$i + 24];
                    echo '</td>';
                    echo '<td>';
                    echo $data[$i + 32];
                    echo '</td>';
                    echo '<td>';
                    $total = $data[$i] + $data[$i + 8] + $data[$i + 16] + $data[$i + 24] + $data[$i + 32];
                    echo $total;
                    echo '</td>';
                    echo '</tr>';
                }
            }


            ?>
        </table>
    </div>
</body>

</html>