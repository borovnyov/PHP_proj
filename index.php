<?php

	($f = fopen("base.csv", "a+")
		or die("Error while openning file!"));
	fseek($f, 0, SEEK_SET);	
	echo "	<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
		<html>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\" />
		<body>
		<title>BSsoft project. GSM-module</title>";
	
	echo "File opened.<br>";
	echo "Printing file...<br><br>";

	echo '
		<table width="100%" border="0">
		<tr>
			<th width="10%" scope="col"><div align="left">Дата и время</div></th>
			<th width="10%" scope="col"><div align="left">Время модуля, с</div></th>
			<th width="10%" scope="col"><div align="left">Темп., *С</div></th>
			<th width="10%" scope="col"><div align="left">Влажн., %</div></th>
			<th width="10%" scope="col"><div align="left">Давл., кПа</div></th>
			
		</tr>
	';

	$me = 0;
	while (!feof($f))
	{
		if ($me==0)
			$mytr='"#BFCFFF"';
		else
			$mytr='"#CFFFFF"';
		$me = !$me;

		if ( ($L = fgetcsv($f, 100, ";")) == FALSE )
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

		echo "
			<tr bgcolor=$mytr>
			<td>$gl_time</td>
			<td>$m_time</td>
		";
		if ($temp == 0xFFFF)
			echo "<td>-</td>";
		else
		{
			//$temp_h = $temp >> 8;
			//$temp_l = $temp & 0xFF;
			//$temp2 = round((double)($temp >> 8)/2 + (double)($temp & 0x00FF)/512 - 41, 2);
			echo "<td>$temp</td>";
		}

		if ($hum == 0xFFFF)
			echo "<td>-</td>";
		else
		{
			//$hum2 = (double)$hum/16*5.02/4096;
			//$hum2 = round(($hum2 - 0.958)/0.0307, 1);
			echo "<td>$hum</td>";
		}

		if ($pressure == 0xFFFF)
			echo "<td>-</td>";
		else
		{
			//$pressure2 = round(((double)$pressure*5.01/(1 << 16) - 0.204)*1000/45.9, 2);
			echo "<td>$pressure</td>";
		}
		
		/*echo "
			
			<td>$batt_life</td>
			<td>$CREG</td>
			<td>$CSQ</td>
 			</tr>
 		";*/
	}

	echo "</table>";
	
	echo "<br>Finished!<br>";
	fclose($f);
	echo "File closed. Bye-bye!";
	echo "
		<br>
		<input type=\"button\" value=\"clear all\" onclick=\"location.href='clear.php'\" />
		<input type=\"button\" value=\"download as CSV\" onclick=\"location.href='download-file.php'\" />
		</body>
		</html>";

?>
