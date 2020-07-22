const btnLogin = document.querySelector(".login-page .login-btn");
const btnSignUp = document.querySelector(".login-page .singup-btn");
const formLogn = document.querySelector(".login-page .login");
const formSignup = document.querySelector(".login-page .signup");
formSignup.style.display = "none";
btnLogin.style.color = "#337ab7";

btnLogin.addEventListener("click", () => {
  formSignup.style.display = "none";
  formLogn.style.display = "block";
  btnLogin.style.color = "#337ab7";
  btnSignUp.style.color = "#ccc";
});

btnSignUp.addEventListener("click", () => {
  formSignup.style.display = "block";
  formLogn.style.display = "none";
  btnSignUp.style.color = "#5cb85c";
  btnLogin.style.color = "#ccc";
});

console.log(btnLogin);
console.log(btnSignUp);
console.log(formLogn);
console.log(formSignup);
