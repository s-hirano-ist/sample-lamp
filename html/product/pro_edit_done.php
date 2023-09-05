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
		$post = sanitize($_POST);
		$pro_code = $post['code'];
		$pro_name = $post['name'];
		$pro_price = $post['price'];
		$pro_image_name_old = $post['image_name_old'];
		$pro_image_name = $post['image_name'];

		require_once('../common/database.php');
		$dbh = connectToDatabase();

		$sql = 'UPDATE mst_product SET name=?,price=?,image_path=? WHERE code=?';
		$data[] = $pro_name;
		$data[] = $pro_price;
		$data[] = $pro_image_name;
		$data[] = $pro_code;
		$stmt = executeSqlWithData($sql, $dbh, $data);

		$dbh = null;

		if ($pro_image_name_old != $pro_image_name) {
			if ($pro_image_name_old != '') {
				unlink('./image/' . $pro_image_name_old);
			}
		}
		print '修正しました。<br />';
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	<a href="pro_list.php">戻る</a>
</body>

</html>
