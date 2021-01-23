<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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

    print(strstr($request, "?", true));
    if ($request !== '/admin') {
        //header nav
        print('<header>
    <h1>TVS</h1>
    <ul>
        <li><a href="/">Home</a></li>');

        //Get pages
        $page = $entityManager->getRepository('Models\Page')->findAll();
        foreach ($page as $p) {
            print('<li><a href=' . $p->getName() . '>' . $p->getName() . '</a></li>');
        }

        print('</ul>
</header>');
    }

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