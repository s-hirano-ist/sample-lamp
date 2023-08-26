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

		$post = sanitize($_POST);

		$onamae = $post['onamae'];
		$email = $post['email'];
		$zipcode = $post['zipcode'];
		$address = $post['address'];
		$tel = $post['tel'];

		print $onamae . '様<br />';
		print 'ご注文ありがとうござました。<br />';
		print $email . 'にメールを送りましたのでご確認ください。<br />';
		print '商品は以下の住所に発送させていただきます。<br />';
		print $zipcode . '<br />';
		print $address . '<br />';
		print $tel . '<br />';

		$honbun = '';
		$honbun .= $onamae . "様\n\nこのたびはご注文ありがとうございました。\n";
		$honbun .= "\n";
		$honbun .= "ご注文商品\n";
		$honbun .= "--------------------\n";

		$cart = $_SESSION['cart'];
		$kazu = $_SESSION['kazu'];
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
			$kakaku[] = $price;
			$suryo = $kazu[$i];
			$shokei = $price * $suryo;

			$honbun .= $name . ' ';
			$honbun .= $price . '円 x ';
			$honbun .= $suryo . '個 = ';
			$honbun .= $shokei . "円\n";
		}

		$sql = 'LOCK TABLES sales WRITE,sales_detail WRITE';
		$stmt = executeSql($sql, $dbh);

		$lastmembercode = $_SESSION['member_code'];

		$sql = 'INSERT INTO sales (code_member,name,email,zipcode,address,tel) VALUES (?,?,?,?,?,?)';
		$data = array();
		$data[] = $lastmembercode;
		$data[] = $onamae;
		$data[] = $email;
		$data[] = $zipcode;
		$data[] = $address;
		$data[] = $tel;
		$stmt = executeSqlWithData($sql, $dbh, $data);

		$sql = 'SELECT LAST_INSERT_ID()';
		$stmt = executeSql($sql, $dbh);
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$lastcode = $rec['LAST_INSERT_ID()'];

		for ($i = 0; $i < $max; $i++) {
			$sql = 'INSERT INTO sales_detail (code_sales,code_product,price,quantity) VALUES (?,?,?,?)';
			$data = array();
			$data[] = $lastcode;
			$data[] = $cart[$i];
			$data[] = $kakaku[$i];
			$data[] = $kazu[$i];
			$stmt = executeSqlWithData($sql, $dbh, $data);
		}

		$sql = 'UNLOCK TABLES';
		$stmt = executeSql($sql, $dbh);
		$dbh = null;

		$honbun .= "送料は無料です。\n";
		$honbun .= "--------------------\n";
		$honbun .= "\n";
		$honbun .= "代金は以下の口座にお振込ください。\n";
		$honbun .= "ろくまる銀行 やさい支店 普通口座 1234567\n";
		$honbun .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
		$honbun .= "\n";

		$honbun .= "□□□□□□□□□□□□□□\n";
		$honbun .= " ～安心野菜のろくまる農園～\n";
		$honbun .= "\n";
		$honbun .= "○○県六丸郡六丸村123-4\n";
		$honbun .= "電話 090-6060-xxxx\n";
		$honbun .= "メール info@rokumarunouen.co.jp\n";
		$honbun .= "□□□□□□□□□□□□□□\n";
		//print '<br />';
		//print nl2br($honbun);

		$title = 'ご注文ありがとうございます。';
		$header = 'From:info@rokumarunouen.co.jp';
		$honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail($email, $title, $honbun, $header);

		$title = 'お客様からご注文がありました。';
		$header = 'From:' . $email;
		$honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail('info@rokumarunouen.co.jp', $title, $honbun, $header);
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
