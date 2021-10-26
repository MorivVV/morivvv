<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class Database {
    private $link;
    private $stn;
    private $debag;
    public function __construct($incl, $debag) {
        $this->debag = $debag;
        $this->connect($incl); 
    }
    private function connect($incl) {
        $config = include_once $incl;
        $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];
        $this->link = new PDO($dsn, $config['user'], $config['password']);
        if (is_null($this->link)) {
            echo 'пиздец база';
            exit;
        } 
        return $this;
    }
    public function execute(string $sql, $param=null) {
        $this->loggi($sql);
        if ($this->debag) {
            ErrLog($sql);
        }
        $this->sth = $this->link->prepare($sql);
        $this->sth->execute($param);
        return $this->sth->rowCount();
    }
    public function select() {
        $result = $this->sth->fetch(PDO::FETCH_ASSOC);
        if ($result === FALSE){
            return FALSE;
        }
        return $result;
    }
    private function loggi($sql) {
        $REQUEST_URI = $_SERVER['REQUEST_URI'];
        $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
        $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
        $HTTP_REFERER = "";
        if (isset($_SERVER['HTTP_REFERER'])) {
            $HTTP_REFERER = $_SERVER['HTTP_REFERER'];
        }
        $SERVER_PROTOCOL = $_SERVER['SERVER_PROTOCOL'];
        $QUERY_STRING = $_SERVER['QUERY_STRING'];
        $sql1 = "INSERT INTO bd_list_use_site (time_active, request_uri, remote_addr, http_user_agent, http_referer, server_protokol, query_string, sql_query) "
               . "VALUES ( CURRENT_TIMESTAMP, '$REQUEST_URI', '$REMOTE_ADDR', '$HTTP_USER_AGENT', '$HTTP_REFERER', '$SERVER_PROTOCOL', '$QUERY_STRING','".addslashes (preg_replace('<[\s\t]+>',' ',$sql))."')";
        $this->sth = $this->link->prepare($sql1);
        $this->sth->execute();
    }

    public function selectNum() {
        $result = $this->sth->fetch(PDO::FETCH_NUM);
        if ($result === FALSE){
            return FALSE;
        }
        return $result;
    }
    public function __destruct() {
        $this->link=null;
    }
    
}
