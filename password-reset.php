<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

   <title>Reset password</title>
    <link rel="stylesheet" href="../css/login.css" />
  </head>
  <body>

    <?php
// Include your database connection file
include_once('../php/connectdb.php');
include './loader.html';

$error="";
// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the ID from the URL parameters
    $id = $_GET["id"];

    // Retrieve the submitted password and confirm password
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Check if password and confirm password match
    if (strlen($password) >= 5 && preg_match('/[0-9]/', $password) && preg_match('/[A-Za-z]/', $password)) {
        if ($password === $confirmPassword) {
 
      // Hash the passwords using md5 before storing them in the database
        $hashedPassword = md5($password);

        // Update the password in the database
        $sql = "UPDATE admin SET password = '$hashedPassword' WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
          ?>
        <script>
          alert("Password updated successfully...")
        </script>
<?php
        header("Location: ./login.php");

          // echo "Password updated successfully";
        } else {
          $error= "Error updating password: " . $conn->error;
        }
      
      
    } else {
      $error= "Password and confirm password do not match";
    }
  } else {
    $error= "Password must be at least 8 characters long and contain alphanumeric characters";
    }

    // Close the database connection
    $conn->close();
}
?>


    <section class="wrapper">
      <div class="form signup">
        <header>Password reset</header>
        <form action="#" method="post">
          <input type="password" placeholder="Password" required name="password"/>
          <input type="password" placeholder="Confirm Password" required name="confirm_password" />
          <span> 
            <?php echo $error;            ?>
          </span>
          
          <input type="submit" value="Submit" />
        </form>
      </div>

      <div class="form login">
      <a href="./login.php">

        <header>Login</header>
      </a> 
      </div>

      <script>
        const wrapper = document.querySelector(".wrapper"),
          signupHeader = document.querySelector(".signup header"),
          loginHeader = document.querySelector(".login header");

        loginHeader.addEventListener("click", () => {
          wrapper.classList.add("active");
        });
        signupHeader.addEventListener("click", () => {
          wrapper.classList.remove("active");
        });
      </script>
    </section>
  </body>
</html>