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

	try {

		require_once('../common/sanitize.php');

		$post = sanitize_all($_POST);

		$name = $post['name'];
		$email = $post['email'];
		$zipcode = $post['zipcode'];
		$address = $post['address'];
		$tel = $post['tel'];

		print $name . '様<br />';
		print 'ご注文ありがとうござました。<br />';
		print $email . 'にメールを送りましたのでご確認ください。<br />';
		print '商品は以下の住所に発送させていただきます。<br />';
		print $zipcode . '<br />';
		print $address . '<br />';
		print $tel . '<br />';

		$main_text = '';
		$main_text .= $name . "様\n\nこのたびはご注文ありがとうございました。\n";
		$main_text .= "\n";
		$main_text .= "ご注文商品\n";
		$main_text .= "--------------------\n";

		$cart = $_SESSION['cart'];
		$amount = $_SESSION['amount'];
		$max = count($cart);

		require_once('../common/database.php');
		$dbh = connectToDatabase();

		for ($i = 0; $i < $max; $i++) {
			$sql = 'SELECT name,price FROM mst_product WHERE code=?';
			$data[0] = $cart[$i];
			$stmt = executeSqlWithData($sql, $dbh, $data);

			$rec = $stmt->fetch(PDO::FETCH_ASSOC);

			$name = $rec['name'];
			$price = $rec['price'];
			$prices[] = $price;
			$quantity = $amount[$i];
			$total = $price * $quantity;

			$main_text .= $name . ' ';
			$main_text .= $price . '円 x ';
			$main_text .= $quantity . '個 = ';
			$main_text .= $total . "円\n";
		}

		$sql = 'LOCK TABLES sales WRITE,sales_detail WRITE';
		$stmt = executeSql($sql, $dbh);

		$last_member_code = $_SESSION['member_code'];

		$sql = 'INSERT INTO sales (code_member,name,email,zipcode,address,tel) VALUES (?,?,?,?,?,?)';
		$data = array();
		$data[] = $last_member_code;
		$data[] = $name;
		$data[] = $email;
		$data[] = $zipcode;
		$data[] = $address;
		$data[] = $tel;
		$stmt = executeSqlWithData($sql, $dbh, $data);

		$sql = 'SELECT LAST_INSERT_ID()';
		$stmt = executeSql($sql, $dbh);
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$last_code = $rec['LAST_INSERT_ID()'];

		for ($i = 0; $i < $max; $i++) {
			$sql = 'INSERT INTO sales_detail (code_sales,code_product,price,quantity) VALUES (?,?,?,?)';
			$data = array();
			$data[] = $last_code;
			$data[] = $cart[$i];
			$data[] = $prices[$i];
			$data[] = $amount[$i];
			$stmt = executeSqlWithData($sql, $dbh, $data);
		}

		$sql = 'UNLOCK TABLES';
		$stmt = executeSql($sql, $dbh);
		$dbh = null;

		$main_text .= "送料は無料です。\n";
		$main_text .= "--------------------\n";
		$main_text .= "\n";
		$main_text .= "代金は以下の口座にお振込ください。\n";
		$main_text .= "ろくまる銀行 やさい支店 普通口座 1234567\n";
		$main_text .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
		$main_text .= "\n";

		$main_text .= "□□□□□□□□□□□□□□\n";
		$main_text .= " ～安心野菜のろくまる農園～\n";
		$main_text .= "\n";
		$main_text .= "○○県六丸郡六丸村123-4\n";
		$main_text .= "電話 090-6060-xxxx\n";
		$main_text .= "メール info@rokumarunouen.co.jp\n";
		$main_text .= "□□□□□□□□□□□□□□\n";
		//print '<br />';
		//print nl2br($main_text);

		$title = 'ご注文ありがとうございます。';
		$header = 'From:info@rokumarunouen.co.jp';
		$main_text = html_entity_decode($main_text, ENT_QUOTES, 'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail($email, $title, $main_text, $header);

		$title = 'お客様からご注文がありました。';
		$header = 'From:' . $email;
		$main_text = html_entity_decode($main_text, ENT_QUOTES, 'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail('info@rokumarunouen.co.jp', $title, $main_text, $header);
	} catch (Exception $e) {
		print $e;
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}

	?>

	<br />
	<a href="shop_list.php">商品画面へ</a>

</body>

</html>
