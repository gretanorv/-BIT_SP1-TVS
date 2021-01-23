<?php

print("admin page");

//login logic
if (isset($_POST['login']) and !empty($_POST['username']) and !empty($_POST['password'])) {
    if ($_POST['username'] === 'admin' and $_POST['password'] === 'admin') {
        $_SESSION['logged_in'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $_POST['username'];
        $msg = 'Correct';
        $login = true;
    } else {
        $msg = 'Wrong user name or password';
    }
}


if (!$_SESSION['logged_in']) {

?>

    <h2 class="title title--login">Login</h2>
    <form class="login-form" method="post">
        <div class="login-form__field">
            <label for="username" class="login-form__field-label">Username</label>
            <input type="text" name="username" id="username" class="login-form__field-input" placeholder="name: admin" required autofocus>
        </div>
        <div class="login-form__field">
            <label for="password" class="login-form__field-label">Password</label>
            <input type="password" name="password" id="password" class="login-form__field-input" placeholder="pass: admin" required>
        </div>
        <input type="submit" value="Login" name="login" class="login-form__btn">
    </form>
    <h4 class="error-login"><?php echo $msg ?></h4>

<?php } elseif ($_SESSION['logged_in']) {

    //TODO:
    //logout after being inactive for 15 min
    if (time() - $_SESSION['timeout'] > 900) {
        echo "<script>alert('Your session has expired. Please log in again.');</script>";
        unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timeout']);
        $_SESSION['logged_in'] = false;
        header("Location: /");
        exit;
    } else {
        $_SESSION['timeout'] = time();
    }


    print("Login successful"); ?>

    <a class="logout" href="?action=logout">Logout</a>/

<?php

}
