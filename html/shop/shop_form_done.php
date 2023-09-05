<?php
session_start();
session_regenerate_id(true);
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

		$name = $post['name'];
		$email = $post['email'];
		$zipcode1 = $post['zipcode1'];
		$zipcode2 = $post['zipcode2'];
		$address = $post['address'];
		$tel = $post['tel'];
		$order = $post['order'];
		$pass = $post['pass'];
		$sex = $post['sex'];
		$birth = $post['birth'];

		print $name . '様<br />';
		print 'ご注文ありがとうござました。<br />';
		print $email . 'にメールを送りましたのでご確認ください。<br />';
		print '商品は以下の住所に発送させていただきます。<br />';
		print $zipcode1 . '-' . $zipcode2 . '<br />';
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


		$sql = 'LOCK TABLES sales WRITE,sales_detail WRITE,member WRITE';
		$stmt = executeSql($sql, $dbh);

		$zipcode = $zipcode1 . $zipcode2;

		$last_member_code = 0;
		if ($order == 'order_register') {
			$sql = 'INSERT INTO member (password,name,email,zipcode,address,tel,sex,birthyear) VALUES (?,?,?,?,?,?,?,?)';
			$data = array();
			$data[] = md5($pass);
			$data[] = $name;
			$data[] = $email;
			$data[] = $zipcode;
			$data[] = $address;
			$data[] = $tel;
			if ($sex == 'dan') {
				$data[] = 1;
			} else {
				$data[] = 2;
			}
			$data[] = $birth;
			$stmt = executeSqlWithData($sql, $dbh, $data);

			$sql = 'SELECT LAST_INSERT_ID()';
			$stmt = executeSql($sql, $dbh);
			$rec = $stmt->fetch(PDO::FETCH_ASSOC);
			$last_member_code = $rec['LAST_INSERT_ID()'];
		}

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


		if ($order == 'order_register') {
			print '会員登録が完了いたしました。<br />';
			print '次回からメールアドレスとパスワードでログインしてください。<br />';
			print 'ご注文が簡単にできるようになります。<br />';
			print '<br />';
		}

		$main_text .= "送料は無料です。\n";
		$main_text .= "--------------------\n";
		$main_text .= "\n";
		$main_text .= "代金は以下の口座にお振込ください。\n";
		$main_text .= "ろくまる銀行 やさい支店 普通口座 1234567\n";
		$main_text .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
		$main_text .= "\n";

		if ($order == 'order_register') {
			$main_text .= "会員登録が完了いたしました。\n";
			$main_text .= "次回からメールアドレスとパスワードでログインしてください。\n";
			$main_text .= "ご注文が簡単にできるようになります。\n";
			$main_text .= "\n";
		}

		$main_text .= "□□□□□□□□□□□□□□\n";
		$main_text .= " ～安心野菜のろくまる農園～\n";
		$main_text .= "\n";
		$main_text .= "○○県六丸郡六丸村123-4\n";
		$main_text .= "電話 090-6060-xxxx\n";
		$main_text .= "メール info@rokumarunouen.co.jp\n";
		$main_text .= "□□□□□□□□□□□□□□\n";

		print '<br />';
		print nl2br($main_text);
		// MEMO: No need to send email
		// FIXME: メールヘッダーインジェクション 改行チェックなしのため
		// $title = 'ご注文ありがとうございます。';
		// $header = 'From:info@rokumarunouen.co.jp';
		// $main_text = html_entity_decode($main_text, ENT_QUOTES, 'UTF-8');
		// mb_language('Japanese');
		// mb_internal_encoding('UTF-8');
		// mb_send_mail($email, $title, $main_text, $header);

		// $title = 'お客様からご注文がありました。';
		// $header = 'From:' . $email;
		// $main_text = html_entity_decode($main_text, ENT_QUOTES, 'UTF-8');
		// mb_language('Japanese');
		// mb_internal_encoding('UTF-8');
		// mb_send_mail('info@rokumarunouen.co.jp', $title, $main_text, $header);
	} catch (Exception $e) {
		print 'ただいま障害により大変ご迷惑をお掛けしております。';
		exit();
	}

	?>
	<br />
	<a href="shop_list.php">商品画面へ</a>
	<!-- TODO: 注文が完了したらショッピングカートを空にする -->

</body>

</html>
