<?php

function sanitize_all($list)
{
	foreach ($list as $key => $value) {
		$after[$key] = sanitize($value);
	}
	return $after;
}

function sanitize($string)
{
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
