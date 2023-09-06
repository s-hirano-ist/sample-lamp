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
	$post = sanitize_all($_POST);
	$pro_code = $post['code'];
	$pro_name = $post['name'];
	$pro_price = $post['price'];
	$pro_image_name_old = $post['image_name_old'];

	$product_image = $_FILES['image'];
	// FIXME: 商品画像ファイル名のバリデーション

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
		print '円<br />';
	}

	$product_image_name = sanitize($_FILES['image']['name']);

	if ($product_image['size'] > 0) {
		if ($product_image['size'] > 1000000) {
			print '画像が大き過ぎます';
		} else {
			move_uploaded_file($product_image['tmp_name'], './image/' . $product_image_name);
			print '<img src="./image/' . $product_image_name . '">';
			print '<br />';
		}
	}

	if ($pro_name == '' || preg_match('/\A[0-9]+\z/', $pro_price) == 0 || $product_image['size'] > 1000000) {
		print '<form>';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '</form>';
	} else {
		print '上記のように変更します。<br />';
		print '<form method="post" action="pro_edit_done.php">';
		print '<input type="hidden" name="code" value="' . $pro_code . '">';
		print '<input type="hidden" name="name" value="' . $pro_name . '">';
		print '<input type="hidden" name="price" value="' . $pro_price . '">';
		print '<input type="hidden" name="image_name_old" value="' . $pro_image_name_old . '">';
		print '<input type="hidden" name="image_name" value="' . $product_image_name . '">';
		print '<br />';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '<input type="submit" value="OK">';
		print '</form>';
	}
	?>
</body>

</html>
