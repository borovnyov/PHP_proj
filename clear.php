<?php

($f = fopen("base.csv", "w")
		or die("Error while clearing file!"));
fclose($f);

Header("Location: index.php");

?>