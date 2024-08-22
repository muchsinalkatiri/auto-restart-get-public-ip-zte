<?php

require "ZteF609.php";


$zteF609  = new ZteApi('192.168.2.1', 'user', 'user', true);
$login = $zteF609->login();
$info = $zteF609->status->NetworkInterface->wanConnection();
// echo $info->ip;
$ip_depan = explode('.', $info->ip)[0];

if ($ip_depan == '36' || $ip_depan == '180' || $ip_depan == '125') {
	$ip_lama = json_decode(file_get_contents("/var/www/html/auto_restart/ip.json"))->ip;
	$new_ip = ["ip" => $info->ip];
	file_put_contents("/var/www/html/auto_restart/ip.json", json_encode($new_ip));

	if ($ip_lama != $info->ip) {
		file_get_contents("http://sma.tazkia.iibs@gmail.com:tazkiaiibs@dynupdate.no-ip.com/nic/update?hostname=totet.ddns.net&myip={$info->ip}");
	}
	echo '[' . date('d-m-Y h:i:s A') . "]: ";
	echo "sdh dpt ip public = " . $info->ip . PHP_EOL;
} else {
	echo '[' . date('d-m-Y h:i:s A') . "]: ";
	echo "belum dpt ip public = " . $info->ip . PHP_EOL;

	$zteF609  = new ZteApi('192.168.2.1', 'user', 'user', true);
	$zteF609->login();
	$zteF609->reboot();
}

@unlink("cookie.txt");
