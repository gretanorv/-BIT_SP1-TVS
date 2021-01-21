<?php
require_once "bootstrap.php";

use Models\User;


$newUserName = $argv[1];

$user = new User();
$user->setName($newUserName);
$entityManager->persist($user);
$entityManager->flush();

echo "Created user with ID " . $user->getId() . "\n";
