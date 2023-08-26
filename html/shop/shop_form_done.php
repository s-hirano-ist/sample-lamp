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

		$onamae = $post['onamae'];
		$email = $post['email'];
		$postal1 = $post['postal1'];
		$postal2 = $post['postal2'];
		$address = $post['address'];
		$tel = $post['tel'];
		$chumon = $post['chumon'];
		$pass = $post['pass'];
		$danjo = $post['danjo'];
		$birth = $post['birth'];

		print $onamae . '様<br />';
		print 'ご注文ありがとうござました。<br />';
		print $email . 'にメールを送りましたのでご確認ください。<br />';
		print '商品は以下の住所に発送させていただきます。<br />';
		print $postal1 . '-' . $postal2 . '<br />';
		print $address . '<br />';
		print $tel . '<br />';

		$honbun = '';
		$honbun .= $onamae . "様\n\nこのたびはご注文ありがとうございました。\n";
		$honbun .= "\n";
		$honbun .= "ご注文商品\n";
		$honbun .= "--------------------\n";

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
			$kakaku[] = $price;
			$suryo = $amount[$i];
			$shokei = $price * $suryo;

			$honbun .= $name . ' ';
			$honbun .= $price . '円 x ';
			$honbun .= $suryo . '個 = ';
			$honbun .= $shokei . "円\n";
		}


		$sql = 'LOCK TABLES sales WRITE,sales_detail WRITE,member WRITE';
		$stmt = executeSql($sql, $dbh);

		$zipcode = $postal1 . $postal2; // FIXME: one variable

		$lastmembercode = 0;
		if ($chumon == 'chumontouroku') {
			$sql = 'INSERT INTO member (password,name,email,zipcode,address,tel,sex,birthyear) VALUES (?,?,?,?,?,?,?,?)';
			$data = array();
			$data[] = md5($pass);
			$data[] = $onamae;
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
			$lastmembercode = $rec['LAST_INSERT_ID()'];
		}

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
			$data[] = $amount[$i];
			$stmt = executeSqlWithData($sql, $dbh, $data);
		}

		$sql = 'UNLOCK TABLES';
		$stmt = executeSql($sql, $dbh);

		$dbh = null;


		if ($chumon == 'chumontouroku') {
			print '会員登録が完了いたしました。<br />';
			print '次回からメールアドレスとパスワードでログインしてください。<br />';
			print 'ご注文が簡単にできるようになります。<br />';
			print '<br />';
		}

		$honbun .= "送料は無料です。\n";
		$honbun .= "--------------------\n";
		$honbun .= "\n";
		$honbun .= "代金は以下の口座にお振込ください。\n";
		$honbun .= "ろくまる銀行 やさい支店 普通口座 1234567\n";
		$honbun .= "入金確認が取れ次第、梱包、発送させていただきます。\n";
		$honbun .= "\n";

		if ($chumon == 'chumontouroku') {
			$honbun .= "会員登録が完了いたしました。\n";
			$honbun .= "次回からメールアドレスとパスワードでログインしてください。\n";
			$honbun .= "ご注文が簡単にできるようになります。\n";
			$honbun .= "\n";
		}

		$honbun .= "□□□□□□□□□□□□□□\n";
		$honbun .= " ～安心野菜のろくまる農園～\n";
		$honbun .= "\n";
		$honbun .= "○○県六丸郡六丸村123-4\n";
		$honbun .= "電話 090-6060-xxxx\n";
		$honbun .= "メール info@rokumarunouen.co.jp\n";
		$honbun .= "□□□□□□□□□□□□□□\n";

		print '<br />';
		print nl2br($honbun);
		// MEMO: No need to send email
		// FIXME: メールヘッダーインジェクション 改行チェックなしのため
		// $title = 'ご注文ありがとうございます。';
		// $header = 'From:info@rokumarunouen.co.jp';
		// $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
		// mb_language('Japanese');
		// mb_internal_encoding('UTF-8');
		// mb_send_mail($email, $title, $honbun, $header);

		// $title = 'お客様からご注文がありました。';
		// $header = 'From:' . $email;
		// $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
		// mb_language('Japanese');
		// mb_internal_encoding('UTF-8');
		// mb_send_mail('info@rokumarunouen.co.jp', $title, $honbun, $header);
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
