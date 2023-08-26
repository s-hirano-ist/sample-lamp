<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['member_login']) == false) {
	print 'ようこそゲスト様 ';
	print '<a href="member_login.html">会員ログイン</a><br />';
	print '<br />';
} else {
	print 'ようこそ';
	print $_SESSION['member_name'];
	print ' 様 ';
	print '<a href="member_logout.php">ログアウト</a><br />';
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
		require_once('../common/database.php');
		$dbh = connectToDatabase();

		$sql = 'SELECT code,name,price FROM mst_product WHERE 1';
		$stmt = executeSql($sql, $dbh);
		$dbh = null;

		print '商品一覧<br /><br />';

		while (true) {
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($rec == false) {
				break;
			}
			print '<a href="shop_product.php?procode=' . $rec['code'] . '">'; #TODO: .$の仕組み
			print $rec['name'] . '---';
			print $rec['price'] . '円';
			print '</a>';
			print '<br />';
		}
		print '<br />';
		print '<a href="shop_cartlook.php">カートを見る</a><br />';
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}
	?>
</body>

</html>
