<?php


//login logic

use Models\Page;

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
    <div class="admin">
        <h2 class="title title--admin">Prisijunkite</h2>
        <form class="admin-form" method="post">
            <div class="admin-form__field">
                <label for="username" class="admin-form__field-label">Vartotojas</label>
                <input type="text" name="username" id="username" class="admin-form__field-input" placeholder="name: admin" required autofocus>
            </div>
            <div class="admin-form__field">
                <label for="password" class="admin-form__field-label">Slaptažodis</label>
                <input type="password" name="password" id="password" class="admin-form__field-input" placeholder="pass: admin" required>
            </div>
            <input type="submit" value="Prisijungti" name="login" class="admin-form__btn">
        </form>
        <h4 class="error-admin"><?php echo $msg ?></h4>
    </div>

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
    } ?>


<?php
    print("<a class=\"add\" href=\"?add=true\">+</a>");

    $pages = $entityManager->getRepository('Models\Page')->findAll();
    print("<table>");
    foreach ($pages as $p)
        print("<tr>"
            . "<td>" . $p->getName()  . "</td>"
            . "<td><a href=\"?delete={$p->getId()}\">DELETE</a>☢️</td>"
            . "<td><a href=\"?updatable={$p->getId()}\">UPDATE</a>♻️</td>"
            . "</tr>");
    print("</table>");
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

//add forma
if (isset($_GET['add'])) {
    print("
        <form action=\"\" method=\"POST\">
        <input type=\"hidden\" name=\"id\">
            <label for=\"name\">Page name: </label><br>
            <input type=\"text\" name=\"name\"><br>
            <textarea name='content' id=''cols='30' rows='10'></textarea>
            <input type=\"submit\" value=\"Submit\">
        </form>
    ");
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

//Add
if (isset($_POST['name'])) {
    $page = new Page();
    $page->setName($_POST['name']);
    $page->setContent($_POST['content']);
    $page->setContent($_POST['content']);
    $entityManager->persist($page);
    $entityManager->flush();
    header("Location: " . parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
}
