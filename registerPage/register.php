<!DOCTYPE html>
<?php include "../inc/dbinfo.inc"; ?>
<html>
    <head>
    <meta charset="UTF-8">  
  
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <meta name="author" content="Vinh Do, Kirtana Pathak, Liem Budzien">
    <meta name="description" content="Redirect page for Telestrations">  
    
    <title>UVA Gamers - Register</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/custom.css" />
    <link rel="shortcut icon" href="images/favicon.png" type="image/ico" />
               
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
            <form class="needs-validation" action="<?php $_SERVER['PHP_SELF'] ?>" id="login" method="get"> 
            <div class="form-group mx-sm-5 mb-2">
                <input type="text" name="username" class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Enter username" autofocus required>
                <small id="usernameHelp" class="form-text wrong-login" ></small>
            </div>    
</br></br>
            <div class="form-group mx-sm-5 mb-2 form-rounded">
                <input type="password" name="pwd" class ="form-control" id="password" placeholder="Password" required method="get"/>
                <small id="passwordHelp" class="form-text wrong-login" ></small>
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
    require('connect-db.php');
    
    $username = $_GET["username"];
    $password = $_GET["pwd"];
    $hash_pwd = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO register (username, password) VALUES (:username, :password)";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $hash_pwd);
    $statement->execute();
    $statement->closeCursor();
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['pwd'] = $hash_pwd;
    header('Location: lobby.php');
}
?>
    </body>

</html>

