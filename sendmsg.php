<?php
$localsocket = 'tcp://185.148.81.71:1234';
$receiver = 'tester01';
$sender = '';
$message = 'Проверка';
getPost(array('sender'=>'sender', 'receiver' => 'receiver', 'message'=>'message','chat' => 'chat'));

// соединяемся с локальным tcp-сервером
$instance = stream_socket_client($localsocket);
// отправляем сообщение
fwrite($instance, json_encode(['sender' => $sender, 'receiver' => $receiver, 'message' => $message, 'chat' => $chat])  . "\n");