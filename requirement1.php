<?php
include 'conn.php';
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

<body id='req_body'>
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4" style="padding-top:15px;">
            <h1 class="h3 mb-0 text-gray-800" style="text-decoration: underline;">Classroom requirement summary</h1>

        </div>

        <div class="d-sm-flex align-items-center justify-content-between mb-4" style="padding-top:15px;">
            <h3 class="h3 mb-0 text-gray-800">Generate Table</h3>

        </div>
        <div class="form_div">
            <form action="requirement1_table.php" method="POST" class='form_style'>
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
                <input type="submit" name="submit" value="Submit">
            </form>

        </div>


        <div class="d-sm-flex align-items-center justify-content-between mb-4" style="padding-top:15px;">
            <h3 class="h3 mb-0 text-gray-800" style="padding-top: 20px;">Generate Chart</h3>

        </div>
        <div class="form_div">
            <form action="requirement1_chart.php" method="POST" class='form_style'>
                <label for="semester_name">Select Semester</label><select name="semester_name">

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
                <label for="yeat">Select Year</label><select name="year">

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
                <label for="slot">Select Slot</label><select name="slot">
                    <option value="6">6 slot chart</option>
                    <option value="7">7 slot chart</option>
                </select>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>
</body>

</html>