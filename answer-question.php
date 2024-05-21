<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Account</title>
    <link rel="stylesheet" href="../css/login.css" />
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

  </head>

  <body>
    <?php
    include './loader.html';

   include_once('../php/connectdb.php'); 
    // Check if the email is submitted via POST
    $question="";
$id=1;
$error="";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Get the submitted email
        $id = $_GET["id"];
    
        // Query to fetch the security question based on the email
        $sql = "SELECT question FROM admin WHERE id = '$id'";
    
        // Execute the query
        $result = $conn->query($sql);
    
        // Check if a security question is found
        if ($result->num_rows > 0) {
            // Fetch the result
            $row = $result->fetch_assoc();
            // Output the security question
            $question=$row['question'];
            // echo "Security Question: " . $row['question'];
          } else {
            // If no security question found, display an error message
            echo "No security question found for the provided email.";
        }
    }
    

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted ID and answer
    // $id = $_POST["id"];
    $answer = $_POST["answer"];

    // Query to fetch the answer based on the ID
    $sql = "SELECT answer FROM admin WHERE id = '$id'";
    $result = $conn->query($sql);

    // Check if a record is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $correctAnswer = $row['answer'];

        // Check if the provided answer matches the stored answer
        if ($answer == $correctAnswer) {
            // Redirect the user to the password reset page
            header("Location: password-reset.php?id=$id");
            exit;
        } else {
            // If the answers don't match, display an error message
             // Query to fetch the security question based on the email
             $sql = "SELECT question FROM admin WHERE id = '$id'";
    
             // Execute the query
             $result = $conn->query($sql);
         
             // Check if a security question is found
             if ($result->num_rows > 0) {
                 // Fetch the result
                 $row = $result->fetch_assoc();
                 // Output the security question
                 $question=$row['question'];
                 // echo "Security Question: " . $row['question'];
               } else {
                 // If no security question found, display an error message
                 echo "No security question found for the provided email.";
             }
        
        
            $error= "Incorrect answer. Please try again.";
        }
    } else {
        // If no record is found, display an error message
        echo "No record found for the provided ID.";
    }

    // Close the database connection
    $conn->close();
}

    ?>
    

    <section class="wrapper">
      <div class="form  Signup">
        <header>Answer the question</header>
        <form  method="post">
          <label for="">Question</label>
          <input type="text" value="<?php echo htmlspecialchars($question, ENT_QUOTES); ?>" id="question" readonly />
          <input type="text" placeholder="Enter answer" required name="answer" />
          <span class="error-message" style= "color:yellow;">
            <?php echo $error; ?>
          </span>  
          
          <input type="submit" value="Submit" />
          <br>
        </form>
      </div>

      <div class="form login">
       <a href="./login.php">
        <header >Login</header>
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
