<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Message </title>
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
        <span class="dashboard">Messages</span>
      </div>
      <div class="profile-details">
        <img src="../img/profile.jpg" alt="">
        <span class="admin_name">Zain Ali</span>
      </div> 
    </nav>

 
    <!-- <div class="home-content"> -->
      <!-- <div class="sales-boxes">
        <div class="recent-sales box">
          <div class="title">All Messages</div>
          <div class="sales-details">
          <div class="table-respnsive"> -->
            
<!-- // Include your database connection file -->
<?php
include_once('../php/connectdb.php');

if ( isset($_POST['delete_message'])) {
  // Get the ID of the message to be deleted
  $message_id = $_POST['message_id'];
  
  // Prepare a SQL query to delete the message from the database
  $delete_sql = "DELETE FROM messages WHERE id = $message_id";
  // Execute the deletion query
  if ($conn->query($delete_sql) === TRUE) {
      $mesg= "Message deleted successfully.";
 ?>
<script>
  alert("Message deleted successfully")
</script>
 <?php
    } else {
      echo "Error deleting message: " . $conn->error;
  }
}

// Query to fetch messages from the database
$sql = "SELECT * FROM messages";
$result = $conn->query($sql);

// Check if there are any messages
if ($result->num_rows > 0) {
    // Output each message dynamically
    $i=1;
    ?>
    <div class="table-container">
    <table class="responsive-table">
    <thead>
        <tr>
            <th>Sr. No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th colspan='2'>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    while ($row = $result->fetch_assoc()) { 
    
        echo '<tr class="details">';
        echo '<td>' . $i . '</a></td>';
        echo '<td>' . $row['name'] . '</a></td>';

        echo '<td>' . $row['email'] . '</a></td>';

        echo '<td>' . $row['message'] . '</a></td>';

        $subject = 'Reply of your query From Zain Ali';
        $body = 'Dear ' . $row['name'] . ',';
        echo '<td class="button" >
        <a class="button" style="padding:6px; border-radius:3px; text-decoration:none;" href="mailto:' . $row['email'] . '?subject=' . $subject . '&body=' . $body . '">Reply</a>
        </td>
        ';
        echo '<form method="post" >';
        echo '<input type="hidden" name="message_id" style="display:none" value="' . $row['id'] . '">';
        echo '<td > <a href="#" > 
                  <button type="submit" style=" outline:none; border:none; background-color:orange; padding:7px; color:white; text-decoration:none; border-radius:5px;" name="delete_message">
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
    // If no messages found, display a message
    echo '<p>No messages found.</p>';
}

// Close the database connection
$conn->close();
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