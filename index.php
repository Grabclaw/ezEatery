<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		
		
		<!-- My External Files -->
		<script src="index.js"></script>
		<link rel="stylesheet" type="text/css" href="index.css">
		
		<title>EZ Eatery</title>
	</head>
	
	
	
	<body>
		<!-- Main Web Banner -->
		<div class="jumbotron jumbotron-fluid">
			<div class="container">
				<h1 class="display-3">The EZ Eatery</h1>
				<h1>Fast Fresh Food Online</h1>
				
				<p>
					<small>Operating Hours: Mon - Sat | 10:00am - 9:00pm</small><br>
					<a href="statusDisplay.php">Status</a>
				</p>
			</div>
		</div>
		
		
		<!-- Carousel Area -->
		<div id="fun" class="carousel slide" data-ride="carousel">
			<ul class="carousel-indicators">
				<li data-target="#fun" data-slide-to="0"></li>
				<li data-target="#fun" data-slide-to="1"></li>
			</ul>
			
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img src="Images\Banners\banner0.jpg" style="width:100%; height:500px;" alt="Basic Salad">
					<div class="carousel-caption">
						<h3 style="background-color:white; color:black;">
							Featured Foods
						</h3>
						<p style="background-color:white; color:black;">
							Try it or face regret.
						</p>
					</div>
				</div>
				
				<div class="carousel-item">
					<img src="Images\Banners\banner1.jpg" style="width:100%; height:500px;" alt="Apple Bites">
					<div class="carousel-caption">
						<h3 style="background-color:black;">
							Locations
						</h3>
						<p style="background-color:black;">
							See if we're close to your living space!
						</p>
					</div>
				</div>
			</div>
			
		    <a class="carousel-control-prev" href="#fun" data-slide="prev">
				<span class="carousel-control-prev-icon"></span>
		    </a>
		    <a class="carousel-control-next" href="#fun" data-slide="next">
				<span class="carousel-control-next-icon"></span>
		    </a>
		</div>
		<!-- End of Carousel Area -->
		
		
		<p></p>
		
		
		<!-- Food Item Cards -->
		<div class="custom-container container-fluid">
			<div class="table-responsive-sm">
				<div class="card-columns">
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
					
					
						$sql = "SELECT * FROM items";
						$result = $conn->query($sql);
				
						if($conn === false)
						{
							echo "connection failed";
							return false;
						}
						else if($result === false)
						{
							echo "getting 'result' failed";
							return false;
						}
						else if($result->num_rows > 0) 
						{
							while($row = $result->fetch_assoc()) 
							{			
								echo "<div id='".$row["id"]."' class='card bg-light text-dark' style='width:400px'>";
								echo "<img class='card-img-top' src='Images\FoodItems\\".$row["photoname"].".jpg' alt='".$row["foodname"]."'>";
								echo "<div class='card-body'>";
								echo "<h4 class='card-title'>".$row["foodname"]."</h4>";
								echo "<p class='card-text'>".$row["description"]."</p>";
								echo "<button onclick=\"pressedFoodButton('".$row["id"]."', '".$row["foodname"]."', ".$row["price"].", '".$row["photoname"]."')\" class='btn btn-info btn-lg' style='color:white'>$".$row["price"]."</button>";
								echo "</div>";
								echo "</div>";
							}
						} 
						else 
						{
							echo "0 results";
						}
					?>
				</div>
			</div>
		</div>
		<!-- End of Food Item Cards -->
		
		
		<!-- Dynamic Food Item List -->
		<div class="footer">
			<form action="checkOut.php" method="post">
				<p>
					<table class="table">
						<td>
							<b style="font-size: 32px;">Foods Selected</b>
						</td>
						<td>
							<input type="submit" class="btn btn-info btn-lg" style="color:white" value="Continue"></input>
							<button type="button" id="cancelButton" class="btn btn-info btn-lg" style="color:white">Cancel</button>
						</td>
					</table>
				</p>
				
				<table class="table">
					<tbody id = "foodList"></tbody>
				</table>
			</form>
		</div>
	</body>
</html>