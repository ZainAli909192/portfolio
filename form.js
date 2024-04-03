function validateForm() {
  var author = document.getElementById("author").value;
  var title = document.getElementById("title").value;
  var purpose = document.getElementById("purpose").value;
  var notes = document.getElementById("notes").value;
  
  var authorError = document.getElementById("authorError");
  var titleError = document.getElementById("titleError");
  var purposeError = document.getElementById("purposeError");
  var notesError = document.getElementById("notesError");
  
  authorError.innerHTML = titleError.innerHTML = purposeError.innerHTML = notesError.innerHTML = "";
  
  if (author === "") {
    authorError.innerHTML = "Name is required";
    return false;
  }
 else if (title === "") {
    titleError.innerHTML = "Title is required";
    return false;
  }
  else  if (document.getElementById("purposeLabel").style.display !== "none" && purpose === "") {
    purposeError.innerHTML = "Purpose is required";
    return false;
  }
  else if (notes === "") {
    notesError.innerHTML = "Notes are required";
    return false;
  }
  showpopup();
  // Save data to local storage
  var noteData = {
    author: author,
    title: title,
    purpose: purpose,
    notes: notes
  };
  var allNotes = JSON.parse(localStorage.getItem('allNotes')) || [];
  allNotes.push(noteData);
  localStorage.setItem('allNotes', JSON.stringify(allNotes));
  
  // Optionally, clear form fields after submission
  document.getElementById("noteForm").reset();
  
  return true;
}

function togglePurposeField() {
  var title = document.getElementById("title").value;
  var purposeLabel = document.getElementById("purposeLabel");
  var purpose = document.getElementById("purpose");
  
  if (title.trim() !== "") {
    purposeLabel.style.display = "block";
    purpose.style.display = "block";
  } else {
    purposeLabel.style.display = "none";
    purpose.style.display = "none";
  }
}
function togglePurposeField2() {
  var title = document.getElementById("title").value;
  var purposeLabel = document.getElementById("purposeLabel2");
  var purpose = document.getElementById("purpose2");
  
  if (title.trim() !== "") {
    purposeLabel.style.display = "block";
    purpose.style.display = "block";
  } else {
    purposeLabel.style.display = "none";
    purpose.style.display = "none";
  }
}

            document.getElementById("deleteData").addEventListener("click", function(event) {
  event.preventDefault(); // Prevent the default behavior of the link
  
  if (confirm("Are you sure you want to delete all data?")) {
    localStorage.removeItem("allNotes");
    alert("All data has been deleted.");
  }
});

// Get the navbar element
const navbar = document.getElementById('nav');

// Define the initial height of the navbar
let navbarHeight = navbar.offsetHeight;

// Listen for the scroll event
window.addEventListener('scroll', function() {
  // Check if the user has scrolled past a certain threshold (e.g., 100px)
  if (window.scrollY >= 50) {
    // Reduce the height of the navbar
    navbar.classList.add('navbar-scroll');
  } else {
    // Restore the original height of the navbar
    navbar.classList.remove('navbar-scroll');
  }
});
