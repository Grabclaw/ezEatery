<?php
	session_start();

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
	
	
	
	function updateTableData($conn, $table, $what, $toValue, $where)
	{
		$sql = "UPDATE $table SET $what=$toValue WHERE id=$where";

		if ($conn->query($sql) === TRUE) 
		{
		}
		else
		{
			echo "Error updating record: " . $conn->error;
		}
	}
	
	
	// Update all items that changed.
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
			else
			{
				updateTableData($conn, "items", "quantity", $row["quantity"] - $_SESSION["item_"."$x"][0], $_SESSION["item_"."$x"][1]);
			}
		}
	}
	
	
	// remove all session variables
	session_unset(); 

	// destroy the session 
	session_destroy(); 
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
		
		
		<!-- My External Files -->
		<script src="statusDisplay.js"></script>
		
		<title>EZ Eatery</title>
	</head>
	
	
	
	<body>		
		
		<a href="index.php">Home</a>
		<p></P>
		
		
		<div>
			<?php
					$sql = "SELECT * FROM items";
					$sqlResult = $conn->query($sql);
					
					
					if($conn === false)
					{
						echo "connection failed";
						return false;
					}
					else if($sqlResult === false)
					{
						echo "getting 'sqlResult' failed";
						return false;
					}
					else if($sqlResult->num_rows > 0) 
					{
						while($row = $sqlResult->fetch_assoc()) 
						{
							echo "<div id='".$row["id"]."' class='card bg-light text-dark'>";
							echo "<div class='card-body'>";
							echo "<h4 class='card-title'>".$row["foodname"]."</h4>";
							echo "<p class='card-text'>";
							echo "<table class='table'>";
							
							echo "<tr>";
							echo "<td>id</td>";
							echo "<td>foodname</td>";
							echo "<td>price</td>";
							echo "<td>quantity</td>";
							echo "<td>photoname</td>";
							echo "<td>description</td>";
							echo "</tr>";
							
							echo "<tr>";
							echo "<td>".$row["id"]."</td>";
							echo "<td>".$row["foodname"]."</td><td>".$row["price"]."</td>";
							echo "<td>".$row["quantity"]."</td><td>".$row["photoname"]."</td>";
							echo "<td>".$row["description"]."</td>";
							echo "</tr>";
							
							echo "<form>";
							echo "<tr>";
							echo"<td></td>";
							echo"<td></td>";
							echo"<td></td>";
							echo "<td><input id='".$row["id"]."_qa' type='text'></td>";
							echo "</tr>";
							echo "</form>";
							
							echo "</table>";
							echo "</p>";
							echo "<button onclick=\"pressedUpdateButton('".$row["id"]."')\" class='btn btn-info btn-lg' style='color:white'>Update</button>";
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
		
		
		<?php
			$conn->close();
		?>
	</body>
</html>