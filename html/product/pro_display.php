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
		$pro_code = $_GET['product_code'];

		require_once('../common/database.php');
		$dbh = connectToDatabase();

		$sql = 'SELECT name,price,image_path FROM mst_product WHERE code=?';
		$data[] = $pro_code;
		$stmt = executeSqlWithData($sql, $dbh, $data);

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$pro_name = $rec['name'];
		$pro_price = $rec['price'];
		$pro_image_name = $rec['image_path'];

		$dbh = null;

		if ($pro_image_name == "") {
			$show_image = "";
		} else {
			$show_image = '<img src="./image/' . $pro_image_name . '">';
		}
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>

	商品情報参照
	<br />
	<br />
	商品コード
	<br />
	<?php print $pro_code; ?>
	<br />
	商品名
	<br />
	<?php print $pro_name; ?>
	<br />
	価格
	<br />
	<?php print $pro_price; ?>円
	<br />
	<?php print $show_image; ?>
	<br />
	<br />
	<form>
		<input type="button" onclick="history.back()" value="戻る">
	</form>

</body>

</html>
