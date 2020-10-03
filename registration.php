<?php 

include('src/config/database.class.php');

if (isset($_POST['btnRegister'])) {
    session_start();
    $db = new database();
    $Username = $db->validate($_POST['username']);
    $Password = $db->validate($_POST['password']);
    $ConfirmPassword = $db->validate($_POST['confirmpassword']);
    $Email = $db->validate($_POST['email']);

    if ($Password == $ConfirmPassword)
    {
        if (preg_match('/^[a-zA-Z0-9]+$/', $Username)) {

            if (filter_var($Email, FILTER_VALIDATE_EMAIL)) {

                if ( !$db->checkDuplicateFromUserTable("username", $Username) ) {

                    if ( !$db->checkDuplicateFromUserTable("email", $Email) ) {
                        $pdo = $db->connect();
                        $pdo = $pdo->prepare("INSERT INTO user_table(username, password, email) VALUES(?,?,?)");
                        $pdo->execute([$Username, password_hash($Password, PASSWORD_DEFAULT), $Email]);
                        $pdo = null;
                        unset($db);

                        header('location: index.php?register=success');
                    }
                    else $_SESSION['error'] = "This email already been taken!";

                }
                else $_SESSION['error'] = "This username already been taken!";

            }
            else $_SESSION['error'] = "Your email was not valid address";

        }
        else $_SESSION['error'] = "Username can only contain letter and number";
    }
    else $_SESSION['error'] = "Please double check your password!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/style/registration.css">
    <script src="https://kit.fontawesome.com/9b997b2ecb.js" crossorigin="anonymous"></script>
    <title>Simple Auth System | Register</title>
</head>
<body>
    <a href="index.php"><i class="fas fa-chevron-left"></i></a>
    <main class="login-form">
        <h1 id="title"><span>REGISTER</span> NOW</h1>
        <div class="error-msgbox" style="<?php if (isset($_SESSION['error'])) echo "display: initial;"   ?>"><?php echo $_SESSION['error'] ?></div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="input-container">
                <label for="username">Username <span id="red-dot">*</span></label>
                <input type="text" name="username" autocomplete="off" maxlength="16" required>
            </div>
            <div class="input-container">
                <label for="password">Password <span id="red-dot">*</span></label>
                <input type="password" name="password" maxlength="16" required>
            </div>
            <div class="input-container">
                <label for="confirmpassword">Confirm Password <span id="red-dot">*</span></label>
                <input type="password" name="confirmpassword" maxlength="16" required>
            </div>
            <div class="input-container">
                <label for="email">Email Address <span id="red-dot">*</span></label>
                <input type="email" name="email" maxlength="36" autocomplete="off" required>
            </div>
            <button id="btnRegister" name="btnRegister" type="submit" >REGISTER</button>
        </form>
    </main>
</body>
</html>