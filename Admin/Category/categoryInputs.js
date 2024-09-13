document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("category-form");
  
    form.addEventListener("submit", function (e) {
      const category = document.getElementById("category_input").value;

  
      let errorMessage = "";
  
      if (category.length < 2) {
        errorMessage += "Enter category!";
      }
  
      if (errorMessage) {
        e.preventDefault(); // Prevent refresh if theres errors
        Swal.fire({
          icon: "error",
          title: "Validation Error",
          text: errorMessage,
        });
      }
    });
  });
  