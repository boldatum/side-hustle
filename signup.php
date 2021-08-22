<?php 
    include 'includes/dbh.php';
    session_start();

    if(isset($_POST['submit'])){
        $pname =$_POST['pname'];
        $username =$_POST['username'];
        $password =$_POST['password'];
        $passwordAgain =$_POST['passwordagain'];
        $businessName =$_POST['bname'];
        $category =$_POST['category'];
        $securityQ = $_POST['security-q'];
        $securityA=$_POST['security-a'];

        if(empty($pname) || empty($username) || empty($password) || empty($passwordAgain) || empty($businessName)||empty($category) || empty($securityQ) || empty($securityA)){
            echo "you have to fill in all fields";
        }

        else{
            
            // validation username doesnt exit 
            // passwords match
            //
            $sql="SELECT * FROM user WHERE username = '$username'";
            $queryResult= $conn->query($sql);
            if(mysqli_num_rows($queryResult)>0){
                echo 'username taken!';
                exit();
            }
                
                
            if($passwordAgain== $password){
                
                
                $sql ="INSERT INTO user (p_name, username, v_password, b_name, category, security_q, security_a) VALUES('$pname', '$username', '$password','$businessName', '$category', '$securityQ', '$securityA')";
    
                if($conn->query($sql)){
                    
                    $_SESSION['user']=$username;

                    header('Location: signin.php?userup=success');
                }
                else{
                    echo 'unexpected error occured';
                }


            }
            else{
                echo "password do not match";
            }
            
        }
        
            

    }
    
    ?>


<link rel="stylesheet" href="style.css">

<form action="" method="POST">
    <div class="form-wrapper">

        <div class="field">
            <label for="pname">Your Name</label>
            <input type="text" name="pname" autocomplete="off" value="<?php if(isset($pname)){echo $pname;}?>">
        <div class="field">
            <label for="username">Username</label>
            <input type="text" name="username"  autocomplete="off" value="<?php if(isset($username)){echo $username;}?>">
        </div>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password"  autocomplete="off" value="<?php if(isset($password)){ echo $password;}?>">
        </div>
        <div class="field">
            <label for="passwordagain">Enter Password again</label>
            <input type="password" name="passwordagain"  autocomplete="off" >
        </div>
        <div class="field">
            <label for="bname">business name</label>
            <input type="text" name="bname"  autocomplete="off" value="<?php if(isset($businessName)){ echo $businessName;}?>">
        </div>
        <div class="field">
            <label for="businesscategory">
                select your business category
            </label>
           <select name="category" id="bcategory">
               <option value="">Select your category</option>
               <option value="fashion">Fashion</option>
               <option value="technology">Technology</option>
               <option value="real estate">Real Estate</option>
               <option value="materials">Materials</option>
           </select>
        </div>
        <div class="field">
            <label for="securityquestion" >
                choose a security question
            </label>
    
           <select name="security-q" id="security-q" style="margin: 0;">
               <option value="">Select your category</option>
               <option value="What is your best food">What is your best food</option>
               <option value="what is your best programming language">what is your best programming language</option>
               <option value="what is the name of your best friend">what is the name of your best friend</option>
               <option value="what is your dream country">what is your dream country</option>
           </select>
           
           <input type="text" name="security-a" autocomplete="off">
        </div>
    
        
        <input type="submit" name="submit">
    </div>
</form>
    