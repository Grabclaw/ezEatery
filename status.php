<!DOCTYPE html>
<html>
	<body>
		<?php
				$servername = "localhost";
				$username = "Michael";
				$password = "7michael99";
				$dbname = "store";
				
				$id = intval($_GET['id']);
				$fn = strval($_GET['fn']);
				$pr = floatval($_GET['pr']);
				$qa = intval($_GET['qa']);
				$ph = strval($_GET['ph']);
				$de = strval($_GET['de']);
				
				
				// Create connection
				$conn = new mysqli($servername, $username, $password, $dbname);
				// Check connection
				if ($conn->connect_error) 
				{
					die("Connection failed: " . $conn->connect_error);
				} 
				echo "Connected successfully<br>";

				function updateTableData($conn, $table, $what, $toValue, $where)
				{
					echo $toValue;
					$sql = "UPDATE $table SET $what='$toValue' WHERE id=$where";

					if ($conn->query($sql) === TRUE) 
					{
						echo "Record updated successfully";
					} 
					else
					{
						echo "Error updating record: " . $conn->error;
					}
				}
				
				
				if($id > 0)
				{
					updateTableData($conn, "items", "id", $id, $id);
				}
				if($fn != "")
				{
					updateTableData($conn, "items", "foodname", $fn, $id);
				}
				if($pr > 0)
				{
					updateTableData($conn, "items", "price", $pr, $id);
				}
				if($qa > 0)
				{
					updateTableData($conn, "items", "quantity", $qa, $id);
				}
				if($ph != "")
				{
					updateTableData($conn, "items", "photoname", $ph, $id);
				}
				if($de != "")
				{
					updateTableData($conn, "items", "description", $de, $id);
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
						echo "<tr><td>".$row["id"]."</td><td>".$row["foodname"]."</td><td>".$row["price"]."</td><td>".$row["quantity"]."</td><td>".$row["photoname"]."</td><td>".$row["description"]."</td></tr>";
						echo "<form>";
						echo "<tr>";
						echo "<td><input id='".$row["id"]."' type='text'></td>";
						echo "<td><input id='".$row["id"]."_fn' type='text'></td>";
						echo "<td><input id='".$row["id"]."_pr' type='text'></td>";
						echo "<td><input id='".$row["id"]."_qa' type='text'></td>";
						echo "<td><input id='".$row["id"]."_ph' type='text'></td>";
						echo "<td><input id='".$row["id"]."_de' type='text'></td>";
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