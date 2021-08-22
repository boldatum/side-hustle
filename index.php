<?php
include 'includes/dbh.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body{
            font-size: 20px;
        }
        a{
            text-decoration: none;
            color: #aa2134;
            
        }
    </style>
</head>
<body>
    <center>Market place</center>
    <a href="signup.php">Sign Up</a>
    <br>
    <span>do you have an account</span>
    <a href="signin.php">Sign in</a><br>
    <!-- ----------------------------market place begin------------------------------------------- -->
    <div class="container">
    

    <?php
        $sql = "SELECT * FROM listings";
        $result = $conn->query($sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck>0){
           
                
           

            echo '<div class="listings">';
            while($row= mysqli_fetch_assoc($result)){
                $itemId = $row['n_id'];
               ?> 
                   

                <div class="item">
                   
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
        
        }
    ?>
 
</div>
</body>
</html>