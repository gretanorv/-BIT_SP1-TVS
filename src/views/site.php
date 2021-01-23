<?php

$arr = $entityManager->getRepository('Models\Page')->findBy(array('name' => str_replace("/", "", str_replace("/", "", $request))));


print($arr[0]->getContent());
