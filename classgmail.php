<?php

class Gmail {

private $mail;
private $email;
private $pass;
    
public function __construct($email, $pass)
{
    $this->email = $email;
    $this->pass = $pass;
}

private function mailGen()
{
    $from = yield;
    $to = yield;
    $subject = yield;
    $body = yield;
    yield "FROM: <" . $from . ">\r\n";
    yield "To: <" . $to . ">\r\n";
    yield "Subject: " . $subject . "\r\n";
    yield "\r\n";
    yield $body;
    yield '';
}

public function getLine()
{
    $resp = $this->mail->current();
    $this->mail->next();
    return $resp;
}

public function send($to, $subject, $body)
{
    $this->mail = $this->mailGen();
    $this->mail->send($this->email);
    $this->mail->send($to);
    $this->mail->send($subject);
    $this->mail->send($body);

    $ch = curl_init('smtps://smtp.gmail.com:465');
    curl_setopt($ch, CURLOPT_MAIL_FROM, "<" . $this->email . ">");
    curl_setopt($ch, CURLOPT_MAIL_RCPT, ["<" . $to . ">"]);
    curl_setopt($ch, CURLOPT_USERNAME, $this->email);
    curl_setopt($ch, CURLOPT_PASSWORD, $this->pass);
    curl_setopt($ch, CURLOPT_USE_SSL, CURLUSESSL_ALL);
    curl_setopt($ch, CURLOPT_PUT, 1);
    curl_setopt($ch, CURLOPT_READFUNCTION, [$this, 'getLine']);
    return curl_exec($ch);
}
}

$gmail = new Gmail('morivvv@gmail.com', 'GiHdhrM7');
$res = $gmail->send('morivvv@ya.ru', 'Проверям отправку с сайта', 'Если это письмо пришло, то вообще супер круто');
echo "<pre>";
var_dump($res);
echo "</pre>";