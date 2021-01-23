<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Nanum+Gothic&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <?php


    include_once "bootstrap.php";

    use Models\Page;

    session_start();
    //logout logic
    if (isset($_GET['action']) and $_GET['action'] === 'logout') {
        session_start();
        unset($_SESSION['logged_in']);
        unset($_SESSION['timeout']);
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        $redirect_to = strstr($_SERVER['REQUEST_URI'], "/", true);
        print("Redirected: " . $redirect_to);
        header("Location: /");
        die();
    }

    $request = $_SERVER['REQUEST_URI'];

    // if ($request !== '/admin') {
    //header nav
    print('<header class="header">
    <h3 class="header__title">TVS</h3>
    <ul class="header__menu">
        <li class="header__menu-item"><a href="/">Pagrindinis</a></li>');

    //Get pages
    $page = $entityManager->getRepository('Models\Page')->findAll();
    foreach ($page as $p) {
        print('<li class="header__menu-item"><a href=' . $p->getName() . '>' . $p->getName() . '</a></li>');
    }

    print('</ul>');
    if ($_SESSION['logged_in']) {
        print('<a class="logout" href="?action=logout">Logout</a>');
    }
    print('</header>');
    // }

    //router
    switch ($request) {
        case '/':
            require __DIR__ . '/src/views/home.php';
            break;
        case '':
            require __DIR__ . '/src/views/home.php';
            break;
        case '/' . ($entityManager->getRepository('Models\Page')->findBy(array('name' => str_replace("/", "", str_replace("/", "", $request)))) ?
            $entityManager->getRepository('Models\Page')->findBy(array('name' => str_replace("/", "", str_replace("/", "", $request))))[0]->getName() :
            false):
            require __DIR__ . '/src/views/site.php';
            break;
        case '/admin' or '/admin?': //for now
            require __DIR__ . '/src/views/admin.php';
            break;
        default:
            http_response_code(404);
            require __DIR__ . '/src/views/404.php';
            break;
    }
    ?>

</body>

</html>