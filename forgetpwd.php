<?php
include 'includes/dbh.php';
    

    if(isset($_GET['user'])){
        $username = $_GET['user'];

        $sql = "SELECT * FROM  user WHERE username = '$username'";
        $query = $conn->query($sql);
        $resultCheck = mysqli_num_rows($query);
        if($resultCheck>0){
            while($row = mysqli_fetch_assoc($query)){
                    $securityQ = $row['security_q'];
                    $securityA = $row['security_a'];
            }
            if(isset($_POST['submit'])){
                $securityAcheck =$_POST['security-a'];
                
                if($securityAcheck == $securityA){
                    header('Location: resetpwd.php?user='.$username.'');
                }

            }

        }
        else{
            echo 'user does not exist';
            header('Location: signin.php');
        }
        
    }
    if(isset($_POST['submit'])){
        $securityA= $_POST['security-a'];
        

        $sql = "SELECT * FROM user WHERE  username = '$username'";
        $query = $conn->query($sql);
        $resultCheck = mysqli_num_rows($query);

        if($resultCheck>0){
            while($row = mysqli_fetch_assoc($query)){
                    $securityA = $row['security_a'];
            }
            $sql = "SELECT * FROM user WHERE  username = '$username' AND security_q='$securityQ' AND security_a='$securityA'";

            $queryquestion = $conn->query($sql);

            
        }
        
        
    }

    ?>
<link rel="stylesheet" href="style.css">
<form action="" method="POST">
        <div class="field">
            <label for="username">Username</label>
            <span><strong><?php echo $username?></strong></span>
            <input type="hidden" name="username"  value="<?php echo $username?>">
        </div>
<div class="field">
            <label for="securityquestion" >
                <?php echo $securityQ; ?>
            </label>
    
           
           
           <input type="text" name="security-a" autocomplete="off">
        </div>
    
        
        <input type="submit" name="submit">
    
</form>