const passwd = document.querySelector(".form input[type='password']");
togglebtn = document.querySelector(".form .field i");
togglebtn.addEventListener("click", ()=>{
    if (passwd.type == "password") {
        passwd.type = "text";
        togglebtn.classList.add("active");
    }else{
        passwd.type = "password";
        togglebtn.classList.remove("active");
    }
})