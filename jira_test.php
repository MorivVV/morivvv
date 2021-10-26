<?php

require_once 'src/Unirest.php';

Unirest\Request::verifyPeer(false);
Unirest\Request::auth('morivvv@gmail.com', 'vQWibpCJfuEv01BXLFHy3F50');
$response = Unirest\Request::get('https://morivvv.atlassian.net/rest/api/2/search?author = Владимир Моривец', null, null);

echo 'https://morivvv.atlassian.net/rest/api/2/search?author = 5eb512af9ce9ee0b898fa45b<br><hr>';
echo "<pre>";
var_dump($response);
echo "</pre>";