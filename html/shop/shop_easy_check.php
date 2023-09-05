<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['member_login']) == false) {
	print 'ログインされていません。<br />';
	print '<a href="shop_list.php">商品一覧へ</a>';
	exit();
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
	$code = $_SESSION['member_code'];

	require_once('../common/database.php');
	$dbh = connectToDatabase();

	$sql = 'SELECT name,email,zipcode,address,tel FROM member WHERE code=?';
	$data[] = $code;
	$stmt = executeSqlWithData($sql, $dbh, $data);
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$dbh = null;

	$name = $rec['name'];
	$email = $rec['email'];
	$zipcode = $rec['zipcode'];
	$address = $rec['address'];
	$tel = $rec['tel'];

	print 'お名前<br />';
	print $name;
	print '<br /><br />';

	print 'メールアドレス<br />';
	print $email;
	print '<br /><br />';

	print '郵便番号<br />';
	print $zipcode;
	print '<br /><br />';

	print '住所<br />';
	print $address;
	print '<br /><br />';

	print '電話番号<br />';
	print $tel;
	print '<br /><br />';

	print '<form method="post" action="shop_easy_done.php">';
	print '<input type="hidden" name="name" value="' . $name . '">';
	print '<input type="hidden" name="email" value="' . $email . '">';
	print '<input type="hidden" name="zipcode" value="' . $zipcode . '">';
	print '<input type="hidden" name="address" value="' . $address . '">';
	print '<input type="hidden" name="tel" value="' . $tel . '">';
	print '<input type="button" onclick="history.back()" value="戻る">';
	print '<input type="submit" value="OK"><br />';
	print '</form>';
	?>

</body>

</html>
