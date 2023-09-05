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

	$name = $post['name'];
	$email = $post['email'];
	$zipcode1 = $post['zipcode1'];
	$zipcode2 = $post['zipcode2'];
	$address = $post['address'];
	$tel = $post['tel'];
	$order = $post['order'];
	$pass = $post['pass'];
	$pass2 = $post['pass2'];
	$sex = $post['sex'];
	$birth = $post['birth'];

	$is_ok = true;

	if ($name == '') {
		print 'お名前が入力されていません。<br /><br />';
		$is_ok = false;
	} else {
		print 'お名前<br />';
		print $name;
		print '<br /><br />';
	}

	if (preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/', $email) == 0) {
		print 'メールアドレスを正確に入力してください。<br /><br />';
		$is_ok = false;
	} else {
		print 'メールアドレス<br />';
		print $email;
		print '<br /><br />';
	}

	if (preg_match('/\A[0-9]+\z/', $zipcode1) == 0) {
		print '郵便番号は半角数字で入力してください。<br /><br />';
		$is_ok = false;
	} else {
		print '郵便番号<br />';
		print $zipcode1;
		print '-';
		print $zipcode2;
		print '<br /><br />';
	}

	if (preg_match('/\A[0-9]+\z/', $zipcode2) == 0) {
		print '郵便番号は半角数字で入力してください。<br /><br />';
		$is_ok = false;
	}

	if ($address == '') {
		print '住所が入力されていません。<br /><br />';
		$is_ok = false;
	} else {
		print '住所<br />';
		print $address;
		print '<br /><br />';
	}

	if (preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $tel) == 0) {
		print '電話番号を正確に入力してください。<br /><br />';
		$is_ok = false;
	} else {
		print '電話番号<br />';
		print $tel;
		print '<br /><br />';
	}


	if ($order == 'order_register') {
		if ($pass == '') {
			print 'パスワードが入力されていません。<br /><br />';
			$is_ok = false;
		}

		if ($pass != $pass2) {
			print 'パスワードが一致しません。<br /><br />';
			$is_ok = false;
		}

		print '性別<br />';
		if ($sex == 'dan') {
			print '男性';
		} else {
			print '女性';
		}
		print '<br /><br />';

		print '生まれ年<br />';
		print $birth;
		print '年代';
		print '<br /><br />';
	}

	if ($is_ok == true) {
		print '<form method="post" action="shop_form_done.php">';
		print '<input type="hidden" name="name" value="' . $name . '">';
		print '<input type="hidden" name="email" value="' . $email . '">';
		print '<input type="hidden" name="zipcode1" value="' . $zipcode1 . '">';
		print '<input type="hidden" name="zipcode2" value="' . $zipcode2 . '">';
		print '<input type="hidden" name="address" value="' . $address . '">';
		print '<input type="hidden" name="tel" value="' . $tel . '">';
		print '<input type="hidden" name="order" value="' . $order . '">';
		print '<input type="hidden" name="pass" value="' . $pass . '">';
		print '<input type="hidden" name="sex" value="' . $sex . '">';
		print '<input type="hidden" name="birth" value="' . $birth . '">';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '<input type="submit" value="OK"><br />';
		print '</form>';
	} else {
		print '<form>';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '</form>';
	}

	?>

</body>

</html>
