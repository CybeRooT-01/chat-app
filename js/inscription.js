const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error_zone");
form.addEventListener("submit", (e)=>{
    e.preventDefault(); //voila le submit ne casse plus la tete
})
continueBtn.addEventListener("click" , ()=>{
    let xhr = new XMLHttpRequest(); //cree l'objet xml
    xhr.open("POST", "php/inscription.php");
    xhr.addEventListener("load", ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(data == "success"){
                    location.href = "profil.php"
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    })
    //on envoie les donnés a php avec ajax
    let formData = new FormData(form);
    xhr.send(formData); //envoie a php
})