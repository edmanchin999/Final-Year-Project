<?php
require_once 'database.php';

if (isset($_SESSION['loggedin'])) {
    header("LOCATION: main.php");
}

if (isset($_POST['username'], $_POST['password'])) {
    $UserID = htmlspecialchars($_POST['username']);
    $Pass = $_POST['password'];

    if (empty($UserID) || empty($Pass)) {
        $_SESSION['error'] = 'Please fill in the blanks.';
    } else {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_admin WHERE (fld_admin_username =:id ) LIMIT 1");
        $stmt->bindParam(':id', $UserID);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($user['fld_admin_username'])) {
            if ($user['fld_admin_password'] == $Pass) {
                unset($user['fld_admin_password']);
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $user;
                header("LOCATION: main.php");
                exit();
            } else {
                //$_SESSION['error'] = 'Password invalid';
                echo '<script type = "text/JavaScript">';
                echo 'alert("Password Invalid")';
                echo '</script>';
            }
        } else {
            //$_SESSION['error'] = 'Email Invalid.';
            echo '<script type = "text/JavaScript">';
            echo 'alert("Password Invalid")';
            echo '</script>';
        }
    }

    header("LOCATION: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>SISTEM PENGURUSAN PENYEMBUR PEMBERSIH BADAN AUTOMATIK
        BERASASKAN IOT</title>
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Raleway, sans-serif;
        }

        body {
            background: linear-gradient(90deg, #2E7D32, #69ff71);
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .screen {
            background: linear-gradient(90deg, #2E7D32, #90e994);
            position: relative;
            height: 600px;
            width: 360px;
            box-shadow: 0px 0px 24px #000000;
        }

        .screen__content {
            z-index: 1;
            position: relative;
            height: 100%;
        }

        .screen__background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            -webkit-clip-path: inset(0 0 0 0);
            clip-path: inset(0 0 0 0);
        }

        .screen__background__shape {
            transform: rotate(45deg);
            position: absolute;
        }

        .screen__background__shape1 {
            height: 520px;
            width: 520px;
            background: #FFF;
            top: -50px;
            right: 120px;
            border-radius: 0 72px 0 0;
        }

        .screen__background__shape2 {
            height: 220px;
            width: 220px;
            background: #2E7D32;
            top: -172px;
            right: 0;
            border-radius: 32px;
        }

        .screen__background__shape3 {
            height: 540px;
            width: 190px;
            background: linear-gradient(270deg, #2E7D32, #43A047);
            top: -24px;
            right: 0;
            border-radius: 32px;
        }

        .screen__background__shape4 {
            height: 400px;
            width: 200px;
            background: #43A047;
            top: 420px;
            right: 50px;
            border-radius: 60px;
        }

        .login {
            width: 320px;
            padding: 30px;
            padding-top: 156px;
        }

        .login__field {
            padding: 20px 0px;
            position: relative;
        }

        .login__icon {
            position: absolute;
            top: 30px;
            color: #43A047;
        }

        .login__input {
            border: none;
            border-bottom: 2px solid #D1D1D4;
            background: none;
            padding: 10px;
            padding-left: 24px;
            font-weight: 700;
            width: 75%;
            transition: .2s;
        }

        .login__input:active,
        .login__input:focus,
        .login__input:hover {
            outline: none;
            border-bottom-color: #2E7D32;
        }

        .login__submit {
            background: #fff;
            font-size: 14px;
            margin-top: 30px;
            padding: 16px 20px;
            border-radius: 26px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: flex;
            align-items: center;
            width: 100%;
            color: #43A047;
            box-shadow: 0px 2px 2px #2E7D32;
            cursor: pointer;
            transition: .2s;
        }

        .login__submit:active,
        .login__submit:focus,
        .login__submit:hover {
            border-color: #97ee6e;
            outline: none;
        }

        .button__icon {
            font-size: 24px;
            margin-left: auto;
            color: #43A047;
        }

        .social-login {
            position: absolute;
            height: 140px;
            width: 160px;
            text-align: center;
            bottom: 0px;
            right: 0px;
            color: #fff;
        }

        a {
            color: rgb(255, 255, 255);
            text-decoration: none;
        }


        h6 {
            color: white;
            position: relative;
            left: 20px;
        }
    </style>
    <script type="text/javascript">
        function printKosongMessage() {
            alert("Sila masuk username dan kata laluan");
        }

        function printTakSah() {
            alert("Username / Kata Laluan Tidak Sah");
        }
    </script>


</head>

<body>

    <h6 style="color:white">SISTEM PENGURUSAN PENYEMBUR PEMBERSIH BADAN AUTOMATIK
    </h6>
    <h6 style="color:white">BERASASKAN IOT</h6>
    <div class="container">

        <div class="screen">
            <div class="screen__content">
                <form class="login" method="POST" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input id="user" type="text" class="login__input" name="username" placeholder="Username" required>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input id="pass" type="password" class="login__input" data-type="password" placeholder="Password" name="password" required>
                    </div>
                    <button class="button login__submit">
                        <span type="submit" class="button__text" value="Sign In">Log Masuk</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>

                </form>
                <div class="social-login">
                    <a href="signup.php">Daftar Akaun</a>
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>

<?php
unset($_SESSION["error"]);
?>