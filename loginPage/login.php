<!DOCTYPE html>
<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
  <meta charset="UTF-8">  
  
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <meta name="author" content="Vinh Do, Kirtana Pathak, Liem Budzien">
  <meta name="description" content="Login page for Telestrations">  
    
  <link rel="shortcut icon" href="images/favicon.png" type="image/ico" />
  <title>UVA Gamers - Login</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/custom.css" />
       
</head>

<body>  
    <header>
        <div class="row">
            <div class="col-md-12">
                <h1>UVA Gamers</h1>
            </div>
        </div>
    </header>

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form class="needs-validation" action="<?php $_SERVER['PHP_SELF'] ?>" id="login" method="post"> 
            <div class="form-group mx-sm-5 mb-2">
                <p id="failedLogin"></p>
                <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Enter email" autofocus required>
                <small id="usernameHelp" class="form-text wrong-login" ></small>
            </div>    

            <div class="form-group mx-sm-5 mb-2 form-rounded">
                <input type="password" name="pwd" class ="form-control" id="password" placeholder="Password" required/>
                <small id="passwordHelp" class="form-text wrong-login" ></small>
            </div>
            <div class="form-group mx-sm-5 mb-2 form-rounded">
                <button class="btn btn-lg btn-primary" type="submit" >Sign in</button>
                <br>    
                <a href="http://localhost:4200" class="register">Don't have an account? Register now</a>
            </div> 
        </form>
    </div>
        <div class="col-md-4"></div>
    </div>
<?php
    session_start();
?>
<?php
    function reject($entry){
        echo $entry . ' must be alphanumeric characters';
        exit();
    }



    if($_SERVER['REQUEST_METHOD']=="POST" && strlen($_POST['username']) > 0)
    {
        $user = trim($_POST['username']);
        if(!ctype_alnum($user)) //built in function that checks to make sure its alphanumeric 
        {
            reject('username');
        }
        if(isset($_POST['pwd'])) //check if password null
        {
            $pwd = trim($_POST['pwd']);
            if(!ctype_alnum($pwd))
            {
                reject('password');
            }
            else
            {
                $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
                if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
                $database = mysqli_select_db($connection, DB_DATABASE);

                $result = mysqli_query($connection, "SELECT password FROM users WHERE username=",$user);

                if(mysqli_num_rows($result) > 0){
                    $hashed = $result[0]['password'];

                    if($_POST['pwd'] == $hashed)
                    {
                        // $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT);
                        $hash_pwd = $_POST['pwd'];
                        $_SESSION['username'] = $user;
                        $_SESSION['pwd'] = $hash_pwd;
                        header('Location: index.html');
                    }
                    else
                    {
                        echo "Invalid Password";
                    }
                }
                else
                {
                    echo "No account found, register above";
                }
            }
        }
    }


?>
<?php
        mysqli_free_result($result);
        mysqli_close($connection);
    ?>


</body>
</html>