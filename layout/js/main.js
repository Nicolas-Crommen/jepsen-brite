const btnLogin = document.querySelector(".login-page .login-btn");
const btnSignUp = document.querySelector(".login-page .singup-btn");
const formLogn = document.querySelector(".login-page .login");
const formSignup = document.querySelector(".login-page .signup");
const confirm = document.querySelector(".confirm");
const dropMenuCat = document.getElementById("formSub");
const categoriesColor = document.querySelectorAll(".btns-cat ul li a");

if (formLogn || formSignup) {
  formLogn.style.display = "none";
  btnSignUp.style.color = "#5cb85c";

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
}

/*Show password*/

let eye = document.querySelector(".form-group i");
let passLogin = document.querySelector(".pass-login");

if (eye) {
  eye.addEventListener("click", () => {
    console.log(passLogin.type);

    if (passLogin.type == "password") {
      passLogin.setAttribute("type", "text");
      eye.setAttribute("class", "fas fa-eye");
    } else {
      passLogin.setAttribute("type", "password");
      eye.setAttribute("class", "fas fa-eye-slash");
    }
  });
}

if (document.getElementById("btnDelete")) {
  document.getElementById("btnDelete").addEventListener("click", () => {
    alert("Do you want really delete your account");
  });
}

if (categoriesColor) {
  const colors = ["#eb4d4b", "#4834d4", "#2ecc71", "#f1c40f", "#1abc9c"];
  const arrayCat = [...categoriesColor];

  for (let i = 0; i < categoriesColor.length; i++) {
    arrayCat[i].style.backgroundColor = colors[i];
  }
}
