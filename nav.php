<?php session_start(); 
        if(isset($_SESSION['email']))
        {
    ?>

<div class="topnav">
  <a class="active" href="#home" id="home">Home</a>
  <div class="topnav-right" style="float:right">
    <a class="active" href="#user" id="user">User</a>
    <a class="active" href="#logout" id="logout">Logout</a>
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