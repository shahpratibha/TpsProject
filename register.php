<?php include('server.php') ?>
<!DOCTYPE html>
<html>

<head>
    <title>TCPL</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="regilog">
        <div class="header">
            <img class="imglogo" src="images/logo1.png" alt="" style="height:70px; width:70px;">
            <h2>Register</h2>
        </div>

        <form method="post" action="register.php">
            <?php include('errors.php'); ?>
            <div class="input-group">
                <label>Name</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password_1">
            </div>
            <div class="input-group">
                <label>Confirm password</label>
                <input type="password" name="password_2">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_user">Register</button>
            </div>
            <p>
                Already a member? <a href="login.php">Sign in</a>
            </p>
        </form>
    </div>
</body>

</html>