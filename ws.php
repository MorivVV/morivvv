<?php
require_once('common.php');
//include_once DB;
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
        echo json_encode($data) . ' : ' . $connection->getRemoteAddress().PHP_EOL;
        foreach ($users as $key => $value) {
            if (strpos($key, ("-" . $data->chat))) {
                echo $key.":".$value->getRemoteAddress().PHP_EOL;
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
        // при подключении нового пользователя сохраняем get-параметр, который же сами и передали со страницы сайта
        
        $users[$_GET['user'] . "-" . $_GET['chat']] = $connection;
        $data['sender']='info-bot';
        $data['message']=$_GET['user'].' вошел в чат c IP:'.$connection->getRemoteAddress();
        echo $_GET['user'] . "-" . $_GET['chat'] . ' : ' . $connection->getRemoteAddress().PHP_EOL;
        foreach ($users as $key => $value) {
            if (strpos($key, ("-" . $data->chat))) {
                echo $key.":".$value->getRemoteAddress().PHP_EOL;
                $webconnection = $value;
                $webconnection->send(json_encode($data));
            } 
        }
        // вместо get-параметра можно также использовать параметр из cookie, например $_COOKIE['PHPSESSID']
    };
};

$ws_worker->onClose = function($connection) use(&$users)
{
    // удаляем параметр при отключении пользователя
    $user = array_search($connection, $users);
    $data['sender']='info-bot';
    $data['message']=$user.' покинул чат ('.$connection->getRemoteAddress() . ')';    
    foreach ($users as $key => $value) {
        if (strpos($key, ("-" . $data->chat))) {
            echo $key.":".$value->getRemoteAddress().PHP_EOL;
            $webconnection = $value;
            $webconnection->send(json_encode($data));
        }
    }
    unset($users[$user]);
};

// Run worker
Worker::runAll();