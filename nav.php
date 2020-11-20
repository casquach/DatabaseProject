<?php session_start(); 
        if(isset($_SESSION['email']))
        {
    ?>

<div class="topnav">
  <a class="active" href="#home" id="home">Home</a>
  <div class="topnav-right" style="float:right">
<?php
    echo "<a class'active' href=" . $_SESSION['email'] . " id='user'>User</a>"
?>
    <a class="active" href="/logout.php" id="logout">Logout</a>
  </div>
</div>

<?php 
        }
        else{
    ?>

<div class="topnav">
  <a class="active" href="#home" id="home">Home</a>
  <div class="topnav-right" style="float:right">
    <a class="active" href="/loginPage/login.php" id="login">Login</a>
  </div>
</div>

<?php 
        }
    ?>
