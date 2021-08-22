<?php
include 'includes/dbh.php';

session_start();

if(isset($_SESSION['user'])){
    echo $_SESSION['user'];
    echo '<br>';
    $userId= $_SESSION['user-id'];
}
else{
    echo 'session not set';
}
if(isset($_POST['submitsignout'])){
    // session_start();
    session_unset();
    session_destroy();
    header('Location: index.php');
}

if(isset($_POST['submititem'])){
        $itemName = $_POST['item-name'];
        $itemImg = $_FILES['item-image'];
        $itemprice = $_POST['item-price'];
        $itemCat= $_POST['item-category'];
        $itemQuantity= $_POST['item-quantity'];
        
        if(empty($itemImg)||empty($itemName) || empty($itemprice) || empty($itemCat)){
            echo 'Enter all the details of item';
        }
        else{

            $imgName = $itemImg['name'];
            $imgType = $itemImg['type'];
            $imgTmpName = $itemImg['tmp_name'];
            $imgerror = $itemImg['error'];
            $imgSize = $itemImg['size'];
    
           $allowedExt = array('jpg', 'jpeg', 'png', 'bmp');
            $imgName= explode('.', $imgName);
            $ext = strtolower(end($imgName));
            if(!in_array($ext, $allowedExt)){
                echo 'this image type is not allowed';
                exit();
            }
            else if($imgSize>100000000){
                echo 'image file too large';
                exit();
            }
            else if($imgerror){
                echo 'image is corrupted';
                exit();
            }
            else{
                $sql = "INSERT INTO listings (`user_id`, `item`, `price`, `item_category`, `quantity`)VALUES('$userId', '$itemName', '$itemprice', '$itemCat', '$itemQuantity')";
                
                if($conn->query($sql)){

                    $sqlselectitem="SELECT * FROM listings WHERE  `user_id`=$userId";
                    $result = $conn->query($sqlselectitem);
                    if($conn->query($sqlselectitem)){
                        $numRows= mysqli_num_rows($result);
                        if($numRows>0){
                            while($row = mysqli_fetch_assoc($result)){
                                $itemId= $row['n_id'];
                                
                            }
                            
                            $imgNewName= 'item-'.$itemId.'.'.$ext;
                            $imgDestination='uploads/'.$imgNewName;
                            move_uploaded_file($imgTmpName, $imgDestination);
                            echo 'success ooo   ';
                            
                                header('Location: dashboard.php');
    
                            
                        }
                       
                        
                    }
                    else{
                        echo 'failed';
                        exit();
                    }
                   
                    
                    

                   
                    
                    
        
                    
                }
               else{
                   echo 'unexpected error';
               }
            }       
        }
     
}

?>

<center>DASHBOARD</center>
<link rel="stylesheet" href="style.css">
<form action="" method="POST" >
    <input type="submit" name="submitsignout" value="signout" style="background: pink;font-size:16px;border:0; padding:3px;">
</form>

<form action=""method="POST" enctype="multipart/form-data">
    <div class="form-wrapper item-form">
    <div class="field">
        <label for="item-name">Item Name</label>
        <input type="text" name="item-name"  autocomplete="off" value="<?php if(isset($itemName)){echo $itemName;}?>">
    </div>
    <div class="field">
        <label for="item-image">Image</label>
        <input type="file" name="item-image" >
    </div>
    <div class="field">
        <label for="item-price">Price</label>
        <input type="text" name="item-price"  autocomplete="off" value="<?php if(isset($itemprice)){echo $itemprice;}?>">
    </div>
    <div class="field">
        <label for="item-category">Item Category</label>
        <input type="text" name="item-category"  autocomplete="off" value="<?php if(isset($itemCat)){echo $itemCat;}?>">
    </div>
    
    <div class="field">
        <label for="item-quantity">Available quantity</label>
        <input type="text" name="item-quantity"  autocomplete="off" value="<?php if(isset($itemQuantity)){echo $itemQuantity;}?>">
    </div>
    <input type="submit" name="submititem" value="Add Item">
    </div>
</form>

<div class="container">
    

        <?php
        $quantities=0;
            $sql = "SELECT * FROM listings WHERE user_id= '$userId'";
            $result = $conn->query($sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck>0){
               
                    echo '<h3>you have '.$resultCheck.' different types of items for sale</h3>';
               

                echo '<div class="listings">';
                while($row= mysqli_fetch_assoc($result)){
                    $itemId = $row['n_id'];
                    $quantities+=$row['quantity'];
                    
                   ?> 
                       

                    <div class="item">
                        <div class="item-header">

                            <a href="edit.php?itemdit=<?php echo $itemId;?>">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><path d="M33 6.4l-3.7-3.7a1.71 1.71 0 0 0-2.36 0L23.65 6H6a2 2 0 0 0-2 2v22a2 2 0 0 0 2 2h22a2 2 0 0 0 2-2V11.76l3-3a1.67 1.67 0 0 0 0-2.36zM18.83 20.13l-4.19.93l1-4.15l9.55-9.57l3.23 3.23zM29.5 9.43L26.27 6.2l1.85-1.85l3.23 3.23z" class="clr-i-solid clr-i-solid-path-1" fill="currentColor"/>
                                </svg>
                            </a>
                            <a href="delete.php?itemdel=<?php echo $itemId;?>">
    
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="2em" height="2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M880 112H144c-17.7 0-32 14.3-32 32v736c0 17.7 14.3 32 32 32h736c17.7 0 32-14.3 32-32V144c0-17.7-14.3-32-32-32zM676.1 657.9c4.4 5.2.7 13.1-6.1 13.1h-58.9c-4.7 0-9.2-2.1-12.3-5.7L512 561.8l-86.8 103.5c-3 3.6-7.5 5.7-12.3 5.7H354c-6.8 0-10.5-7.9-6.1-13.1L470.2 512L347.9 366.1A7.95 7.95 0 0 1 354 353h58.9c4.7 0 9.2 2.1 12.3 5.7L512 462.2l86.8-103.5c3-3.6 7.5-5.7 12.3-5.7H670c6.8 0 10.5 7.9 6.1 13.1L553.8 512l122.3 145.9z" fill="red"/></svg>
                            </a>
                        </div>
                        <div class="item-img"> 
                            <?php
                            if(isset($itemId)){
                                echo '<img src="uploads/item-'.$itemId.'.jpg" alt="">';
                            }
                            ?>   
                        </div>
                        
                        <p><?php echo $row["item"];?></p>
                        <p>#<?php echo $row["price"];?></p>
                        <p><?php echo $row["quantity"];?></p>

                    </div>


                    <?php

                }
                echo '</div>';
                echo '<div id="quantityalert"> you have a total of <strong>'.$quantities.'</strong> items for sale</div>';
            }
        ?>
     
</div>
