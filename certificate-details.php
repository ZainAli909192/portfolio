<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Certificate detail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/cards.css">
    <link rel="stylesheet" href="../css/loader.css">
    <link rel="stylesheet" href="../css/projects.css">
    <!-- <link rel="stylesheet" href="../Zain AliCv .pdf"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

    <!-- cards css  -->


  </head>
  <body> 
    <?php include 'loader.html' ?>
    <nav id="nav">
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo-img">

      <img src="../img/profile.jpg" class="logo-img"/>
      </label>
      <ul>  
        <li ><a class="active" href="index.php">Home</a></li>
        <li><a onclick="closeNavbar()" href="#contact">Contact us</a></li>
      </ul>
    </nav>

   
    <?php
// Assuming you have already established a database connection

// Check if project_id is set in the URL
if(isset($_GET['certificate_id'])) {
    $certificate_id = $_GET['certificate_id'];
    include '../php/connectdb.php';

    // Query to fetch certificate details based on project_id
    $project_query = "SELECT *
                      FROM certificates p
                      WHERE p.id = $certificate_id";

    // Execute the project query
    $project_result = $conn->query($project_query);

    if ($project_result->num_rows > 0) {
        // Fetch project details
        $project_row = $project_result->fetch_assoc();
        $name = $project_row['name'];
        $date = $project_row['date'];
        $institute = $project_row['institution'];
        $path = $project_row['path'];

        // Output project details
        echo '<div class="projects cert animate-left" id="Projects">';
        echo '      <div class="cont">';
        echo '<h3>Certificate Name: ' . $name . ' </h3>';
        echo '<p class="date">  Date:  <span> '. $date .' </span> </p>';
        echo '<p class= "cer">Institute:  '. $institute .'  </p>';
        
        echo '</div>';
        echo '<img src="' . $path . '" alt="Certificate Image" >';
        // Check if there are any images
                
              echo '</div>';
    } else {
        echo "No project found with the provided project_id.";
    }
} else {
    echo "No project_id provided in the URL.";
}
?>

<hr>

  <!-- contact form  -->
      <main id="contact"> 
        <h4 >Contact us</h4> 
      <div class="contact-box">
        
        <div class="social-media">
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
            </a>      
              </div>
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