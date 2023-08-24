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
		require_once('../common/sanitize.php');
		$post = sanitize($_POST);
		$pro_name = $post['name'];
		$pro_price = $post['price'];
		$pro_gazou_name = $post['gazou_name'];

		$dsn = 'mysql:dbname=sample-db;host=mysql;charset=utf8';
		# FIXME: change to secure settings (Note that dbname is not localhost in docker)

		# FIXME: スクリプト実行脆弱性あり https://blog.tokumaru.org/2014/01/php.html
		$user = 'root';
		$password = 'Soraki!1234';
		$dbh = new PDO($dsn, $user, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = 'INSERT INTO mst_product(name,price, gazou) VALUES (?,?,?)';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_name;
		$data[] = $pro_price;
		$data[] = $pro_gazou_name;
		$stmt->execute($data);

		$dbh = null;

		print $pro_name;
		print 'を追加しました。<br />';
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	<a href="pro_list.php">戻る</a>
</body>

</html>
