<?php 
  $data = $_POST;
  $pid = (int) $data['pid'];
  $product_name = $data['p_name'];
  $description = $data['desc'];
  $quantity = $data['quantity'];
  
  //Adding the record.
try{
       $sql = "UPDATE products SET Quantity=?, product_name=?, description=?, updated_at=? WHERE id=?";
	    include('connection.php');
	   $conn -> prepare($sql)->execute([$quantity, $product_name, $description, date('Y-m-d h:i:s'), $pid]);
	   echo json_encode([
	         'success' => true,
             'message' => $product_name . ' ' . $description . ' ' . 'successfully updated.'         
       ]);
   } catch (PDOException $e) {
	   echo json_encode([
             'success' => false,
             'message' => 'Error processing your request!'
       ]);
    }