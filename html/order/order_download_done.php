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

		$year = $_POST['year'];
		$month = $_POST['month'];
		$day = $_POST['day'];

		$dsn = 'mysql:dbname=sample-db;host=mysql;charset=utf8';
		$user = 'root';
		$password = 'Soraki!1234';
		$dbh = new PDO($dsn, $user, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = '
SELECT
	sales.code,
	sales.date,
	sales.code_member,
	sales.name AS dat_sales_name,
	sales.email,
	sales.zipcode,
	sales.address,
	sales.tel,
	sales_detail.code_product,
	mst_product.name AS mst_product_name,
	sales_detail.price,
	sales_detail.quantity
FROM
	sales,sales_detail,mst_product
WHERE
sales.code=sales_detail.code_sales
	AND sales_detail.code_product=mst_product.code
	AND substr(sales.date,1,4)=?
	AND substr(sales.date,6,2)=?
	AND substr(sales.date,9,2)=?
';
		$stmt = $dbh->prepare($sql);
		$data[] = $year;
		$data[] = $month;
		$data[] = $day;
		$stmt->execute($data);

		$dbh = null;

		$csv = '注文コード,注文日時,会員番号,お名前,メール,郵便番号,住所,TEL,商品コード,商品名,価格,数量';
		$csv .= "\n";
		while (true) {
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($rec == false) {
				break;
			}
			$csv .= $rec['code'];
			$csv .= ',';
			$csv .= $rec['date'];
			$csv .= ',';
			$csv .= $rec['code_member'];
			$csv .= ',';
			$csv .= $rec['dat_sales_name'];
			$csv .= ',';
			$csv .= $rec['email'];
			$csv .= ',';
			$csv .= $rec['zipcode'];
			$csv .= ',';
			$csv .= $rec['address'];
			$csv .= ',';
			$csv .= $rec['tel'];
			$csv .= ',';
			$csv .= $rec['code_product'];
			$csv .= ',';
			$csv .= $rec['mst_product_name'];
			$csv .= ',';
			$csv .= $rec['price'];
			$csv .= ',';
			$csv .= $rec['quantity'];
			$csv .= "\n";
		}

		// print nl2br($csv);
		// TODO: random file name for output csv files
		$file = fopen('./csv/order.csv', 'w');
		// $csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');
		fputs($file, $csv);
		fclose($file);
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}

	?>

	<a href="csv/order.csv">注文データのダウンロード</a>
	<br />
	<br />
	<a href="order_download.php">日付選択へ</a>
	<br />
	<br />
	<a href="../staff_login/staff_top.php">トップメニューへ</a>
	<br />

</body>

</html>
