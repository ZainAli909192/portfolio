<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Certificates </title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

    <script src="../js/form.js"></script>
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
     
    </head>

<body>
<?php 



session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // Redirect the user to the login page
    header('Location: login.php');
    exit;
  }
  include './sidebar.html';
  include './loader.html';
?>

  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Certificates</span>
      </div>
      
      <div class="profile-details">
        <img src="../img/profile.jpg" alt="">
        <span class="admin_name">Zain Ali</span>
      </div> 
    </nav>

        <?php




        // Include your database connection file
        include_once('../php/connectdb.php');
        
        // Query to fetch projects from the database
        $sql = "SELECT * FROM certificates";
        $result = $conn->query($sql);
        
        // Check if there are any projects
        if ($result->num_rows > 0) {
            // Output each project dynamically
            $i=1;
            ?> 
            <div class="table-container">
            <br>


              <a class="custom-btn"
              style="padding: 8px 10px; border-radius: 
                5px; text-decoration: none; 
                background: #0082e6;
                color:white;"
                href="./add-certificate.php">Add  certificate</a>
                
                <table class="responsive-table">
                <br>  
                <br>  
                <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Picture</th>
                    <th colspan='2'>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = $result->fetch_assoc()) { 
            
                echo '<tr class="details">';
                echo '<td>' . $i . '</a></td>';

                echo '<td>' . $row['name'] . '</a></td>';
                
                
                echo '<td> <img src=' . $row['path'] . ' alt='.$row['path'] .' height="60px" wdith="60px" style="border-radius:4%; "  /> </td>';
        
               
                echo '<td class="button">
                <a class="button" 
                style="padding: 6px; border-radius: 3px; text-decoration: none;"
                 href="./update-certificate.php?certificate_id=' . $row['id'] . '">Update</a>
            </td>';
      
                echo '<form method="post" >';
                echo '<input type="hidden" name="certificate_id" style="display:none" value="' . $row['id'] . '">';
                echo '<td > <a href="#"  class="danger"> 
                          <button 
                          type="submit" 
                          style=" outline:none; border:none; background-color:orange; padding:7px; color:white; text-decoration:none; border-radius:5px;" 
                          name="delete_certificate"
                          
                          
                          >
                                Delete</button> 
                          </a>
                 </td>';
                // echo '<td class="button">Delete </td>';
                echo '</form>';
                echo '</tr>';
                $i++;  
            }
            ?>
            </tbody>
            </table>
            </div>
          <?php 
          
        } else {
            // If no projects found, display a message
            echo '<p>No projects found.</p>';
        }
        

        if ( isset($_POST['delete_certificate'])) {
          // Get the ID of the message to be deleted
          $certificate_id = $_POST['certificate_id'];
          
          // Prepare a SQL query to delete the message from the database
          $delete_sql = "DELETE FROM certificates WHERE id = $certificate_id";
          // Execute the deletion query
          if ($conn->query($delete_sql) === TRUE) {
              $mesg= "certificate deleted successfully.";
          }
          else {
            echo "Error deleting certificate: " . $conn->error;
          }
        }        

        // Close the database connection
        // $conn->close();
        ?>
        
  
      </section>


</body>
</html>


<script>
    let sidebar = document.querySelector(".sidebar");
 let sidebarBtn = document.querySelector(".sidebarBtn");
 sidebarBtn.onclick = function() {
   sidebar.classList.toggle("active");
   if(sidebar.classList.contains("active")){
   sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
 }else
   sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
 }
  </script>