<!DOCTYPE html>
<html>
	<body>
		<?php
				$servername = "localhost";
				$username = "Michael";
				$password = "7michael99";
				$dbname = "store";



				/* 	
					Validate data before it is used.
					qa stands for 'quantity'.
				*/
				$demi_qa = 0;
				
				if (!filter_var(intval($_POST['qa']), FILTER_VALIDATE_INT) === false) 
				{
					$demi_qa = intval($_POST['qa']);
				} 
				else 
				{
					echo "Integer is not valid!";
					
					// Set quantity value to -1 so update function doesnt trigger.
					$demi_qa = -1;
				}
				
				$id = $_POST['id'];
				$qa = $demi_qa;
				
				
				
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) 
				{
					die("Connection failed: " . $conn->connect_error);
				} 


				function updateTableData($conn, $table, $what, $toValue, $where)
				{
					$sql = "UPDATE $table SET $what='$toValue' WHERE id=$where";

					if ($conn->query($sql) === TRUE) 
					{
					} 
					else
					{
						echo "Error updating record: " . $conn->error;
					}
				}
				
				
				if($qa > 0)
				{
					updateTableData($conn, "items", "quantity", $qa, $id);
				}
				
				
				$sql = "SELECT * FROM items WHERE id = '".$id."'";
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
						echo "<td>".$row["foodname"]."</td>";
						echo "<td>".$row["price"]."</td>";
						echo "<td>".$row["quantity"]."</td>";
						echo "<td>".$row["photoname"]."</td>";
						echo "<td>".$row["description"]."</td>";
						echo "</tr>";
						
						echo "<form>";
						echo "<tr>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
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
	</body>
</html>