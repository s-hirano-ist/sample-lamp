<?php

function connectToDatabase()
{
    require_once('../load_dotenv.php');

    $dsn = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['HOST_NAME'] . ';charset=utf8';
    $dbh = new PDO($dsn, $_ENV['USER_NAME'], $_ENV['PASSWORD']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function executeSql($sql, $dbh)
{
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function executeSqlWithData($sql, $dbh, $data)
{
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    return $stmt;
}
