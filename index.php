<?php


include_once "bootstrap.php";

use Models\Page;


$request = $_SERVER['REQUEST_URI'];

// print($request . '<br>');

switch ($request) {
    case '/':
        require __DIR__ . '/src/views/home.php';
        break;
    case '':
        require __DIR__ . '/src/views/home.php';
        break;
    case '/admin' or '/admin?':
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

//Get pages
$page = $entityManager->getRepository('Models\Page')->findAll();
foreach ($page as $p) {
    print('<li><a href=' . $p->getName() . '>' . $p->getName() . '</a></li>');

    print($request . " " . $p->getName());
    switch ($request) {
        case '/' . $p->getName():
            print($p->getContent());
            break;
    }
}

print('</ul>
</header>');
