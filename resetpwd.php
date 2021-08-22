<?php
    include 'includes/dbh.php';
    session_start();
    $username= $_GET['user'];

    if(isset($_POST['submit'])){
        $password=$_POST['password'];
        $passwordAgain=$_POST['passwordagain'];

        if(empty($password)|| empty($passwordAgain)){
            echo 'enter a password';
        }
        else{
            if($passwordAgain == $password){

                $sql = "UPDATE user SET v_password = '$password' WHERE username='$username'";
                if($conn->query($sql)){
                    $_SESSION['user'] = $username;
                   header('Location: signin.php');
                } 

            }
            else{
                echo 'password do not match';
            }
        }
    }
?>

<link rel="stylesheet" href="style.css">
<form action="" method="POST">
    <span><strong><?php echo $username;?></strong></span>
<div class="field">
            <label for="password">Password</label>
            <input type="password" name="password"  autocomplete="off" >
        </div>
        <div class="field">
            <label for="passwordagain">Enter Password again</label>
            <input type="password" name="passwordagain"  autocomplete="off" >
        </div>
        <input type="submit" name="submit">
</form>