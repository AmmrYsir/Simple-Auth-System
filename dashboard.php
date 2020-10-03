<?php

if (!isset($_SESSION['id'])) {
    header('location: index.php?session-error');
}

session_start();
echo 'You have completed the login <br> Your id:' . $_SESSION['id'] . '<br><br>';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Auth System | Dashboard</title>
</head>
<body>
    <a href="logout.php"><button>Logout</button></a>
</body>
</html>