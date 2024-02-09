<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

<?php

error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
date_default_timezone_set('PRC'); 

// Ensure session is started before any output
session_start();
	// session_start();
	// error_reporting(E_ALL^E_NOTICE^E_WARNING^E_DEPRECATED);
	// date_default_timezone_set('PRC'); 
/**save food catalogue and customers full name into arrays*/
	$sql_fcata = "SELECT catalog_id,cata_name FROM food_catalogue WHERE price IS NULL ORDER BY catalog_id";
	$result_fcata = $mysql->query($sql_fcata);
	$sql_cusinfo = "SELECT cus_id,CONCAT(firstname,' ',lastname) FROM customer_info ORDER BY firstname, lastname";
	$result_cusinfo = $mysql->query($sql_cusinfo);
?>
<script>
/**function of add,minus,show,hide and check input number*/
	function a(fid){ 
		var x=document.getElementById(fid).value; 
		if(x.length==0){ x=0; }
		if(x < 999){
			document.getElementById(fid).value = parseInt(x)+1;
		}
	}
	function m(fid){ 
		var x=document.getElementById(fid).value;
		if(x > 0){
			document.getElementById(fid).value = parseInt(x)-1;
		}
	}
	function vis(fid){
		document.getElementById('l'+fid).style.visibility = "visible";
		document.getElementById('r'+fid).style.visibility = "visible";
	}
	function hide(fid){
		document.getElementById('l'+fid).style.visibility = "hidden";
		document.getElementById('r'+fid).style.visibility = "hidden";
	}
	function check(fid){
		var q = document.getElementById(fid).value;
		if (q <= 0 || q > 999 || q != parseInt(q)){
			document.getElementById(fid).value = '';
			document.getElementById(fid).style.backgroundColor = "white";
		}else{
			document.getElementById(fid).style.backgroundColor = "rgba(10, 135, 84, 0.13)";
		}
	}
/**print time and refresh in every 1s*/		
	function printTime(){
		var d = new Date();
		var year = d.getFullYear();
		var day = d.getDate();
		var month = d.getMonth()+1;
		var hours = d.getHours();
		var mins = d.getMinutes();
		var secs = d.getSeconds();
		document.getElementById('time').innerHTML=day+"/"+month+"/"+year+"&nbsp;"+hours+":"+mins+":"+secs;
	}
	setInterval(printTime,1000);
/**print order and reset order function*/	
	function printdiv(printpage) { 
		var headstr = "<html><head><title></title></head><body>"; 
		var footstr = "</body>"; 
		var newstr = document.all.item(printpage).innerHTML; 
		var oldstr = document.body.innerHTML; 
			document.body.innerHTML = headstr+newstr+footstr; 
			window.print(); 
			document.body.innerHTML = oldstr; 
			return false; 
	} 
	function reset() {  
		if (confirm("Do you want to reset?")) {  
				window.location.href='index.php?page=create_order';
		}  
	}
</script>

		<form id='order_table' action='index.php?page=create_order' method ='post'>
			<div class='big'><b>Customer:</b>
				<select name='cus_id' id='cus' >
					<option value='0'>Please Select...</option>
				<?php 
					while($row = $mysql->fetch($result_cusinfo)) {
						echo "<option value=$row[0]>$row[1]</option>";
					}	
				?>
				</select>
				<button id='createbtn' class="btn btn-warning" style="border-radius:0%" type=''>Create Order</button>
			</div>
			<div class='create_order'>
				<table class ='table-stripped'>
	<?php
/**output all the food items of each type of food*/
		while($row_fcata = $mysql->fetch($result_fcata)) {
			$cata_id = $row_fcata['catalog_id']; 
			/*only food info, no food catalogue*/
	        $sql_finfo = "select s.food_id,s.cata_name as food_name,s.price,s.catalog_id from food_catalogue as s join food_catalogue as p where p.food_id = s.catalog_id and s.price IS NOT NULL and s.catalog_id = $cata_id"; 
	        $result_finfo = $mysql->query($sql_finfo); 
            echo "<th colspan='5' id=".$row_fcata['cata_name'].">".$row_fcata['cata_name']."</th>
					<tr>
						<td class='text-center'><b>ID</b></td>
						<td class='text-center'><b>Food Name</b></td>	
						<td class='text-center'><b>Price</b></td>
						<td class='text-center'><b>Quantity</b></td>
					</tr>";
            while($row_finfo = $mysql->fetch($result_finfo)) {
                echo "<tr>
						<td class='text-center'>".$row_finfo['food_id']."</td>
						<td class='text-center'>".$row_finfo['food_name']." </td>
						<td class='text-center'>&#8377; ".$row_finfo['price']." </td>
						<td class='text-center' onmousemove='vis({$row_finfo['food_id']})' onmouseout='hide({$row_finfo['food_id']});check({$row_finfo['food_id']})'>
							<button id='l{$row_finfo['food_id']}' class='bnum' type='button' onclick='m({$row_finfo['food_id']})' ><b><i class='fa fa-minus-circle' style='color:#C9302D;'></i></b></button>
							<input type='number' id='{$row_finfo['food_id']}' name='odfood[{$row_finfo['food_id']}]' min = '0' max = '999'/>
							<button id='r{$row_finfo['food_id']}' class='bnum' type='button' onclick='a({$row_finfo['food_id']})' ><b><i class='fa fa-plus-circle' style='color:green;'></i></b></button>
						</td>
					</tr>";
            }
		}		
	?>	
				</table>
			</div>
		</form>
<div id='create_page'>
	<?php 
