<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Project details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/cards.css">
    <link rel="stylesheet" href="../css/projects.css">
    <link rel="stylesheet" href="../css/loader.css">
    <!-- <link rel="stylesheet" href="../Zain AliCv .pdf"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

    <!-- cards css  -->


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
      <label class="logo-img">

      <img src="../img/profile.jpg" class="logo-img"/>
      </label>
      <ul>  
        <li ><a class="active" href="index.php">About me</a></li>
        <li><a onclick="closeNavbar()" href="#contact">Contact us</a></li>
      </ul>
    </nav>

   
    <?php
// Assuming you have already established a database connection

// Check if project_id is set in the URL
if(isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    include '../php/connectdb.php';

    // Query to fetch project details based on project_id
    $project_query = "SELECT p.name AS project_name, p.project_url , p.description AS description
                      FROM projects p
                      WHERE p.project_id = $project_id";

    // Execute the project query
    $project_result = $conn->query($project_query);

    if ($project_result->num_rows > 0) {
        // Fetch project details
        $project_row = $project_result->fetch_assoc();
        $project_name = $project_row['project_name'];
        $description = $project_row['description'];
        $project_url = $project_row['project_url'];

        // Output project details
        echo '<div class="projects cert animate-left " id="Projects">';
        echo '      <div class="cont">';
        echo '<h3>' . $project_name . '</h3>';
        echo '<p>  </br> Features </br>';
        echo '<span>' . $description . '</span>';
        echo '</p>';
        echo '</div>';
        
        // Query to fetch images associated with the project
        $image_query = "SELECT path FROM pictures WHERE project_id = $project_id ";
        $image_result = $conn->query($image_query);
        
        // Check if there are any images
        if ($image_result->num_rows > 0) {
          // Output images dynamically
            $image_row = $image_result->fetch_assoc(); // Fetch the first row

            echo '<img id="projectImage" src="' . $image_row['path'] . '" alt="Project Image">';
           
            // echo '<img id="projectImage" alt="Project Image">';

?>
          <?php
// Begin the JavaScript block
echo '<script>';
// Define an array of image paths
echo 'var images = [';

// Loop through the image results and construct JavaScript array elements
while ($image_row = $image_result->fetch_assoc()) {
    echo '"' . $image_row['path'] . '",';
}

// Close the JavaScript array definition
echo '];';

// Initialize index to 0
echo 'var index = 0;';

// Function to change the image
echo 'function changeImage() {';
echo 'document.getElementById("projectImage").src = images[index];';
// echo 'index = (index + 1) % images.length;';
echo 'index = index + 1';
echo 'console.log(index)';

echo '}';

// Call the changeImage function every 3 seconds
echo 'setInterval(changeImage, 1500);';

// End the JavaScript block
echo '</script>';

?>

          <?php
          
        }
        // echo '</p>';
        
        echo '</div>';
        if (!empty($project_url)) {
          echo '<p class="url"> Project url: <a href="' . $project_url . '" target="_blank">' . $project_url . '</a></p>';
        }
      } else {
        header("Location: index.php");
      exit;
    }

 
}
?>

<hr>

  <!-- contact form  -->
      <main id="contact"> 
        <h4 >Contact us</h4> 
      <div class="contact-box">
        
        <div class="social-media animate-left">
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

        <?php include 'getmessage.php' ?>    
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



<!-- download button script  -->
<script>
  // Function to handle the download
function downloadFile() {
// Set the file URL
var fileURL = "../Zain AliCv .pdf"; // Replace with your file URL

// Create a link element
var link = document.createElement('a');

// Set the link's attributes
link.href = fileURL;
link.download = 'downloaded_file.pdf'; // Change the file name as needed

// Append the link to the document body
document.body.appendChild(link);

// Trigger the click event on the link
link.click();

// Remove the link from the document body
document.body.removeChild(link);
}

// Add event listener to the download button
document.getElementById('downloadBtn').addEventListener('click', downloadFile);


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

    const slider = document.querySelector('.image-slider');
  let slideIndex = 0;

  // Function to move to the next slide
  function nextSlide() {
    slideIndex++;
    if (slideIndex === slider.children.length) {
      slideIndex = 0;
    }
    updateSlider();
  }

  // Function to update slider position
  function updateSlider() {
    slider.style.left = `-${slideIndex * 100}%`;
  }

  // Automatic slide interval
  setInterval(nextSlide, 1000); // Change slide every 3 seconds

</script>