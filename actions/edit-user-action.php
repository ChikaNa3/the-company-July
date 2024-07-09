<?php
include "../classes/User.php";

#Create an object
$user = new User;

# Call the update method
$user->update($_POST, $_FILES);
# $_POST = [firstname, kastname, username]
#$_FILES  = image upldoaded by the user (photo.avatar)
?>