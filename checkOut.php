<?php
	$servername = "localhost";
	$username = "Michael";
	$password = "7michael99";
	$dbname = "store";

	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	
	
	
	session_start();
	$totalItems = 0;
	$pirceTotal = 0;
	
	
	// Validate data before it is used.
	function testForInt($data)
	{
		if (!filter_var($data, FILTER_VALIDATE_INT) === false)
		{
			return intval($data);
		} 
		else 
		{
			echo("Integer is not valid<br>");
			return false;
		}
	}
	
	
	/* 
		The number of vars in POST is cut in half as it is being used like a 2d array.
		The first column in the array holds a food items quantity.
		The second column in the array holds that items id for the sql data table.
	*/
	for ($x = 0; $x < (count($_POST) / 2); $x++)
	{
		$quantity = (int)testForInt($_POST["item_quantity_"."$x"]);
		
		if($quantity != false)
		{
			$_SESSION["item_"."$x"] = array($quantity, $_POST["item_tableLocation_"."$x"]);
			$totalItems += $quantity;
		}
		else
		{
			echo "<a href='index.php'>Home</a>";
			return;
		}
	}
	
	
	// Check to make sure items are still in stock.
	for ($x = 0; $x < count($_SESSION); $x++)
	{
		$sql = "SELECT * FROM items WHERE id=".$_SESSION["item_"."$x"][1];
		$result = $conn->query($sql);
		if($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			if($row["quantity"] < $_SESSION["item_"."$x"][0])
			{
				echo "<script>alert('Sorry, an item on your order has sold out!')</script>";
				echo "<a href='index.php'>Home</a>";
				
				// remove all session variables
				session_unset(); 

				// destroy the session 
				session_destroy(); 
				
				return;
			}
		}
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		
		<!-- My Exteranal Files -->
		<link rel="stylesheet" href="checkOut.css">
		
		<title>EZ Eatery</title>
	</head>
	
	
	
	<body>
		<div class="row">
			<div class="col-75">
				<div class="container">
					<form action="statusDisplay.php" method="post">
						<div class="row">
							<div class="col-50">
								<h3>Billing Address</h3>
								
								<label for="fname"><i class="fa fa-user"></i>Full Name</label>
								<input type="text" id="fname" name="firstname" placeholder="John M. Doe">
								
								<label for="email"><i class="fa fa-envelope"></i>Email</label>
								<input type="text" id="email" name="email" placeholder="john@example.com">
								
								<label for="adr"><i class="fa fa-address-card-o"></i>Address</label>
								<input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
								
								<label for="city"><i class="fa fa-institution"></i>City</label>
								<input type="text" id="city" name="city" placeholder="New York">

								<div class="row">
									<div class="col-50">
										<label for="state">State</label>
										<input type="text" id="state" name="state" placeholder="NY">
									</div>
									<div class="col-50">
										<label for="zip">Zip</label>
										<input type="text" id="zip" name="zip" placeholder="10001">
									</div>
								</div>
							</div>

							<div class="col-50">
								<h3>Payment</h3>
								<label for="fname">Accepted Cards</label>
								<div class="icon-container">
									<i class="fa fa-cc-visa" style="color:navy;"></i>
									<i class="fa fa-cc-amex" style="color:blue;"></i>
									<i class="fa fa-cc-mastercard" style="color:red;"></i>
									<i class="fa fa-cc-discover" style="color:orange;"></i>
								</div>
							
								<label for="cname">Name on Card</label>
								<input type="text" id="cname" name="cardname" placeholder="John More Doe">
								<label for="ccnum">Credit card number</label>
								<input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
								<label for="expmonth">Exp Month</label>
								<input type="text" id="expmonth" name="expmonth" placeholder="September">

								<div class="row">
									<div class="col-50">
										<label for="expyear">Exp Year</label>
										<input type="text" id="expyear" name="expyear" placeholder="2018">
									</div>
									<div class="col-50">
										<label for="cvv">CVV</label>
										<input type="text" id="cvv" name="cvv" placeholder="352">
									</div>
								</div>
							</div>
						</div>
						
						<label>
							<input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
						</label>
						
						<input id ="finalSubmit" type="submit" value="Continue to checkout" class="btn">
					</form>
				</div>
			</div>

			
			<div class="col-25">
				<div class="container">
					<table class="table">
						<thead>
							<h4>Items
								<span class="price" style="color:black">
									<i class="fa fa-shopping-cart"></i> 
									<b id="numberOfItems"><?php echo $totalItems; ?></b>
								</span>
							</h4>
						</thead>
						<tbody>
						<?php
							for ($x = 0; $x < (count($_POST) / 2); $x++)
							{
								$sql = "SELECT * FROM items WHERE id=".$_POST["item_tableLocation_"."$x"];
								$result = $conn->query($sql);
								if($result->num_rows > 0)
								{
									$row = $result->fetch_assoc();
									echo "<tr><td>".$row["foodname"]."</td><td>".$row["price"]."</td><td>".$_POST["item_quantity_"."$x"]."</td></tr>";
									$pirceTotal += (float)$row["price"];
								}
								else
								{
									$conn->close();
									return false;
								}
							}
						?>
						</tbody>
					</table>
					
					<p>Total 
						<span class="price" style="color:black">
							<b id="total"><?php echo $pirceTotal; ?></b>
						</span>
					</p>
				</div>
			</div>
		</div>
		
		
		<?php
			$conn->close();
		?>
	</body>
</html>