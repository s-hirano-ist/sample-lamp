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
	require_once('../common/sanitize.php');
	$post = sanitize($_POST);
	$pro_name = $post['name'];
	$pro_price = $post['price'];

	$product_image = $_FILES['image'];
	# FIXME: HTMLエスケープ処理が抜けている 商品画像 ファイル名 XSS脆弱性

	if ($pro_name == '') {
		print '商品名が入力されていません。<br />';
	} else {
		print '商品名:';
		print $pro_name;
		print '<br />';
	}

	if (preg_match('/\A[0-9]+\z/', $pro_price) == 0) {
		print '価格をきちんと入力してください。<br />';
	} else {
		print '価格:';
		print $pro_price;
		print '円 <br />';
	}

	if ($product_image['size'] > 0) {
		if ($product_image['size'] > 1000000) {
			print '画像が大き過ぎます';
		} else {
			move_uploaded_file($product_image['tmp_name'], './image/' . $product_image['name']);
			print '<img src="./image/' . $product_image['name'] . '">';
			print '<br />';
		}
	}

	if ($pro_name == '' || preg_match('/\A[0-9]+\z/', $pro_price) == 0 || $product_image['size'] > 1000000) {
		print '<form>';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '</form>';
	} else {
		print '上記の商品を追加します。<br />';
		print '<form method="post" action="pro_add_done.php">';
		print '<input type="hidden" name="name" value="' . $pro_name . '">';
		print '<input type="hidden" name="price" value="' . $pro_price . '">';
		print '<input type="hidden" name="image_name" value="' . $product_image['name'] . '">';
		print '<br />';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '<input type="submit" value="OK">';
		print '</form>';
	}
	?>
</body>

</html>
