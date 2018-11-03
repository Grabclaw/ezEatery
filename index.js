var items = [];
var searchKey = ""



function findItem(item) 
{
	return item.name === searchKey;
}


function createImageTD(src, _class, alt)
{
	var tdForImage = $("<td></td>");
	
	var picture = $("<img></img>");
	picture.attr(
	{
		"src" : src,
		"class" : "list-item-image",
		"alt" : "basic Salad",
	});
	
	tdForImage.append(picture);
	
	return tdForImage;
}

function creatTextInput(name, size, _val)
{	
	var input = $("<input type='text' name="+name+">");
	input.attr("size", size);
	input.val(_val);
	
	return input;
}

function creatHiddenInput(name, _val)
{
	var input = $("<input type='hidden' name="+name+">");
	input.val(_val);
	return input;
}


function pressedFoodButton(tableLocation, food, price, photoName)
{
	$(".footer").fadeIn();
	
	searchKey = food;
	if(items.find(findItem))
	{
		i = items.find(findItem);
		i.qnty++;
		i.qntyValInput.val(i.qnty);
	}
	else
	{		
		var rowForFood = $("<tr id='foodRow'></tr>")
		
		// Populate table row with columns for food details
		
			// Hidden input for php access
			rowForFood.append(creatHiddenInput("item_tableLocation_" + items.length, tableLocation));
		
			// Create Image
			rowForFood.append(createImageTD(
				"Images\\FoodItems\\" + photoName + ".jpg", 
				"list-item-image", 
				"basic Salad"
			));
		
			// Create Food Text
			var colForFoodItem = $("<td></td>");
			colForFoodItem.text(food);
			rowForFood.append(colForFoodItem);
			
			
			// Create Price Text
			var colForPrice = $("<td></td>");
			colForPrice.text(price);
			rowForFood.append(colForPrice);
			
			
			// Create Quantity Text Input
			var textInput = creatTextInput("item_quantity_" + items.length, "2", "1");
			
			var tdForText = $("<td></td>");
			tdForText.append(textInput);
			
			rowForFood.append(tdForText);
				
		
			// Create Buttons
			var colForBtns = $("<td></td>");
			var b1 = $("<button type='button'></button>");
			b1.attr("class", "btn btn-text");
			b1.click(function() 
			{
				searchKey = food;
				
				if(items.find(findItem))
				{
					i = items.find(findItem);
					i.qnty++;
					i.qntyValInput.val(i.qnty);
				}
				else
				{
					console.log("ID not found.")
				}
			});
			b1.append("+");
				
				
			var b2 = $("<button type='button'></button>");
			b2.attr("class", "btn btn-text");
			b2.click(function()
			{ 
				searchKey = food;
				
				if(items.find(findItem))
				{
					i = items.find(findItem);
					if(i.qnty <= 1)
					{
						rowForFood.remove();
						items.splice(i.arraySlot, 1);
						
						if(items.length < 1)
						{
							$(".footer").fadeOut();
						}
						else
						{
							var x;
							for (x = 0; x < items.length; x++)
							{
								items[x].arraySlot = x
							}
						}
					}
					else
					{
						i.qnty--;
						i.qntyValInput.val(i.qnty);
					}
				}
				else
				{
					console.log("ID not found.")
				}
			});
			b2.append("-");
				
				
			var bX = $("<button type='button'></button>");
			bX.attr("class", "btn btn-text");
			bX.click(function() 
			{
				searchKey = food;
				
				if(items.find(findItem))
				{
					rowForFood.remove();
					
					i = items.find(findItem);
					items.splice(i.arraySlot, 1);
					
					if(items.length > 0)
					{
						var x;
						for (x = 0; x < items.length; x++)
						{
							items[x].arraySlot = x
						}
					}
					else
					{
						$(".footer").fadeOut();
					}
				}
				else
				{
					console.log("ID not found.")
				}
			});
			bX.append("X");
				
		colForBtns.append(b1);
		colForBtns.append(b2);
		colForBtns.append(bX);
		rowForFood.append(colForBtns);
		// END OF: Create Buttons
				
		
		$("#foodList").append(rowForFood);
				
				
		items.push({name: food, qntyValInput: textInput, qnty: 1, price: price, arraySlot: items.length});
	};
}

function cancelFood()
{										
	if(items.length > 0)
	{
		var x;
		for (x = 0; x < items.length; x++)
		{
			$("#foodRow").remove();
		}
		items.length = 0;
	}
}


$(document).ready(function()
{	
	$(".footer").hide();
	
    $("#cancelButton").click(function()
	{
		cancelFood();
        $(".footer").fadeOut();
    });
});