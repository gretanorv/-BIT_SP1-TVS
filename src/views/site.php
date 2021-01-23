<?php

print("New page");
$arr = $entityManager->getRepository('Models\Page')->findBy(array('name' => str_replace("/", "", str_replace("/", "", $request))));

dump($arr);

print($arr[0]->getContent());
