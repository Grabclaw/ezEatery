// Get the Items arry for updating clients information on total items bought and price.
var rawItemsList = localStorage.getItem("submittedFoods");
var items;
items = JSON.parse(rawItemsList);



$(document).ready(function()
{	
	if(items.length > 0)
	{
		var total = 0
		
		var x;
		for (x = 0; x < items.length; x++)
		{
			var rowForFood = $("<tr></tr>");
			
			// Populate table row with columns for food details
			
				// Create Food Text
				var colForFoodItem = $("<td></td>");
				colForFoodItem.text(items[x].name);
				rowForFood.append(colForFoodItem);
				
				// Create Price Text
				var colForPrice = $("<td></td>");
				colForPrice.text(items[x].price);
				rowForFood.append(colForPrice);
				
				// Create Quantity Text
				var colForQnty = $("<td></td>");
				colForQnty.text(items[x].qnty);
				rowForFood.append(colForQnty);
				
				$("#foodList").append(rowForFood);
				
				total += (items[x].price * items[x].qnty);
		}
		
		// Format and round cost.
		$("#numberOfItems").text(items.length);
		total = Math.round( total * 100 ) / 100;
		$("#total").text(total);
	}
});

