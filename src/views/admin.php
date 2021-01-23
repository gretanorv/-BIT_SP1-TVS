<?php


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

    print("<pre>Find all Pages: " . "<br>");
    $pages = $entityManager->getRepository('Models\Page')->findAll();
    print("<table>");
    foreach ($pages as $p)
        print("<tr>"
            . "<td>" . $p->getName()  . "</td>"
            . "<td><a href=\"?delete={$p->getId()}\">DELETE</a>☢️</td>"
            . "<td><a href=\"?updatable={$p->getId()}\">UPDATE</a>♻️</td>"
            . "</tr>");
    print("</table>");
    print("</pre><hr>");
}

//update forma
if (isset($_GET['updatable'])) {
    $page = $entityManager->find('Models\Page', $_GET['updatable']);
    print("<pre>Update Page: </pre>");
    print("
        <form action=\"\" method=\"POST\">
        <input type=\"hidden\" name=\"update_id\" value=\"{$page->getId()}\">
            <label for=\"name\">Page name: </label><br>
            <input type=\"text\" name=\"update_name\" value=\"{$page->getName()}\"><br>
            <textarea name='update_content' id=''cols='30' rows='10'>{$page->getContent()}</textarea>
            <input type=\"submit\" value=\"Submit\">
        </form>
    ");
    print("<hr>");
}

// Update
if (isset($_POST['update_content'])) {
    $page = $entityManager->find('Models\Page', $_POST['update_id']);
    $page->setName($_POST['update_name']);
    $page->setContent($_POST['update_content']);
    $entityManager->flush();
    header("Location: " . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}

//Delete
if (isset($_GET['delete'])) {
    $page = $entityManager->find('Models\Page', $_GET['delete']);
    $entityManager->remove($page);
    $entityManager->flush();
    header("Location: " . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}
