<?php
include_once 'common.php';
include_once DB;
require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;

// массив для связи соединения пользователя и необходимого нам параметра
$users = [];
// SSL context.
$context = array(
    'ssl' => array(
        'local_cert'  => ROOT_DIRECTORY.'/ssl/cert.pem',
        'local_pk'    => ROOT_DIRECTORY.'/ssl/cert.key',
        'verify_peer' => false,
    )
);
// создаём ws-сервер, к которому будут подключаться все наши пользователи
$ws_worker = new Worker("websocket://morivvv.ru:8080", $context);
$ws_worker->transport = 'ssl';

// создаём обработчик, который будет выполняться при запуске ws-сервера
$ws_worker->onWorkerStart = function() use (&$users)
{
    // создаём локальный tcp-сервер, чтобы отправлять на него сообщения из кода нашего сайта
    $inner_tcp_worker = new Worker("tcp://185.148.81.71:1234");
    // создаём обработчик сообщений, который будет срабатывать,
    // когда на локальный tcp-сокет приходит сообщение
    $inner_tcp_worker->onMessage = function($connection, $data) use (&$users) {
        $data = json_decode($data);
        // отправляем сообщение пользователю по userId
        //if (isset($users[$data->receiver])) {
        echo date("H:i:s"). "Сейчас в канале ".PHP_EOL;
        foreach ($users as $key => $value) {
            echo $value->worker->name . " ";
            if ($key == $data->receiver) {
                $data->sender = $data->user;
                echo PHP_EOL . date("H:i:s"). ": сообщение '" . $data->message . "' получает " . $key . ' ' . $value->worker->name.": ".$value->getRemoteAddress().PHP_EOL;
                $webconnection = $value;
                $webconnection->send(json_encode($data));
            }
        }
    };
    $inner_tcp_worker->listen();
};

$ws_worker->onConnect = function($connection) use (&$users)
{
    $connection->onWebSocketConnect = function($connection) use (&$users)
    {  
        // при подключении нового пользователя сохраняем его с параметрами входа в сессию на сайте
        $connection->worker->name =$_COOKIE['USER'];
        $users[$_COOKIE['HASHIP']] = $connection;
//        foreach ($users as $key => $value) {
//            $dbPDO->execute("SELECT USER_NAME, ID FROM bd_users WHERE SESSEION_HASH = '$key'");
//            $row  = $dbPDO->select();
//            $data['user'] = $row['USER_NAME'];
//            $data['online'] = 1;
//            $value->send(json_encode($data));
//        }
        echo date("H:i:s"). ": " . $connection->worker->name .' вошел в чат c IP:'.$connection->getRemoteAddress().PHP_EOL;
    };
};

$ws_worker->onClose = function($connection) use(&$users)
{
    // удаляем параметр при отключении пользователя
    $user = array_search($connection, $users);
    echo date("H:i:s"). ": " . $connection->worker->name . ' покинул чат ('.$connection->getRemoteAddress() . ')'.PHP_EOL;
    unset($users[$user]);
};

// Run worker
Worker::runAll();
