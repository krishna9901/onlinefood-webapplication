<?php

require __DIR__ . '/printer/autoload.php';
require __DIR__ . '/require/db.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
/* Fill in your own connector here */
$connector = new FilePrintConnector("php://stdout");

/* Start the printer */
$printer = new Printer($connector);

/* Open file to write the ID */
$file = fopen("receipts/id.txt","r") or die ("asdsd");
$id = fgets($file);
fclose($file);

// Select customer and order info
$sql_orders = "select Order_id,o.cus_id,firstname as fname,lastname as lname,Date,Time,payed from orders as o LEFT JOIN customer_info as c ON o.cus_id = c.cus_id WHERE Order_id = $id";
$result = $mysql->query($sql_orders);
$row_order = $mysql->fetch($result);

if(empty($row_order['lname']) && empty($row_order['fname'])){
	$cusname='Unknown';
} else {
	$cusname=$row_order['fname']." ".$row_order['lname'];
}

/* Print customer and order ID */
$printer -> setJustification(Printer::JUSTIFY_CENTER);
$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("$cusname\n");
$printer -> selectPrintMode();
$printer -> text("Order# $id\n");
$printer -> feed(2);

// Select ordered items
$sql_item_detail = "SELECT Item_id,F.order_id,cus.lastname as lname,Cs.cata_name as Food_name,Cp.Cata_name,Quantity,Cs.price as Single_Price,(Cs.price*quantity)as Total_Price,F.food_id from order_food as F JOIN orders as O on F.order_id = O.order_id JOIN food_catalogue as Cs ON F.food_id = Cs.food_id JOIN food_catalogue as Cp ON Cp.food_id = Cs.catalog_id LEFT JOIN customer_info as cus ON cus.cus_id = O.cus_id WHERE F.order_id= {$id}";
$result_item_detail = $mysql->query($sql_item_detail);

$sum = '';

while($row_item_detail = $mysql->fetch($result_item_detail)) {
	$food_name = $row_item_detail['Food_name'];
	$qualtity = $row_item_detail['Quantity'];
	$total = $row_item_detail['Total_Price'];
	
	$sum = $sum + $total;
	
	$printer -> text("$food_name ($qualtity) - $total USD\n");
}

$printer -> feed(2);

$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
$printer -> text("$sum USD");
$printer -> selectPrintMode();
$printer -> feed(4);
$printer -> close();

/* A wrapper to do organise item names & prices into columns */
class item {
        private $name;
        private $price;
        private $dollarSign;
        public function __construct($name = '', $price = '', $dollarSign = false) {
                $this -> name = $name;
                $this -> price = $price;
                $this -> dollarSign = $dollarSign;
        }
        public function __toString() {
                $rightCols = 20;
                $leftCols = 38;
                if($this -> dollarSign) {
                        $leftCols = $leftCols / 2 - $rightCols / 2;
                }
                $left = str_pad($this -> name, $leftCols) ;
                $sign = ($this -> dollarSign ? '$ ' : '');
                $right = str_pad($sign . $this -> price, $rightCols, ' ', STR_PAD_LEFT);
                return "$left$right\n";
        }
}
?>