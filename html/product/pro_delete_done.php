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
		$pro_code = $_POST['code'];
		$pro_image_name = $_POST['image_name'];

		require_once('../common/database.php');
		$dbh = connectToDatabase();

		$sql = 'DELETE FROM mst_product WHERE code=?';
		$data[] = $pro_code;
		$stmt = executeSqlWithData($sql, $sql, $data);
		$dbh = null;

		if ($pro_image_name != "") {
			unlink('./image/' . $pro_image_name);
		}
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	削除しました。
	<br />
	<br />
	<a href="pro_list.php"> 戻る</a>
</body>

</html>
