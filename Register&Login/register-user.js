document.addEventListener("DOMContentLoaded", function () {
  // FORM
  const emailInput = document.getElementById("email");
  const usernameInput = document.getElementById("username");
  const passwordInput = document.getElementById("password");
  const registerBtn = document.getElementById("register-btn");

  // ERRORS
  const emailErrorMessage = document.getElementById("email-error");
  const usernameErrorMessage = document.getElementById("username-error");
  const passwordErrorMessage = document.getElementById("password-error");

  registerBtn.disabled = true;


  usernameInput.addEventListener("blur", async function () {
    const enteredUsername = usernameInput.value;

    if (enteredUsername.trim() === "") {
      usernameErrorMessage.textContent = "Username can't be empty";
      usernameInput.classList.remove("valid-border");
      usernameInput.classList.add("error-border");
      registerBtn.disabled = true;
      return;
    } else {
      usernameErrorMessage.textContent = "";
      usernameInput.classList.remove("error-border");
      usernameInput.classList.add("valid-border");
      enableRegisterBtn();
    }
  });

  emailInput.addEventListener("blur", async function () {
    const enteredEmail = emailInput.value;

    if (enteredEmail.trim() === "" || !enteredEmail.includes("@")) {
      emailErrorMessage.textContent = "Enter a valid email";
      emailInput.classList.remove("valid-border");
      emailInput.classList.add("error-border");
      registerBtn.disabled = true;
      return;
    } else {
      emailErrorMessage.textContent = "";
      emailInput.classList.remove("error-border");
      emailInput.classList.add("valid-border");
      enableRegisterBtn();
    }
  });

  passwordInput.addEventListener("keyup", function () {
    const enteredPassword = passwordInput.value;

    if (
      enteredPassword.length < 8 ||
      !/\d/.test(enteredPassword) ||
      !/[A-Z]/.test(enteredPassword) ||
      !/[!@#$%^&*]/.test(enteredPassword)
    ) {
      passwordErrorMessage.textContent =
        "Password must contain at least 6 characters, one number, uppercase letter and one special sign.";
      emailInput.classList.remove("valid-border");
      passwordInput.classList.add("error-border");
      registerBtn.disabled = true;
    } else {
        passwordErrorMessage.textContent = "";
        passwordInput.classList.remove("error-border");
        passwordInput.classList.add("valid-border");
        enableRegisterBtn();
    }
  });

  function enableRegisterBtn() {
    if (
      emailErrorMessage.textContent === "" &&
      usernameErrorMessage.textContent === "" &&
      passwordErrorMessage.textContent === ""
    ) {
      registerBtn.disabled = false;
    } else {
      registerBtn.disabled = true;
    }
  }
});
