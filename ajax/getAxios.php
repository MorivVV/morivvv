<?php
function writeLogs ($text, $file='axios.txt'){
  if (isset($text)) {
      file_put_contents(''.$file, $text. PHP_EOL, FILE_APPEND);
  }
}

// получаем параметр запрашиваемого запроса
if (isset($_POST['sqlname'])){
  $sqlname = $_POST['sqlname'];
  writeLogs("POST[sqlname]=" . $_POST['sqlname']);
}else{
  return;
}

try {
  $config = include_once '../db/localhost.php';
  $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];
  $pdo = new PDO($dsn, $config['user'], $config['password']);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage();
  die();
}

// получаем из БД текст запроса и параметры
$stm = $pdo->prepare("SELECT 
ssq.sql_query QUERY
, ssq.sql_params PARAMS
FROM SYS_SQL_QUERY ssq
WHERE ssq.sql_name = ?");
$stm->execute(array($sqlname));
if ($row = $stm->fetch()){
  $sqlQuery = $row['QUERY'];
  $sqlParams = $row['PARAMS'];
  // writeLogs("sqlQuery = $sqlQuery");
  // writeLogs("sqlParams = $sqlParams");
}else{
  return;
}
// извлекаем из параметов имена переменных, с которыми нам нужно выполнить запрос
if ($sqlParams == ''){
  $paramList = array();
}else {
  $paramList = explode(',', $sqlParams);
}
$bindParams = array();
// получаем нужные параметры из запроса пост
foreach ($paramList as $param) {
  if (isset($_POST[$param])){
    $bindParams[$param] = $_POST[$param];
    writeLogs("$param = ".$_POST[$param]);
  }else{
    return;
  }
}

$stm = $pdo->prepare($sqlQuery);
$stm->execute($bindParams);

$dataAudit = array();
while ($row = $stm->fetch()){
    if (isset($row['ID'])){
      $dataAudit[$row['ID']] = $row;
    }else{
      $dataAudit []= $row;
    }
}
echo json_encode($dataAudit);