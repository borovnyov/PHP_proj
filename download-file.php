<?php
   $path = "base_out.csv";
   
   $f_source = fopen("base.csv", "r");
   $f_dest   = fopen("base_out.csv", "w");
   
   fputs($f_dest, "Дата и время;Время модуля, с;Температура, *С;Влажность, %;Давление, кПа;Заряд батареи, %;Базовая станция;Уровень сигнала,1/32\r\n");
   
   while (!feof($f_source))
   {
	if ( ($L = fgetcsv($f_source, 100, ";")) == FALSE )
		break;

	if ($L == NULL)
		break;

	$gl_time	= $L[0];
	$m_time		= $L[1];
	$temp		= $L[2];
	$hum		= $L[3];
	$pressure	= $L[4];
	$batt_life	= $L[5];
	$CREG		= $L[6];
	$CSQ		= $L[7];

	fputs($f_dest, $gl_time);
	fputs($f_dest, ";");
	fputs($f_dest, $m_time);
	fputs($f_dest, ";");

	if ($temp == 0xFFFF)
		fputs($f_dest, "-");
	else
	{
		$temp2 = number_format((double)($temp >> 8)/2 + (double)($temp & 0x00FF)/512 - 41, 2, ',', '');
		fputs($f_dest, $temp2);
	}
	fputs($f_dest, ";");

	if ($hum == 0xFFFF)
		fputs($f_dest, "-");
	else
	{
		$hum2 = (double)$hum/16*5.02/4096;
		$hum2 = number_format(($hum2 - 0.958)/0.0307, 1, ',', '');
		fputs($f_dest, $hum2);
	}
	fputs($f_dest, ";");

	if ($pressure == 0xFFFF)
		fputs($f_dest, "-");
	else
	{
		$pressure2 = number_format(((double)$pressure*5.01/(1 << 16) - 0.204)*1000/45.9, 2, ',', '');
		fputs($f_dest, $pressure2);
	}
	fputs($f_dest, ";");
			
	fputs($f_dest, $batt_life);
	fputs($f_dest, ";0x");
	fputs($f_dest, $CREG);

	fputs($f_dest, ";");
	fputs($f_dest, $CSQ);

	fputs($f_dest, "\r\n");
   }
   
   fclose($f_source);
   fclose($f_dest);
   
   if(!file_exists($path))
   {
		echo "File not found";
   }
   else
   {
       $size = filesize($path);
	   header("Content-Type: application/csv"); //vmesto xls mogeh pusat' drygou format, naprimer, - msword
	   header("Content-Length: $size");
	   header("Content-Disposition: Attechment; FileName=\"$path\"");
	   readfile($path);
   }
?>