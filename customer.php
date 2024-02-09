<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<?php
if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action='info';
}
if($action == 'new'){
/**query customers ID and show new customer form*/
$sql_cusinfo = "SELECT cus_id from customer_info order by cus_id DESC;";
	$result = $mysql->query($sql_cusinfo); 
	$row = $mysql->fetch($result);
	$newnum = $row[0]+1;		
	echo "
	<form action='submit.php' method='post'>
	<table>
		<th colspan='4' class='text-center'><h3>Add New Customer</h3></th>
		<tr>
			<td class='bold' class='width-2'>Customer Number</td>
			<td class='width-2'>
				<input type='text' id='cusid' name='cusid' value='$newnum' disabled='disabled'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>First Name<span class='req'> *</span></td>
			<td>
				<input type='text' maxlength='10' name='fname' required/>
			</td>
			<td class='bold'>Last Name</td>
			<td>
				<input type='text' maxlength='10' name='lname'/>
			</td>
		</tr>
		<tr>
			<td class='bold'>Phone Number</td>
			<td>
				<input type='tel' maxlength='20' name='tel'/>
			</td>
		</tr>
	</table>
	<div class='text-right'>
		<button class='submit' type='primary' name='submit'>Submit</button>
	</div>
	</form>";	
	if(isset($_POST['origCusEdit'])){
			$origCus = explode(',',$_POST['origCusEdit']);
			echo "<script>
					var cusid = document.getElementById('cusid');
					cusid.disabled = false;
					cusid.value = {$origCus[0]};
					cusid.onchange = function(){
						cusid.value = {$origCus[0]};
					};
					document.getElementsByName('fname')[0].value = '{$origCus[1]}';
					document.getElementsByName('lname')[0].value = '{$origCus[2]}';
					document.getElementsByName('tel')[0].value = '{$origCus[3]}';
				</script>";
	}
}else if($action == 'info'){
/**show all customer's information*/
		$sql_cusinfo = "SELECT * FROM customer_info;";
		$result = $mysql->query($sql_cusinfo);
		echo "<form action='require/index.php?page=customer_info' method='post'>
				<table class ='table-stripped table-hover'>
					<th colspan='10'>Customer Information:</th>
					<tr>
						<td class='bold'>Customer ID</td>
						<td class='bold'>First Name</td>
						<td class='bold'>Last Nmae</td>
						<td class='bold'>Phone Number</td>
						<td class='bold'>Credit</td>
						<td style='width:1%;'></td>
						<td style='width:1%;'></td>
					</tr>";
/**count how much money does each customer paid*/
		while($row = $mysql->fetch($result)) {
		    echo "<tr>";
				$sql_sum="select sum(f.price * quantity) as credit from order_food inner join food_catalogue as f ON order_food.food_id = f.food_id where order_id in (select order_id from orders where cus_id = {$row['cus_id']})";
				$res_cre=$mysql->query($sql_sum);
				$row_cre=$mysql->fetch($res_cre);
			echo "	<td>".$row['cus_id']."</td>
					<td>".$row['FirstName']."</td>
					<td>".$row['LastName']."</td>
					<td>".$row['tel']."</td>
					<td>&#36;".$row_cre['credit']."</td>
					<td><i class='fa fa-pencil' onclick=\"firm('Do you want to Edit this Customer?','editCus{$row['cus_id']}')\"></i></td>
					<td><kbd class='fa fa-trash' onclick=\"firm('Do you want to Delete this Customer?','deleteCus{$row['cus_id']}')\"></kbd></td>
				</tr>";
			echo "<form action='index.php?page=customer&action=new' method='post' id='editCus{$row['cus_id']}'>
					<input type='hidden' name='origCusEdit' value='{$row['cus_id']},{$row['FirstName']},{$row['LastName']},{$row['tel']}'/>
				</form>
				<form action='' method='post' id='deleteCus{$row['cus_id']}'>
					<input type='hidden' name='origCusDel' value='{$row['cus_id']}'/>
				</form>";
	    }
		echo "</table>";
/**Delete Customer function*/
		if(isset($_POST['origCusDel'])){
			$sql_delCus = "DELETE FROM customer_info WHERE cus_id = {$_POST['origCusDel']}";
			echo $sql_delCus;
			$mysql->query($sql_delCus);
			echo "<script>window.location.href='index.php?page=customer&action=info';</script>";
		}
}	
?>
<script>
	function firm(text,id){  
		if(confirm(text)){
			document.getElementById(id).submit();
		}else{
			return false;
		}
	}
</script>