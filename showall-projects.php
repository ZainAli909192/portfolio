<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>All projects</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/loader.css">
    <!-- <link rel="stylesheet" href="../Zain AliCv .pdf"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

    <!-- cards css  -->
    <link rel="stylesheet" href="../css/cards.css">


  </head>
  <body> 
    
<!-- Loader container -->
<div class="loader-container" id="loaderContainer">
  <!-- Loader image -->
  <img src="../img/loader.svg" alt="Loader" class="loader-img">
</div>  


<script>
  function showloader(){
// Get the loader container element
var loaderContainer = document.getElementById('loaderContainer');
    // Display the loader container
    loaderContainer.style.display = 'block';

    // Hide the loader after 2 seconds
    setTimeout(function() {
      // Hide the loader container
      loaderContainer.style.display = 'none';
    }, 2000);
  
  } ;
  window.onload=showloader();
  </script>
    <nav id="nav">
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">Zain  Ali</label>
      <ul>  
        <li ><a class="active" onclick="closeNavbar()" href="index.php">Home</a></li>

        <li><a href="#contact" onclick="closeNavbar()">Contact us</a></li>
      </ul>
    </nav>

    <!-- About section -->
        <!-- projects  -->
      <div class="projects" id="Projects">
  <hr>
  <p>All Projects</p>
  <div class="card-list"> 
   
    <?php

include '../php/connectdb.php';
// Query to fetch project names and corresponding image paths (limit to 1 image per project)
$sql = "SELECT p.project_id AS project_id, p.name AS project_name, pic.path AS image_path
        FROM projects p
        INNER JOIN pictures pic ON p.project_id = pic.project_id
        GROUP BY p.project_id
        
        "; // Limit to 1 image per project
$result = $conn->query($sql);

// Check if there are any projects
if ($result->num_rows > 0) {
    // Output each project dynamically
    while ($row = $result->fetch_assoc()) {
      echo '<a href="project-details.php?project_id=' . $row['project_id'] . '" class="card-item animate-right">';
      echo '<img src="' . $row['image_path'] . '" alt="Card Image" >';
        echo '<h4>' . $row['project_name'] . '</h4>';
        echo '<div class="arrow">Details</div>';
        echo '</a>';
    }
} else {
    echo 'No projects found.';
}
?>

</div>
</div>

<hr>

  <!-- contact form  -->
      <main id="contact"> 
        <h4 >Contact us</h4> 
      <div class="contact-box ">
        
        <div class="social-media  animate-left">
        <b>  Social media </b>
          <div>
            <a href="https://wa.me/923250679080">
              <img src="../img/whatsapp.png" alt="WhatsApp">
            </a>
            
          </div>
          <div>
            <a href="https://www.linkedin.com/in/zainali36" target="_blank">
              <img src="../img/linkdin.png" alt="LinkedIn">
            </a>
                      </div>
          <div>

            <a href="https://github.com/zainali909192" target="_blank">
              <img src="../img/github.png" alt="LinkedIn">
            </a>          </div>
        </div>
    <form id="noteForm" class="animate-right" onsubmit="return validateForm()" method="post" action="../php//message-save.php">
      <label for="name">Name:</label>
      <input type="text" id="author" name="name">
      <span id="authorError" class="error"></span>
    
      <label id="purposeLabel3" for="purpose">Email:</label>
      <input type="email" id="purpose3" name="email" >
      <span id="purposeError" class="error"></span>
      
      <label for="message">Message:</label>
      <textarea id="notes" name="message" rows="4" cols="50"></textarea>
      <span id="notesError" class="error"></span>
    
      <input type="submit" value="Send message">
    </form>
    
  </div>  
      </main>

      <!-- footer  -->
      <footer>
        <div >
          <p> &copy; 2024 All rights reserved.</p>
        </div>
      </footer>
  </body>
</html>

  <?php
  include '../php/connectdb.php';
$sql = "SELECT cv FROM admin where id=1";
$result = $conn->query($sql);
$cvPath="";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cvPath = $row['cv'];
} else {
  // If no CV path is found, provide a default value or handle the case accordingly
  $cvPath = ""; // Set a default path or handle the case as per your requirement
}
?>


<!-- download button script  -->


<script>
function downloadCV() {
    // Set the file URL dynamically from PHP
    var fileURL = "<?php echo $cvPath; ?>"; // File URL retrieved from the database
    // var fileURL = "../Zain AliCV.pdf"; // File URL retrieved from the database
  // alert( "err")
    // Check if the file URL is not empty
    if (fileURL !== "") {
        // Create a link element
        var link = document.createElement('a');

        // Set the link's attributes
        link.href = fileURL;
        link.download = 'cv.pdf'; // Change the file name as needed

        // Append the link to the document body
        document.body.appendChild(link);

        // Trigger the click event on the link
        link.click();

        // Remove the link from the document body
        document.body.removeChild(link);
    } else {
        // Handle the case when the CV path is empty (e.g., display an error message)
        alert("CV file not found.");
    }
  }
  
  

document.getElementById('downloadBtn').addEventListener('click', downloadCV);

const strings = ["ReactJS","ExpressJS","NodeJS","Mongodb","TailwindCSS","Php","Python","CSS", "JS",];
const typingSpeed = 200; // Speed in milliseconds

const pauseDuration = 1000; // Pause duration in milliseconds
const clearDelay = 1000;

let stringIndex = 0; 
let charIndex = 0;

function type() {
  const text = strings[stringIndex];
  if (charIndex < text.length) {
    document.getElementById('typing-text').textContent += text.charAt(charIndex);
    charIndex++;
    setTimeout(type, typingSpeed);
  } else {
    // Move to the next string in the array or loop back to the beginning if at the end
    stringIndex = (stringIndex + 1) % strings.length;
    charIndex = 0;
    // setTimeout(type, pauseDuration);
    setTimeout(clearText, clearDelay); // Clear the text after 2 seconds

  }
}

function clearText() {
  document.getElementById('typing-text').textContent = ''; // Clear the text
  setTimeout(type, pauseDuration); // Pause for 1 second after clearing the text
}


document.addEventListener('DOMContentLoaded', type);

window.addEventListener('scroll', revealOnScroll);

function revealOnScroll() {
  var revealElements = document.querySelectorAll('.card-item');
  for (var i = 0; i < revealElements.length; i++) {
    var revealElement = revealElements[i];
    var revealPosition = revealElement.getBoundingClientRect().top;
    var windowHeight = window.innerHeight;
    if (revealPosition < windowHeight) {
      revealElement.classList.add('reveal');
    }
  }
}



function closeNavbar() {
      document.getElementById('check').checked = false;
    }
</script>