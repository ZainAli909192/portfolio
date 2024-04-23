
<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Zain Ali</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/form.css">
    <!-- <link rel="stylesheet" href="../Zain AliCv .pdf"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  
    <!-- cards css  -->
    <link rel="stylesheet" href="../css/popup.css">
    <link rel="stylesheet" href="../css/cards.css">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

  </head>
  <body> 
  <?php include 'loader.html' ?>


<div class="popup-screen">
        <div class="popup-box">
            <!-- <i class="fas fa-times close-btn"></i> -->
            <img src="../img/tick.png" height="45px" alt="">
         
            <p class="mesg">
                
            </p>
            <button class=" butt close-btn">Ok</button>
            <!-- <a href="#" class="btn close-btn">Ok</a> -->
        </div>
  </div>
  <nav id="nav">
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo">Zain  Ali</label>
      <ul>  
        <li ><a class="active" onclick="closeNavbar()" href="#">About me</a></li>

        <?php
// Assuming you have already connected to the database
include '../php/connectdb.php';
// Query to fetch links from the navlinks table
$sql = "SELECT * FROM navlinks where status='Show'";
$result = $conn->query($sql);

// Check if there are any links
if ($result->num_rows > 0) {
    // Output each link dynamically
    while ($row = $result->fetch_assoc()) {
        echo '<li><a onclick="closeNavbar()" href="#' . $row['name'] . '">' . $row['name'] . ' </a></li>';
    }
} else {
    echo 'No links found.';
}
?>
        <li><a href="#contact" onclick="closeNavbar()">Contact us</a></li>
      </ul>
    </nav>

    <!-- About section -->
    <section class="about-section">
        <div class="container">
          
          <div class="about-image"> 
            <img src="../img/profile.jpg" class="animate-left" alt="Profile Image">
          </div>
          <div class="about-content">
            <p class="animate-right">
             
As a devoted and energized web developer, my focus is on crafting compelling and user-friendly digital interfaces. 
Grounded in a solid understanding of
                   <!-- <br>  -->
                
                <span id="typing-text"></span>

              </p>

             
          <div>
            <button class=" animate-right button" id="downloadBtn" >Download CV</button>
          </div>
          </div>
        </div>
      </section>
      <!-- projects  -->
      <?php
// Assuming you have already established a database connection

// Fetch the status of the "Projects" navlink from the database
$sqlStatusProjects = "SELECT status FROM navlinks WHERE name = 'Projects'";
$resultStatusProjects = $conn->query($sqlStatusProjects);

// Check if the query was successful and if there is a row returned
if ($resultStatusProjects && $resultStatusProjects->num_rows > 0) {
    $rowStatusProjects = $resultStatusProjects->fetch_assoc();
    $statusProjects = $rowStatusProjects['status'];

    // Check if the status is "show"
    if ($statusProjects == "show") {
        // If the status is "show", display the "Projects" section
        echo '
        <div class="projects" id="Projects">
            <hr>
            <p> Projects</p>
            <div class="card-list">';

        // Query to fetch project names and corresponding image paths (limit to 1 image per project)
        $sqlProjects = "SELECT p.project_id AS project_id, p.name AS project_name, pic.path AS image_path
                        FROM projects p
                        INNER JOIN pictures pic ON p.project_id = pic.project_id
                        GROUP BY p.project_id
                        LIMIT 8"; // Limit to 1 image per project
        $resultProjects = $conn->query($sqlProjects);

        // Check if there are any projects
        if ($resultProjects->num_rows > 0) {
            // Output each project dynamically
            while ($rowProjects = $resultProjects->fetch_assoc()) {
                echo '<a href="project-details.php?project_id=' . $rowProjects['project_id'] . '" class="card-item animate-left">';
                echo '<img src="' . $rowProjects['image_path'] . '" alt="Card Image" >';
                echo '<h5>' . $rowProjects['project_name'] . '</h5>';
                echo '<div class="arrow">Details</div>';
                echo '</a>';
            }
            echo '<a href="showall-projects.php">';
            echo '<button class="btnn">See All</button>';
            echo '</a>';
        } else {
            // If no projects are found, display a message
            echo 'No projects found.';
        }

        echo '</div></div>'; // Close the projects and card-list divs for the "Projects" section
    }
} 
// Close the database connection
// $conn->close();
?>


<!-- Certificates Section -->
<?php
// Assuming you have already established a database connection

