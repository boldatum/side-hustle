<?php
include 'includes/dbh.php';
if(isset($_GET['itemdel'])){
    $itemId = $_GET['itemdel'];

    $sqldelete = "DELETE FROM listings WHERE n_id = $itemId";
    if($conn->query($sqldelete)){
       header('Location: dashboard.php'); 
    }
    else{
        echo 'an error occured';
    }
}
    