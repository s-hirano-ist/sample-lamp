<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login']) == false) {
	print 'ログインされていません。<br />';
	print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
	exit();
}

if (isset($_POST['display']) == true) {
	if (isset($_POST['product_code']) == false) {
		header('Location:pro_ng.php');
		exit();
	}
	$pro_code = $_POST['product_code'];
	header('Location:pro_display.php?product_code=' . $pro_code);
	exit();
}
if (isset($_POST['add']) == true) {
	header('Location:pro_add.php');
	exit();
}

if (isset($_POST['edit']) == true) {
	if (isset($_POST['product_code']) == false) {
		header('Location:pro_ng.php');
		exit();
	}
	$pro_code = $_POST['product_code'];
	header('Location:pro_edit.php?product_code=' . $pro_code);
	exit();
}

if (isset($_POST['delete']) == true) {
	if (isset($_POST['product_code']) == false) {
		header('Location:pro_ng.php');
		exit();
	}
	$pro_code = $_POST['product_code'];
	header('Location:pro_delete.php?product_code=' . $pro_code);
	exit();
}
