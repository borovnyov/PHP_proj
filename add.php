<?php

if (!empty($_GET['time'])) // параметр отсутствует?
{ // параметры есть -> работаем с модемом и будем кратки:)
	($f = fopen("base.csv", "a+")
		or die("ERROR 1"));
	if (fseek($f, 0, SEEK_END) != 0)
		die("ERROR 2");

	$bel_time = time();
	$tm = date("d.m.Y")." ".date("H:i:s");
	if (!fputs($f, "$tm;".$_GET['time'].";".$_GET['temp'].";".$_GET['hum'].";".$_GET['pressure']."\r\n"))
		die("ERROR 3");

	fclose($f);
	echo "COMPLETE";
}
else
{
	die("ERROR 0");
}

?>
