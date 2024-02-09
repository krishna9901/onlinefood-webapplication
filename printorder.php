<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$file = fopen("receipts/id.txt","w") or die ("asdsd");
	fwrite($file, $id);
	fclose($file);
	shell_exec('php receipt.php > receipts/receipt.txt');
	shell_exec('lpr -o raw -H localhost -P POS58 receipts/receipt.txt');

} else {
	echo "no ID available";
}

?>