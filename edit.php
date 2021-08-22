<?php
    include 'includes/dbh.php';
    session_start();
    if(isset($_GET['itemdit'])){
        $itemId = $_GET['itemdit'];

        $sqlselect = "SELECT * FROM listings WHERE n_id = $itemId";
        $result = $conn->query($sqlselect);
        if(mysqli_num_rows($result)>0){
            while($row= mysqli_fetch_assoc($result)){
                $user_id = $row['user_id'];
                $itemName = $row['item'];
                $itemprice = $row['price'];
                $itemCat = $row['item_category'];
                $itemQuantity = $row['quantity'];
                
            }
        }
        if(isset($_POST['submitedited'])){
            $itemprice = $_POST['item-price'];
            $itemQuantity = $_POST['item-quantity'];

            $sql="UPDATE listings SET  price=$itemprice, quantity=$itemQuantity ";
            if($conn->query($sql)){
                header('Location: dashboard.php');
            }
            else{
                echo "could not update product due to unexpected error";
            }
        }
    ?>
        <form action=""method="POST" enctype="multipart/form-data">
        <div class="form-wrapper item-form">
        <div class="field">
            <label for="item-name">Item Name</label>
          <strong><?php if(isset($itemName)){echo $itemName;}?></strong> 
          <br>
          <label for="product-id"><?php if(isset($itemId)){echo $itemId;}?></label>
        
        
        <div class="field">
            <label for="item-price">Price</label>
            <input type="text" name="item-price"  autocomplete="off" value="<?php if(isset($itemprice)){echo $itemprice;}?>">
        </div>
       
        
        <div class="field">
            <label for="item-quantity">Available quantity</label>
            <input type="text" name="item-quantity"  autocomplete="off" value="<?php if(isset($itemQuantity)){echo $itemQuantity;}?>">
        </div>
        <input type="submit" name="submitedited" value="Update Item">
        </div>
    </form>

    <?php
    }