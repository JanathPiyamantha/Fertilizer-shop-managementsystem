<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Fertilizer Shop</title>
    <style>
        /* Basic styling for demonstration */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .product {
            border: 1px solid #ccc;
            margin-bottom: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
        }
        .product img {
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }
        .product-info {
            flex-grow: 1;
        }
        .product h2 {
            margin: 0 0 10px 0;
        }
        .product p {
            margin: 0;
        }
        .add-to-cart {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Products</h1>
    <?php
    // Define products
    $products = array(
        array(
            'name' => 'Fertilizer A',
            'price' => 100,
            'image' => 'nitric-acid.jpeg'
        ),
        array(
            'name' => 'Fertilizer B',
            'price' => 150,
            'image' => 'Compost.jpg'
        ),
        array(
            'name' => 'Fertilizer C',
            'price' => 200,
            'image' => 'seaweed-fertilizer.jpg'
        ),
        array(
            'name' => 'Fertilizer D',
            'price' => 250,
            'image' => '06-Organic-Products-01.jpg'
        ),
        array(
            'name' => 'Fertilizer E',
            'price' => 300,
            'image' => 'images.jpeg'
        )
    );

    // Display products
    foreach ($products as $product) {
        echo '<div class="product">';
        echo '<img src="images/' . $product['image'] . '" alt="' . $product['name'] . '">';
        echo '<div class="product-info">';
        echo '<h2>' . $product['name'] . '</h2>';
        echo '<p>Price: Rs.' . $product['price'] . '</p>';
        // Add onclick attribute to call openGoogleForm function
        echo '<button class="add-to-cart" onclick="openGoogleForm()">Add to Cart</button>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
<script>
function openGoogleForm() {
    // Replace 'YOUR_GOOGLE_FORM_URL' with the actual URL of your Google Form
    const googleFormUrl = '';
    window.open(googleFormUrl, '_blank');
}
</script>
</body>
</html>