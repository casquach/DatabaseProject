<?php session_start(); 
        if(isset($_SESSION['username']))
        {
    ?>

<div class="topnav">
  <a class="active" href="#home" id="home">Home</a>
  <div class="topnav-right" style="float:right">
    <a class="active" href="#user" id="user">User</a>
    <a class="active" href="#user" id="user">Logout</a>
  </div>
</div>

<?php 
        }
        else{
    ?>

<div class="topnav">
  <a class="active" href="#home" id="home">Home</a>
  <div class="topnav-right" style="float:right">
    <a class="active" href="#login" id="user">Login</a>
  </div>
</div>

<?php 
        }
    ?>