<?php

function executeSql($sql)
{
    require_once('../load_dotenv.php');

    $dsn = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['HOST_NAME'] . ';charset=utf8';
    $dbh = new PDO($dsn, $_ENV['USER_NAME'], $_ENV['PASSWORD']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $dbh = null;
    return $stmt;
}
