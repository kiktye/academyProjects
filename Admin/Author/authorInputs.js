document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("author-form");
  
    form.addEventListener("submit", function (e) {
      const firstName = document.getElementById("author_first_name").value;
      const lastName = document.getElementById("author_last_name").value;
      const shortBio = document.getElementById("author_biography").value;
  
      let errorMessage = "";
  
      if (firstName.length < 2) {
        errorMessage += "First name must be at least 2 characters long.\n";
      }
  
      if (lastName.length < 2) {
        errorMessage += "Last name must be at least 2 characters long.\n";
      }
  
      if (shortBio.length < 20) {
        errorMessage += "Author biography must be at least 20 characters long.\n";
      }
  
      if (errorMessage) {
        e.preventDefault(); // Prevent refresh if there is errors
        Swal.fire({
          icon: "error",
          title: "Validation Error",
          text: errorMessage,
        });
      }
    });
  });
  