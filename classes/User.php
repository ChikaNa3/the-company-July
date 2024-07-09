<?php

require_once "Database.php";

#The logic of the app will here

class User extends Database{
  public function store($request){
    $first_name = $request['first_name'];
    $last_name = $request['last_name'];
    $username = $request['username'];
    $password = $request['password'];

    $password = password_hash($password, PASSWORD_DEFAULT);

    #Query string
    $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUES('$first_name', '$last_name', '$username', '$password')";

    if($this->conn->query($sql)){
       header('location: ../views'); //go to index.php (login page)
       exit();
    } else{
      die("Error in creating the user: " . $this->conn->error);
    }

  }
  public function login($request){
    $username = $request['username'];
    $password = $request['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $this->conn->query($sql);

    if ($result->num_rows == 1){
      $user = $result->fetch_assoc(); //retrieving averything from the row
      #$user = ['id' => 1, 'username' => 'john', 'password' => 'fjajskldfjkla' ...]
      if(password_verify($password, $user['password'])){
            # create a session variable for future use
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];

            header('location: ../views/dashboard.php');
            exit();
      } else {
        die("Password is incorrect.");
      }
    } else {
      die("Username does not exist,");
    }
  }

  #logout
  public function logout(){
    session_start();
    session_unset();
    session_destroy();

    header('location: ../views'); //login page
    exit;
  }

  #Get or retrieved all the users from the users table
  public function getAllUsers(){
      $sql = "SELECT id, first_name, last_name, username, photo FROM users";

      #Execute the query
      if($result = $this->conn->query($sql)){
        return $result;
      } else {
        die("Error retrieving users." . $this->conn->error);
      }
  }

  #Get or retrieved a specific user(the user to edit)
  public function getUser($id){
      $sql = "SELECT * FROM users WHERE id = $id";
      if($result = $this->conn->query($sql)){
        return $result->fetch_assoc();
      } else {
        die("Error in retrieving the user." . $this->conn->error);
      }
  }
      public function update($request, $files){
        session_start();
        $id = $_SESSION['id'];

        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $username = $request['username'];

        $photo = $files['photo']['name'];
        $tmp_photo = $files['photo']['tmp_name']; // ['tmp_name'] --. a path to a temporary storage location

        #sql query string
        $sql = "UPDATE users SET first_name = '$first_name' , last_name = '$last_name' , username = '$username' WHERE id= $id";

        #Execute the query
        if($this->conn->query($sql)){ //if everything is OK during executing of the query
          $_SESSION['username'] = $username;
          $_SESSION['full_name'] = "$first_name $last_name";

          #Check if there is an uploaded image /photo, save it to the DB and sabe the file to images foloder

          if($photo){ //true or false? if photo exist or not
            $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
            $destination = "../assets/images/$photo";

            if($this->conn->query($sql)){// save the image to the DB
              # Save the file to the image folder
              if(move_uploaded_file($tmp_photo, $destination)){ // is okay?
                header('location: ../views/dashboard.php');
                exit;
              } else {
                die("Error in moving the photo.");
              } 
             } else {
                die("Error in uploading image." . $this->conn->error);
              }
            

          }
          header('location: ../views/dashboard.php');
            exit;

        }else {
          die("Error in updating the user." . $this->conn->error);
        }
      }
      public function delete(){
        session_start();
        $id = $_SESSION['id']; // id of the currently logged-in user

        $sql = "DELETE FROM users WHERE id = $id";
        if($this->conn->query($sql)){
          $this->logout(); //call the logout method
        } else {
          die("Error in deleting your account." .$this->conn->error);
        }
      }
}
?>