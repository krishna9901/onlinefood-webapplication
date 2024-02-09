<!DOCTYPE html>
<html>
    <head>
        <title>Food Ordering System</title>
        <link type="text/css" rel="stylesheet" href="static/css/style.css"/>
        <link type="text/css" rel="stylesheet" href="static/css/kube.css"/>
    </head>
    <body><br/><br/><br/><br/>
        <row centered>
        <column cols="6">
        <?php
			session_start();
			include "require/db.php";
			echo "<div class='forms'>
					<fieldset class='alert alert-success'>
					<legend class='fat'>";
            if(isset($_SESSION['food__quantity']) && !isset($_POST['fname']) && !isset($_POST['isCata'])){
				if(isset($_SESSION['order_id'])){
/**To edit an order, first need to DELETE previous order*/
					$sql_del="DELETE FROM orders WHERE order_id={$_SESSION['order_id']}";
					$mysql->query($sql_del);
					unset($_SESSION['order_id']);
				}
/**save new order info into array, create new order and INSERT each food item*/
				$food__quantity=$_SESSION['food__quantity'];
	            $cus_id = $_SESSION['cus_id'];	
				unset($_SESSION['cus_id']);
				unset($_SESSION['food__quantity']);
				session_destroy();
				if(isset($_POST['time']) && !empty($_POST['time'])){
					$time = "'{$_POST['time']}'";	
				}else{
					$time = 'curtime()';
				}
                $itemnum = count($food__quantity);
                $sql_inserto = "INSERT orders(cus_id,date,time) VALUE($cus_id,curdate(),$time)";
                $mysql->query($sql_inserto);
				$order_id = mysql_insert_id();
                for ($itemcount=0;$itemcount<$itemnum;$itemcount++) {
					$food_id = array_keys($food__quantity)[$itemcount];
					$quantity = $food__quantity[$food_id];
                    $sql_insertf = "INSERT order_food(order_id,food_id,quantity) VALUE(".$order_id.",".$food_id.",".$quantity.")";
                    $mysql->query($sql_insertf);
                }
                echo "Order has been created!";  
                header("refresh:3;url='index.php?page=current_orders'");		
            }else if(isset($_POST['fname'])){
/**chaeck info and create a new customer*/	
				$fname = preg_replace("/\s/","",(string)$_POST['fname']);
				if(!empty($fname)){
					$lname = preg_replace("/\s/","",(string)$_POST['lname']);
					$tel = preg_replace("/\s/","",(string)$_POST['tel']);
					if(isset($_POST['cusid'])){
						$cusid = $_POST['cusid'];
						$sql_editcus = "UPDATE customer_info SET firstname = '$fname',lastname = '$lname',tel = '$tel' WHERE cus_id = '$cusid'";
						$mysql->query($sql_editcus);
						echo 'Updated Customer Successfully';
					}else{
						$sql_newcus= "INSERT customer_info (firstname,lastname,tel) VALUE ('$fname','$lname','$tel')";
						$mysql->query($sql_newcus);
						echo "Customer details added!";
					}
					header("refresh:3;url='index.php?page=customer&action=info'");
				}else{
					echo "<script> history.back(-1)</script>";
				}
            }else if(isset($_POST['isCata'])){
/**create or update food item*/
				$foodname = preg_replace("/\s/","",(string)$_POST['foodName']);
				$foodPrice = preg_replace("/\s/","",(string)$_POST['price']);
				if(!empty($foodname)){
					if($_POST['isCata']=='food'){
						$foodCata = $_POST['foodCata'];
						if(isset($_POST['origId'])){
							$sql_newfood = "UPDATE food_catalogue SET cata_name = '$foodname',Price = $foodPrice,catalog_id = $foodCata WHERE food_id = {$_POST['origId']}";
							echo "Food Information Has Been Updated!";
						}else{
							$sql_newfood = "INSERT food_catalogue (cata_name,Price,catalog_id) VALUES ('$foodname',$foodPrice,$foodCata)";
							echo "Added New Food Successfully";
						}
						$mysql->query($sql_newfood);
						header("refresh:3;url='index.php?page=food&action=detail'");
					}else if($_POST['isCata']=='cata'){
						if(isset($_POST['origId'])){
							$sql_newcata = "UPDATE food_catalogue SET cata_name = '$foodname' WHERE catalog_id = {$_POST['origId']}";
							echo "Food Category Has Been Updated!";
						}else{
							$cataId = $_POST['cataId'];
							$sql_newcata = "INSERT food_catalogue (cata_name,catalog_id) VALUES ('$foodname',$cataId)";
							echo "New Food Category Has Been Added!";
						}
						$mysql->query($sql_newcata);
						header("refresh:3;url='index.php?page=food&action=cata'");
					}
				}else{
					echo "Wrong!<script>history.go(-1);</script>";
				}
			}
			echo "		</legend>
						<p>Redirecting you back to page in 2 seconds...</p>
						<a href='index.php'><button class='btn btn-sm btn-primary'>Go Back</button></a>
					</fieldset>
				</div>";
        ?>
        </column>
        </row>
    </body>
</html>