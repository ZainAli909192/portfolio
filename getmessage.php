<?php
include '../php/connectdb.php';
include 'loader.html' ;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" 
    && isset($_POST["name"]) 
    && isset($_POST["email"])
    && isset($_POST["message"])
)
{     // Retrieve the form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Validate the form data (not shown here)

    // Sanitize the input to prevent SQL injection (not shown here)

    // Prepare and execute the SQL INSERT query
    $maxIdQuery = "SELECT MAX(id) AS maxId FROM messages";
    $maxIdResult = $conn->query($maxIdQuery);
    
    // Check if the query was successful
    if ($maxIdResult) {
        $maxIdRow = $maxIdResult->fetch_assoc();
        $maxId = $maxIdRow['maxId'];
        
        // Calculate the new ID
        $newId = $maxId + 1;
        
        // Prepare the INSERT query with the new ID
        $sql = "INSERT INTO messages (id, name, email, message) VALUES ('$newId', '$name', '$email', '$message')";
    if ($conn->query($sql) === TRUE) {
      $success= "Message sent successfully...!";
      ?>
  <script>
      setTimeout(function() {
                showpopup("Your message is sent successfully...!");
            //   document.getElementsByClassName('success').textContent = '';
}, 10);
</script>
<?php
    }
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
    // Close the database connection
    $conn->close();
}
?>

   
<form id="noteForm"  class="animate-right" onsubmit=" return validateForm(e); " method="post">
   
  <span id="authorError" id="success" class="success"><?php echo isset($success) ? $success : ''; ?></span>
  <script>
  // Check if the success message is set
  <?php if(isset($success)): ?>
    // Fade out the success message after 2 seconds
    setTimeout(function() {
      var successMessage = document.getElementById('authorError');
      successMessage.textContent = ''; // Empty the success message
      
    }, 4000);
  <?php endif; ?>
</script>

    <label for="name">Name:</label>
    <input type="text" id="author" name="name">
    <span id="authorError" class="error"></span>
    
    <label id="purposeLabel3" for="purpose">Email:</label>
    <input type="email" id="purpose3" name="email">
    <span id="emailError" class="error"></span>
    
    <label for="message">Message:</label>
    <textarea id="notes" name="message" rows="4" cols="50"></textarea>
    <span id="messageError" class="error"></span>
    
    <input type="submit" value="Send message">
</form>


<script>

const popupScreen = document.querySelector(".popup-screen");
        const popupBox = document.querySelector(".popup-box");
        const closeBtn = document.querySelector(".close-btn");
        const btn = document.querySelector(".butt");
        const mesg = document.querySelector(".mesg");

        function showpopup(message){
              
          setTimeout(() => {
            mesg.textContent=message;
                    popupScreen.classList.add("activate");
                }, 1000); //Popup the screen in 02 seconds after the page is loaded.       
              
                closeBtn.addEventListener("click", () => {
                    popupScreen.classList.remove("activate"); //Close the popup screen on click the close button.
                });
              
          setTimeout(() => {
                    popupScreen.classList.remove("activate"); //Close the popup screen on click the close button.
                }, 3000); //Popup the screen in 02 seconds after the page is loaded.
        }
function validateForm(e) {
    e.preventDefault();
    var name = document.getElementById('author').value.trim();
    var email = document.getElementById('purpose3').value.trim();
    var message = document.getElementById('notes').value.trim();
    var isValid = true;
    
    // Validate name
    if (name === '') {
        
        document.getElementById('authorError').textContent = 'Name is required';
        isValid = false;
    }else if (name.length < 3) {
        document.getElementById('authorError').textContent = 'Name must have at least 3 characters';
        isValid = false;
    } else {
        document.getElementById('authorError').textContent = '';
    }
    
    // Validate email
    if (email === '') {
        document.getElementById('emailError').textContent = 'Email is required';
        isValid = false;
    } else {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,3}$/;
        if (!emailRegex.test(email)) {
            document.getElementById('emailError').textContent = 'Invalid email format';
            isValid = false;
        } else {
            document.getElementById('emailError').textContent = '';
        }
    }
    // Validate message
    if (message === '') {
        document.getElementById('messageError').textContent = 'Message is required';
        isValid = false;
    } else if (message.length < 6) {
        document.getElementById('messageError').textContent = 'Message must be at least 6 characters';
        isValid = false;
    } else {
        document.getElementById('messageError').textContent = '';
    }
  
    return isValid;
}
</script>
