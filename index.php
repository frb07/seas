<?php
include 'conn.php';
session_start();
$error = NULL;
if (isset($_POST['login'])) {
    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $password =  mysqli_real_escape_string($conn, $_POST['password']);
    $_SESSION['id'] = $id;

    $sql = "SELECT * FROM user WHERE user_id = $id and password = $password";
    $result = mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {
        $num_row = mysqli_num_rows($result);
        $data = mysqli_fetch_array($result);

        if ($data['user_type'] == "faculty") {
            header('Location: faculty_dash.php');
        } elseif ($data['user_type'] == "higher_authority") {
            header('Location: higher_authority_dash.php');
        } elseif ($data['user_type'] == "system_user") {
            header('Location: system_user_dash.php');
        }
    } else {
        $error = "Wrong ID or Password";
    }
}
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
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.8.95/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title>Login Page</title>
</head>

<body id="body">
    <section>
        <div id="main" class="container">
            <div id="first_part" class="container">
                <h1>Independent University, Bangladesh</h1>
                <div class="container-fluid">
                    <img src="images/iub1.png" id="logo" class="img-fluid" alt="iub-logo">
                </div>
            </div>
            <div id="second_part" class="container">
                <h1>SEAS</h1>
                <form action="" method="post" class="myForm">
                    <input type="text" name="user_id" placeholder="Enter User ID">
                    <input type="password" name="password" placeholder="Enter Password">
                    <input name="login" id="login-btn" class="btn btn-block login-btn mb-4" type="submit" value="Login">

                </form>
                <div>
                    <p><?php echo $error ?></p>
                </div>
            </div>
        </div>
    </section>
</body>

</html>