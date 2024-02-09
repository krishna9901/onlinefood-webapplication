<html>
    <head>
        <title>Food Ordering System</title>
		<link type="text/css" rel="stylesheet" href="static/css/style.css"/>
        <link type="text/css" rel="stylesheet" href="static/css/kube.css"/>
		<link type="text/css" rel="stylesheet" href="static/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
  	  	<script src="static/js/jquery.min.js"></script>
  	  	<script src="static/js/bootstrap.min.js"></script>
    </head>
    <body>
	    <center class="tab_out">
            <table class="table-stripped table-tabnav">
		        <tr><td class='text-centered' id='tab'>
				<nav>
					<div class="right-menu">
					
						<a href="index.php?page=create_order"><button class="btn btn-warning" style="border-radius:0%" type=""><i class="fa fa-plus-circle"></i> Orders</button></a>
						<a href="index.php?page=current_orders"><button class="btn btn-info" style="border-radius:0%"><i class="fa fa-list-ol"></i> List Orders</button></a>
					</div>

					
					<div class="left-menu">
						<div class="nav dropdown">
						
						    <button class="btn btn-primary dropdown-toggle" style="border-radius:0%" type="button" data-toggle="dropdown">Main Menu
						    <span class="caret"></span></button>
							
						    <ul class="dropdown-menu">
						      <li class="dropdown-header">System Overview</li>
							  <li><a href="index.php?page=food&action=sold">Food Sold</a></li>
							  <li><a href="index.php?page=food&action=weekly">Weekly Reports</a></li>
						      <li class="divider"></li>
						      <li class="dropdown-header">Customer Section</li>
						      <li><a href="index.php?page=customer&action=info">Customer Information</a></li>
							  <li><a href="index.php?page=customer&action=new">Add New Customer</a></li>
						      <li class="divider"></li>
							  <li class="dropdown-header">Products Section</li>							  
							  <li><a href="index.php?page=food&action=detail">Manage Food Items</a></li>
							  <li><a href="index.php?page=food&action=cata">Manage Food Category</a></li>
							  <li><a href="index.php?page=food&action=new">Add Food | Category</a></li>
						    </ul>
						  </div>

						  
					</div>


					<div class="center-menu">
						<p>Online Food Ordering System</p>
</div>
				</nav>
				
				</tr></td>      
		    </table>
		</center>
		<div class='left'>
			<div class='left_tab'>
				<a href=#><img src='static/img/upicon.png'/></a><br/>
				<?php
				if(!isset($_GET['action'])){
					$_GET['action']='';
				}
				if ($page == 'create_order' || ($_GET['action']=='weekly') || $_GET['action']=='sold') {
					$sql_fcata = "SELECT cata_name FROM food_catalogue WHERE price IS NULL ORDER BY catalog_id";
					$res_fcata = $mysql->query($sql_fcata);
					while($row_fcata = $mysql->fetch($res_fcata)){
						echo "<a href=# style='text-decoration:none; color:black;'".$row_fcata['cata_name'].">".$row_fcata['cata_name']."</a><br/>";
					}
				}
				?>
				<a href=#bottom><img src='static/img/downicon.png'/></a>
			</div>
		</div>
		<div class='body'>
            <row>
                <column cols="12">		
		