<?php
function createProductBox($product)
  {
      $box = '<div class="product-box">';

      $img = '<img src="data:image/jpg;charset=utf8;base64,' . base64_encode($product['image']) . '"/>';
      $box .= $img;

      $name = '<h5>' . $product['item_name'] . '</h5>';
      $box .= $name;

      $price = '<p class="price">Price: ' . $product['price'] . '</p>';
      $box .= $price;

      $rating = '<p class="rating">Rating: ';
      $stars = '<span>' . str_repeat('&#9733;', $product['ratin']) . str_repeat('&#9734;', 5 - $product['ratin']) . '</span>';
      $rating .= $stars;
      $rating .= '</p>';
      $box .= $rating;

      $addToCartBtn = '<button id="btn' . $product['id'] . '" onclick="addToCart(' . $product['id'] . ')">Add to Cart</button><br>';
      $box .= $addToCartBtn;

      $addTowishBtn = '<button id="btn_w' . $product['id'] . '" onclick="addToWish(' . $product['id'] . ')">Add to wishList</button><br>';
      $box .= $addTowishBtn;
      
      $addToCartInput = '<input type="number" id="quantity_' . $product['id'] . '" min="1" value="1" style="width: 50px; height: 30px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px;">';
      $box .= $addToCartInput;

      $box .= '</div>';

      return $box;
  }

  function createProductBox_v2($product,$quantityValue)
  {
      $box = '<div class="product-box">';
  
      $img = '<img src="data:image/jpg;charset=utf8;base64,' . base64_encode($product['image']) . '"/>';
      $box .= $img;
  
      $name = '<h5>' . $product['item_name'] . '</h5>';
      $box .= $name;
  
      $price = '<p class="price">Price: ' . $product['price'] . '</p>';
      $box .= $price;
  
      $rating = '<p class="rating">Rating: ';
      $stars = '<span>' . str_repeat('&#9733;', $product['ratin']) . str_repeat('&#9734;', 5 - $product['ratin']) . '</span>';
      $rating .= $stars;
      $rating .= '</p>';
      $box .= $rating;
  

      $addToCartInput = '<h5> quantity = ' . $quantityValue . '</h5>';
      $box .= $addToCartInput;
  
      $box .= '</div>';
  
      return $box;
  }

  function createProductBox_v3($product,$quantityValue)
{
    $box = '<div class="product-box">';

    $img = '<img src="data:image/jpg;charset=utf8;base64,' . base64_encode($product['image']) . '"/>';
    $box .= $img;

    $name = '<h5>' . $product['item_name'] . '</h5>';
    $box .= $name;

    $price = '<p class="price">Price: ' . $product['price'] . '</p>';
    $box .= $price;

    $rating = '<p class="rating">Rating: ';
    $stars = '<span>' . str_repeat('&#9733;', $product['ratin']) . str_repeat('&#9734;', 5 - $product['ratin']) . '</span>';
    $rating .= $stars;
    $rating .= '</p>';
    $box .= $rating;

    $addToCartBtn = '<button id="btn' . $product['id'] . '" onclick="addToCart(' . $product['id'] . ','. $quantityValue. ')">Add to Cart</button><br>';
    $box .= $addToCartBtn;

    $addToCartInput = '<h5> quantity = ' . $quantityValue . '</h5>';
    $box .= $addToCartInput;


    $box .= '</div>';

    return $box;
}

  
  





  ?>
