<!DOCTYPE html>
<?php include "../../inc/dbinfo.inc"; ?>
<html>
    <head>
    <meta charset="UTF-8">  
  
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>UVA Gamers - Register</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/favicon.png" type="image/ico" />
               
    </head>

    <body>
        <header>
            <div class="row">
                <div class="col-md-12" href="/index.html">
                    <h1>UVA Gamers</h1>
                </div>
            </div>
        </header>

        <div class="row">
        <div class="col-md-4">Register</div>
        <div class="col-md-4">
            <form class="needs-validation" action="<?php $_SERVER['PHP_SELF'] ?>" id="login" method="get"> 

            <div class="form-group mx-sm-5 mb-2">
                <input type="text" name="email" class="form-control" id="email" placeholder="Enter email" autofocus required>
            </div> 
</br>
            <div class="form-group mx-sm-5 mb-2">
                <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter first name" autofocus required>
            </div> 
            <div class="form-group mx-sm-5 mb-2">
                <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter last name" autofocus required>
            </div> 
</br>
            <div class="form-group mx-sm-5 mb-2">
                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" autofocus required>
            </div>    
            <div class="form-group mx-sm-5 mb-2 form-rounded">
                <input type="password" name="pwd" class ="form-control" id="password" placeholder="Password" required method="get"/>
            </div>
            <div class="form-group mx-sm-5 mb-2 form-rounded">
                <button class="btn btn-lg btn-primary" name='btnaction' value='register' type="submit" >Register</button>
                <br>    
            </div> 
        </form>
    </div>
        <div class="col-md-4"></div>
    </div>

<?php
    if (isset($_GET['btnaction']))
    {	
        try 
        { 	
            switch ($_GET['btnaction']) 
            {
                case 'register': 
                    register(); 
                    break;    
            }
        }
        catch (Exception $e)       // handle any type of exception
        {
            $error_message = $e->getMessage();
            echo "<p>Error message: $error_message </p>";
        }   
    }
?>
<?php 

function register()
{
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
    $database = mysqli_select_db($connection, DB_DATABASE);
    
    $username = $_GET["username"];
    $password = $_GET["pwd"];
    $email = $_GET["email"];
    $first = $_GET["firstname"];
    $last = $_GET["lastname"];
    //$hash_pwd = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (email, password, username, firstName, lastName) VALUES ('$email', '$password', '$username', '$first', '$last');";
    if(mysqli_query($connection, $query) == false){
        echo "Error: creating account failed. Check to see if there's an account associated with the email address provided.";
    }
    else{
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['pwd'] = $password;
        header('Location: /index.html');
    }
}
?>
    </body>

</html>

