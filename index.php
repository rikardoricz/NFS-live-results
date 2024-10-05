<?php
$servername = 'localhost';
$username = 'root';
$password = 'password'; /*Bazybazy116*/
$database = 'nfs_wyscigi';


$loginErr = $passwordErr = $fillAllFieldsErr = $msgLoginExists = $msgPwdCorrect = '';

$conn = @new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection error' . $conn->connect_error);
} else {
    $login = !empty($_POST['login']) ? htmlspecialchars(stripslashes(trim($_POST['login']))) : false;
    $password = !empty($_POST['password']) ? htmlspecialchars(stripslashes(trim($_POST['password']))) : false;

    if ($login && $password) {
        $userQuery = "SELECT `login` FROM `uzytkownicy` WHERE login = ?";
        $stmtLogin = $conn->prepare($userQuery);
        $stmtLogin->bind_param('s', $login);
        $stmtLogin->execute();
        $userResult = $stmtLogin->get_result();
        $userFound = $userResult->fetch_assoc();

        if ($userFound) {
            $msgLoginExists = "Login $login istnieje";
            $encryptedPwd = sha1($password);
            $pwdQuery = "SELECT `haslo` FROM `uzytkownicy` WHERE haslo = ? && login = ?";
            $stmtPwd = $conn->prepare($pwdQuery);
            $stmtPwd->bind_param('ss', $encryptedPwd, $login);
            $stmtPwd->execute();
            $pwdResult = $stmtPwd->get_result();
            $pwdFound = $pwdResult->fetch_assoc();

            if ($pwdFound) {
                $msgPwdCorrect = "Haslo poprawne, zalogowano";
                switch ($login) {
                    case 'admin':
                        header('Location: add.php');
                        break;
                    case 'user':
                        header('Location: results.php');
                        break;
                    default:
                        echo "nic";
                }
            } else {
                $passwordErr = "Hasło nieprawidłowe!";
            }
            $stmtPwd->close();
        } else {
            $loginErr = "Login nie istnieje";
        }
        $stmtLogin->close();
    } else {
        $fillAllFieldsErr = "Uzupełnij wszystkie pola formularza!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona logowania</title>
    <link rel="icon" href="img/icon.ico" sizes="16x16" type="image/x-icon">
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Hurricane&family=Roboto:ital@0;1&display=swap");

        body {
            background-color: #2e3440;
            color: #d8dee9;
            font-family: 'Roboto', sans-serif;
            margin: 20px;

        }

        .error {
            color: #bf616a;
            font-size: 16px;
        }

        .correct,
        h5 {
            color: #a3be8c;
            font-size: 16px;
        }

        .info {
            color: #88c0d0;
        }

        .msg {
            margin-top: 5px;
        }

        .msg span {
            display: block;
        }

        #loginBox>* {
            margin: 20px;
        }
        form>* {
            margin-bottom: 5px;
        }

        #loginBox {
            margin: auto;
            margin-top: 80px;
            width: 300px;
            border: rgba(220, 253, 149, 0.9) solid 2px;
            border-radius: 10px;
        }

        h1 {
            padding-top: 80px;
            margin-top: 80px;
            font-style: italic;
            text-align: center;
            margin: auto;
            color: #dcfd95;
        }

        #submitButton {
            color: #ffffef;
            font-style: italic;
            font-size: 15px;

            background-color: #2e3440;
            border: rgba(201, 201, 201, 0.9) solid 2px;
            border-radius: 10px;
            text-decoration: none;
            padding: 5px 10px;
            margin: 4px 2px;
            cursor: pointer;
        }

        #submitButton:hover {
            color: #dcfd95;
            border: #8a8a8a solid 2px;
            animation: blink 1s;
            animation-iteration-count: infinite;
        }

        @keyframes blink {
            50% {
                border-color: #dcfd95;
            }
        }
    </style>
</head>

<body>
    <h1>Logowanie</h1>
    <div id="loginBox">
        <form action="index.php" method="post">
            <label for="login">Login:</label> </br>
            <input type="text" name="login"></br>
            <label for="password">Hasło:</label> </br>
            <input type="password" name="password"> </br>
            <input id="submitButton" type="submit" name="log_in" value="Zaloguj się">
        </form>

        <div class="msg">
            <span class="error"><?php echo $loginErr; ?></span>
            <span class="error"><?php echo $passwordErr; ?></span>
            <span class="error"><?php echo $fillAllFieldsErr; ?></span>
            <span class="correct"><?php echo $msgLoginExists; ?></span>
            <span class="correct"><?php echo $msgPwdCorrect; ?></span>
        </div>
    </div>

</body>

</html>