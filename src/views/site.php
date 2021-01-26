<?php

print("<div class='site'>");
$arr = $entityManager->getRepository('Models\Page')->findBy(array('name' => str_replace("/", "", str_replace("/", "", str_replace("%20", " ", $request)))));


print($arr[0]->getContent());
print("</div>");
