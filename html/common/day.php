<?php
function era_name($year)
{
	if (1868 <= $year && $year <= 1911) {
		$era = '明治';
	}
	if (1912 <= $year && $year <= 1925) {
		$era = '大正';
	}
	if (1926 <= $year && $year <= 1988) {
		$era = '昭和';
	}
	if (1989 <= $year) {
		$era = '平成';
	}
	return ($era);
}

function pulldown_year()
{
	print '<select name="year">';
	for ($year = 2023; $year <= 2026; $year++) {
		print '<option value="' . $year . '">' . $year . '</option>';
	}
	print '</select>';
}

function pulldown_month()
{
	print '<select name="month">';
	for ($month = 1; $month <= 12; $month++) {
		print '<option value="' . $month . '">' . $month . '</option>';
	}
	print '</select>';
}

function pulldown_day()
{
	print '<select name="day">';
	for ($date = 1; $date <= 31; $date++) {
		print '<option value="' . $date . '">' . $date . '</option>';
	}
	print '</select>';
}
