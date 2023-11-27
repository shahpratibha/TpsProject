<?php include('server.php') ?>
<!DOCTYPE html>
<html>

<head>
    <title>GeoPulse</title>
    <link rel="stylesheet" type="text/css" href="style.css">
<!-- <link rel="icon" type="image/x-icon" href="images/logo1.png"> -->
</head>

<body>
    <div class="log pt-5">
        <div class="header">
            <h2 style="color:#ffffff">Login</h2>
        </div>

        <form method="post" action="login.php">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
            </div>
             <!-- <p>
                Not yet a member? <a href="register.php">Sign up</a>
            </p> -->
        </form>
    </div>
</body>

</html>
