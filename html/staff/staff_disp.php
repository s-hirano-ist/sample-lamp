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
    <title>sample title</title>
</head>

<body>
    <?php
    try {
        $staff_code = $_GET['staffcode'];

        require_once('../common/database.php');
        $dbh = connectToDatabase();

        $sql = 'SELECT name FROM mst_staff WHERE code=?';
        $data[] = $staff_code;
        $stmt = executeSqlWithData($sql, $dbh, $data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        $staff_name = $rec['name'];

        $dbh = null;
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をおかけしております。';
        exit();
    }
    ?>

    スタッフ情報参照
    <br />
    <br />
    スタッフコード
    <br />
    <?php print $staff_code; ?>
    <br />
    スタッフ名
    <br />
    <?php print $staff_name; ?>
    <br />
    <br />
    <form>
        <input type="button" onclick="history.back()" value="戻る">
    </form>
</body>

</html>
