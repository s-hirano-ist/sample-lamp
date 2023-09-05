<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br />';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['staff_name'];
    print 'さんログイン中<br />';
    print '<br />';
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sample website</title>
</head>

<body>
    <?php
    try {
        $staff_code = $_POST['code'];

        require_once('../common/database.php');
        $dbh = connectToDatabase();

        // FIXME: CSRF脆弱性あり
        $sql = 'DELETE FROM mst_staff WHERE code=?';
        $data[] = $staff_code;
        $stmt = executeSqlWithData($sql, $dbh, $data);

        $dbh = null;
    } catch (Exception $e) {
        print $e;
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }
    ?>
    削除しました。
    <br />
    <br />
    <a href="staff_list.php"> 戻る </a>
</body>

</html>
