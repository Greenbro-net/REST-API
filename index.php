<?php

// REST API

echo "Enter parameter for request";

?>

<form action="RequestModel.php" method="GET">
     <lable for="id_brand">Enter id of brend</lable>
     <input type="text" name="id_brand" value="80">
     </br></br>
     <label for="id_availability">Choose a availability of product:</label>
     <select name="id_availability" id="field_id_availability">
         <option value="1">Is available: 1 </option>
         <option value="2">To specify the delivery: 2 </option>
         <option value="3">Under the order: 3 </option>
     </select>
     </br></br>
     <label for="price">Price (between 0 and 1000000):</label>
     <input type="range" id="item_price" name="price" min="0" max="1000000">
</form>


