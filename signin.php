<?php
include 'includes/dbh.php';
session_start();

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user WHERE username ='$username' AND v_password = '$password'";
        $querysql = $conn->query($sql);
        $queryCheck = mysqli_num_rows($querysql);
        if($queryCheck >0){
            while($row=mysqli_fetch_assoc($querysql)){
                $userId = $row['id'];
            }
            $_SESSION['user']=$username;
          
            $_SESSION['user-id'] = $userId;

            header('Location: dashboard.php');
        }
        else{
            echo "wrong username or passwod";
        }



    }
?>
    
<link rel="stylesheet" href="style.css">
    <?php
        if (isset($_GET['userup'])){
            if ($_GET['userup']=='success'){
                echo 'you have signed up successfully';
                echo 'now enter your username and password again to stay signed in';

            }

        }
    ?>
<form action="" method="POST">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username"  autocomplete="off" value="<?php if(isset($username)){echo $username;}?>">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input type="password" name="password"  autocomplete="off">
    </div>
    <input type="submit" name="submit">
  
</form>
<a href="forgetpwd.php?user=<?php echo $username?>">forget password?</a><br>
<a href="signup.php">Sign Up</a>