// Fetch the status of the "Certificates" navlink from the database
$sqlStatus = "SELECT status FROM navlinks WHERE name = 'Certificates'";
$resultStatus = $conn->query($sqlStatus);

// Check if the query was successful and if there is a row returned
if ($resultStatus && $resultStatus->num_rows > 0) {
    $rowStatus = $resultStatus->fetch_assoc();
    $status = $rowStatus['status'];

    // Check if the status is "show"
    if ($status == "show") {
        // If the status is "show", display the "Certificates" section
        echo '
        <div class="projects" id="Certificates">
            <hr>
            <p>Certificates</p>
            <div class="card-list">';

        // Fetch data from the 'certificates' table
        $sqlCertificates = "SELECT id, name, path FROM certificates";
        $resultCertificates = $conn->query($sqlCertificates);

        // Check if there are any rows returned
        if ($resultCertificates->num_rows > 0) {
            // Loop through each row of data
            while ($rowCertificates = $resultCertificates->fetch_assoc()) {
                // Output the HTML structure for each certificate
                echo '<a href="certificate-details.php?certificate_id=' . $rowCertificates['id'] . '" class="card-item animate-right">';
                echo '<img src="' . $rowCertificates['path'] . '" alt="Certificate Image">';
                echo '<h5>' . $rowCertificates['name'] . '</h5>';
                echo '<div class="arrow">View</div>';
                echo '</a>';
            }
        } else {
            // If no certificates are found, display a message
            echo "No certificates available.";
        }

        echo '</div></div>'; // Close the projects and card-list divs for the "Certificates" section
    }
}

// Close the database connection
// $conn->close();
?>



<?php
// Assuming you have already established a database connection

// Fetch the status of the "Services" navlink from the database
$sqlStatus = "SELECT status FROM navlinks WHERE name = 'Services'";
$resultStatus = $conn->query($sqlStatus);

// Check if the query was successful and if there is a row returned
if ($resultStatus && $resultStatus->num_rows > 0) {
    $rowStatus = $resultStatus->fetch_assoc();
    $status = $rowStatus['status'];

    // Check if the status is "show"
    if ($status == "show") {
        // If the status is "show", display the "Services" section
        echo '
        <!-- Services  -->
        <div class="projects" id="Services">
            <hr>
            <p>Services</p>
            <div class="card-list">';

        // Fetch data from the 'services' table
        $sqlServices = "SELECT name, path FROM services";
        $resultServices = $conn->query($sqlServices);

        // Check if there are any rows returned
        if ($resultServices->num_rows > 0) {
            // Loop through each row of data
            while ($rowServices = $resultServices->fetch_assoc()) {
                // Output the HTML structure for each service
                echo '<a href="#contact" class="card-item">';
                echo '<img src="' . $rowServices['path'] . '" alt="Card Image">';
                echo '<h5>' . $rowServices['name'] . '</h5>';
                echo '<div class="arrow">Get service</div>';
                echo '</a>';
            }
        } else {
            // If no services are found, display a message
            echo "No services available.";
        }

        echo '</div></div>'; // Close the projects and card-list divs for the "Services" section
    }
}

// Close the database connection
$conn->close();
?>

<hr>

  <!-- contact form  -->
      <main id="contact"> 
        <h4 >Contact us</h4> 
      <div class="contact-box ">
        
        <div class="social-media  animate-left">
        <b>  Social media </b>
          <div>
            <a href="https://wa.me/923250679080" target="_blank">
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

    showloader();
    // Set the file URL dynamically from PHP
   setTimeout(() => {
     var fileURL = "<?php echo $cvPath; ?>"; // File URL retrieved from the database
    // var fileURL = "../Zain AliCV.pdf"; // File URL retrieved from the database
  // alert( "err")
    // Check if the file URL is not empty
    if (fileURL !== "") {
      showpopup("My Cv is downloaded...");
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
   }, 2000);
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
      revealElement.classList.add('animate-right');
    } else if (revealPosition > windowHeight) {
      revealElement.classList.remove('animate-right');
    }
  }
}

// Call revealOnScroll when the page loads
document.addEventListener('DOMContentLoaded', revealOnScroll);

// Call revealOnScroll when the user scrolls the page
window.addEventListener('scroll', revealOnScroll);



function closeNavbar() {
      document.getElementById('check').checked = false;
    }

  // Define a flag variable to track whether the redirection has occurred
// let redirectOccured = true;
// Check if the redirect has occurred before

// });     
// setTimeout(() => {
  
//   sessionStorage.setItem('redirectOccured', false);

// }, 4000);
</script>