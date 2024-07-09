<?php
include "../classes/User.php";

# Create an object
$user = new User;

#Cass the register method
$user->store($_POST);
# $_POST --> holds the data coming from the form
# Datas: firstname, lastname, username and password
# $_POST [   this is array. this will be set (all the content of the form) if [] is not written
# 'first_name' => 'John',
# 'last_name' -> 'Smith',
# 'username => 'john.smith',
# 'password => 'jsmith12347
#]