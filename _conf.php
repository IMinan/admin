<?php
$mysqli = mysqli_connect('localhost', 'root', '', 'rulmansoft');
mysqli_set_charset($mysqli, "utf8");

// fonksiyonlarda mysqli_query kullanmak icin connect() adında bir fonksiyon olusturuyoruz.
function mysqli()
{
	global $mysqli;
	return $mysqli;
}


// default
$site_url = 'http://localhost/sablon/night_blue/admin';
$theme_url = 'http://localhost/sablon/night_blue';
?>
