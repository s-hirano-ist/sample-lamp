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
		$pro_code = $_GET['procode'];

		require_once('../common/database.php');
		$dbh = connectToDatabase();

		$sql = 'SELECT name,price,image_path FROM mst_product WHERE code=?';
		$data[] = $pro_code;
		$stmt = executeSqlWithData($sql, $dbh, $data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$pro_name = $rec['name'];
		$pro_price = $rec['price'];
		$pro_image_name_old = $rec['image'];

		$dbh = null;

		if ($pro_image_name_old == '') {
			$show_image = '';
		} else {
			$show_image = '<img src="./image/' . $pro_image_name_old . '">';
		}
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
	商品修正
	<br />
	<br />
	商品コード
	<br />
	<?php print $pro_code; ?>
	<br />
	<br />
	<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
		<input type="hidden" name="code" value="<?php print $pro_code; ?>">
		<input type="hidden" name="image_name_old" value="<?php print $pro_image_name_old; ?>">
		商品名
		<br />
		<input type="text" name="name" style="width:200px" value="<?php print $pro_name; ?>"><br />
		価格
		<br />
		<input type="text" name="price" style="width:50px" value="<?php print $pro_price; ?>">円
		<br />
		<?php print $show_image; ?>
		<br />
		画像を選んでください。
		<br />
		<input type="file" name="image" style="width:400px"><br />
		<br />
		<br />
		<input type="button" onclick="history.back()" value="戻る">
		<input type="submit" value="OK">
	</form>

</body>

</html>
