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
        require_once('../common/sanitize.php');
        $post = sanitize_all($_POST);

        $staff_code = $post['code'];
        $staff_name = $post['name'];
        $staff_pass = $post['pass'];

        require_once('../common/database.php');
        $dbh = connectToDatabase();


        $sql = 'UPDATE mst_staff SET name=?, password=? WHERE code=?';
        $data[] = $staff_name;
        $data[] = $staff_pass;
        $data[] = $staff_code;
        $stmt = executeSqlWithData($sql, $dbh, $data);

        $dbh = null;
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }
    ?>
    修正しました。
    <br />
    <br />
    <a href="staff_list.php"> 戻る </a>
</body>

</html>
