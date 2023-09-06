<?php

try {

	require_once('../common/sanitize.php');

	$post = sanitize_all($_POST);
	$member_email = $post['email'];
	$member_pass = $post['pass'];

	$member_pass = md5($member_pass);

	require_once('../common/database.php');
	$dbh = connectToDatabase();

	$sql = 'SELECT code,name FROM member WHERE email=? AND password=?';
	$data[] = $member_email;
	$data[] = $member_pass;
	$stmt = executeSqlWithData($sql, $dbh, $data);

	$dbh = null;

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($rec == false) {
		print 'メールアドレスかパスワードが間違っています。<br />';
		print '<a href="member_login.html"> 戻る</a>';
	} else {
		session_start();
		$_SESSION['member_login'] = 1;
		$_SESSION['member_code'] = $rec['code'];
		$_SESSION['member_name'] = $rec['name'];
		header('Location:shop_list.php');
		exit();
	}
} catch (Exception $e) {
	print 'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}