/**IT'S THE EDIT FUNCTION. When 'order_block.php' post this page,it can get the order data and write on the 'create order' input form;
session['times'] is a counter to make sure session['order_id'] directly comes from 'order_block.php', otherwise, if user refersh,
 go to other page or cancel order while editing order, the session['order_id'] is still here.*/	
		if(isset($_POST['fd_quan'])){
			$fd_quan=$_POST['fd_quan'];
			$od_cus=$_POST['od_cus'];
			$order_id=array_keys($od_cus)[0];
			$_SESSION['order_id']=$order_id;
			$cus_id=$od_cus[$order_id];
			echo "<script>document.getElementById('cus').value=$cus_id</script>";
			for($i=0;$i<count($fd_quan);$i++){
				$food_id=array_keys($fd_quan)[$i];
				$food_num=$fd_quan[$food_id];				
				echo "<script>document.getElementById($food_id).value=$food_num</script>";
			}
			unset($_POST['fd_quan']);
			$_SESSION['times']=0;
		}else{
			if(isset($_SESSION['times'])){
				$_SESSION['times']++;
			}
		}
		if(isset($_SESSION['times'])){
			if($_SESSION['times']>1){
				unset($_SESSION['order_id']);
			}	
		}						
/**save food items detail information into array*/
        $sql_foodinfo = "SELECT food_id,cata_name AS food_name,price FROM food_catalogue WHERE price IS NOT NULL";
        $result = $mysql->query($sql_foodinfo);
        $food_cata_info = array();
        echo "<table class ='table-bordered'>";  
        while($row = $mysql->fetch($result)) {
	        $food_cata_info['name'][$row['food_id']] = $row['food_name'];
	        $food_cata_info['price'][$row['food_id']] = $row['price'];
		}
/**Result part(right part) of create new order*/
/**if choose a custer,search full name and print it,or just show unknown*/
		if(isset($_POST['cus_id'])){
			if(!empty($_POST['cus_id'])){
				$cus_id = (int)$_POST['cus_id'];
				$sql_cusinfo = "SELECT firstname,lastname,tel from customer_info where cus_id = $cus_id;";
				$result_cus = $mysql->query($sql_cusinfo);  
				$row_cus = $mysql->fetch($result_cus);
				$cusname=$row_cus[0]."&nbsp".$row_cus[1];
			}else{
				$cus_id = '0';
				$cusname='Unknown';
			}
		}else{
			$cusname='New Order';
		}
		$datetime = date('d/m/y h:i:s',time());
		echo "<tr class='bold'>
				<td style='font-size: 26px;border-right:0px;' >".$cusname."&nbsp</td>
				<td colspan='2' style='border-left:0;text-align:right;' id='time' onclick='inputTime()'>$datetime</td>
				<td colspan='2' style='border-left:0;text-align:right;display:none;' id='timeNew'>
					<form action='submit.php' method='post' id='newOrder'>
						<input type='time' name='time'/>
					</form>
				</td>
			</tr>
            <tr class='fat'>
				<td>Food Name</td><td>Price</td><td>Quantity</td>
			</tr>"; 
		echo "<script>
				function inputTime(){
					document.getElementById('time').style.display='none';
					document.getElementById('timeNew').style.display='inline';
					
				}
			</script>";
/**Save all the food id and quantity in an Array, and filter the empty items,if the array is still not empty, 
print the food items and total price in a table, and hide the 'Create New' button*/
		$totalp = 0;
		if(isset($_POST['odfood'])){
			$food__quantity = array_filter($_POST['odfood']);
			if(!empty($food__quantity)){
				for($i=0;$i < count($food__quantity);$i++){
					$f_id = array_keys($food__quantity)[$i];
					$f_quantity = $food__quantity[$f_id];
					if(!empty($f_quantity)){
						echo "<tr>
								<td><b>".$food_cata_info['name'][$f_id]."</b></td>
								<td>&#8377; ".$food_cata_info['price'][$f_id]."</td>
								<td>".$f_quantity."</td>
							</tr>";
						$totalp += $food_cata_info['price'][$f_id] * $f_quantity;
					}
				}	
			}
			echo "<tr>
					<td colspan='2' class='fat'>Total Price</td>
					<td colspan='2' class='text-centered'>&#8377; &nbsp".$totalp."</td>
				 </tr>
				 </table>
			<script>document.getElementById('createbtn').style.display= 'none'</script>";
		?>
			<nav id='submitbtn'>
				<ul>
					
					<li>
						<button onclick="printdiv('create_page')">Print</button>
					</li>
					
					<li>
						<button class="btn btn-warning" style="border-radius:0%" id='modord' onclick ="history.go(-1)">Make Changes</button>
					</li>

					<li>
						<button id='subord' type="primary" onclick="document.getElementById('newOrder').submit();">Submit Order</button>
					</li>
					
					<li>
						<button class="btn btn-danger" style="border-radius:0%" onclick ="reset()">Reset</button>
					</li>
				</ul>
			</nav>
		<?php
/**if the total price is greater than 0, save order info array and customerID in Session, otherwise disable the Submit button*/		
			if($totalp > 0){
				$_SESSION['food__quantity'] = $food__quantity;
				$_SESSION['cus_id']= $cus_id;
			}else{
				echo "<script>document.getElementById('subord').disabled='true';</script>";
			}
/**if Session['order_id'] is isset, which means user is Editing order. The Modify order button will be disabled, because it may cause some problem*/
			if(isset($_SESSION['order_id'])){
				echo "<script>document.getElementById('modord').disabled='true';</script>";
			}
        }else{
			echo "</table>";
		}
        ?>
</div>




