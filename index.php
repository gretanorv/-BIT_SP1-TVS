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
    // $login = false;
    $redirect_to = strstr($_SERVER['REQUEST_URI'], "/", true);
    print("Redirected: " . $redirect_to);
    header("Location: /");
    // header("Refresh:0");
}


$request = $_SERVER['REQUEST_URI'];

// $req = strstr($request, "?", true);
// print($req . '<br>');

//Get pages
$page = $entityManager->getRepository('Models\Page')->findAll();

dump($page);
// print('/' . $page[0]->getName());
print('<hr>');

switch ($request) {
    case '/':
        require __DIR__ . '/src/views/home.php';
        break;
    case '':
        require __DIR__ . '/src/views/home.php';
        break;
    case '/' . $page[0]->getName():
        require __DIR__ . '/src/views/site.php';
        break;
    case '/admin': // or '/admin?':
        require __DIR__ . '/src/views/admin.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/src/views/404.php';
        break;
}

//nav
print('<header>
    <h1>TVS</h1>
    <ul>
        <li><a href="/">Home</a></li>');

// //Get pages
// $page = $entityManager->getRepository('Models\Page')->findAll();
// foreach ($page as $p) {
//     print('<li><a href=' . $p->getName() . '>' . $p->getName() . '</a></li>');

//     // print($request . " " . $p->getName());
//     switch ($request) {
//         case '/' . $p->getName():
//             print($p->getContent());
//             break;
//     }
// }

print('</ul>
</header>');
