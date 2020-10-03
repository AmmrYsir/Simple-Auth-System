<?php

include('src/config/database.class.php');


if (isset($_POST['btnLogin'])) {
    session_start();
    $db = new database();

    if (!empty($_POST['username'])) {

        $username = $db->validate($_POST['username']);
        if (!empty($_POST['password'])) {
            
            $password = $db->validate($_POST['password']);

            $pdo = $db->connect();
            $pdo = $pdo->prepare("SELECT id,password FROM user_table WHERE username=?");
            
            if ($pdo->execute([$username])) {
                while ($row = $pdo->fetch()) {
                    if (password_verify($password, $row["password"])) {
                        $_SESSION['error'] = null;
                        $_SESSION['id'] = $row["id"];
                        header("location: dashboard.php?login=success");
                    }
                    else $_SESSION['error'] = "Your Username or Password is wrong!";
                }
            }
            else $_SESSION['error'] = "Your Username or Password is wrong!";

        }
        else $_SESSION['error'] = "Please enter your password";
    }
    else $_SESSION['error'] = "Please enter your username";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style/index.css">
    <title>Simple Auth System | Login</title>
</head>
<body>
    <main class="login-form">
        <h1 id="title"><span>LOGIN</span> NOW</h1>
        <div class="error-msgbox" style="<?php if (isset($_SESSION['error'])) echo "display: initial;" ?>"> <?php echo $_SESSION['error']; ?> </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="input-container">
                <label for="username">Username <span id="red-dot">*</span></label>
                <input type="text" name="username" autocomplete="off" maxlength="16" required>
            </div>
            <div class="input-container">
                <label for="password">Password <span id="red-dot">*</span></label>
                <input type="password" name="password" maxlength="16" required>
            </div>
            <a id="toRegister" href="registration.php">I haven't register yet</a>
            <button id="btnLogin" type="submit" name="btnLogin" >LOGIN</button>
        </form>
    </main>
</body>
</html>