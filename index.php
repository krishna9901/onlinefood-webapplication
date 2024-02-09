<?php
require("require/db.php");
if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 'default';
}
include("require/header.php");
if ($page == 'default') {
	include("orders_block.php");
} else if ($page == 'food') {
	include("food.php");
}else if ($page == 'customer') {
	include("customer.php");
}else if ($page == 'current_orders') {
	include("orders_block.php");
}else if ($page == 'create_order') {
	include("create_order.php");
}
include("require/footer.php");

?>