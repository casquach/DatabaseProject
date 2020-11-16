<?php
    session_start();
?>
<?php
    if(count($_SESSION) > 0)
    {
        foreach($_SESSION as $key => $value)
        {
            unset($_SESSION[$key]);
        }
        session_destroy();
    }
    header('Location: /loginPage/login.php');
?>
