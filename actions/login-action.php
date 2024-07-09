<?php
include "../classes/User.php";

#Create an object
$user = new User;

#Call the method
$user->login($_POST);