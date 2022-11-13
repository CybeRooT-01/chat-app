const form = document.querySelector(".saisie"),
champ = document.querySelector(".champ_saisie"),
sendBtn = document.querySelector("button"),
chatBox = document.querySelector(".chat-box")
form.addEventListener("submit", (e)=>{
    e.preventDefault(); //voila le submit ne casse plus la tete
})
sendBtn.addEventListener("click", ()=>{
    let xhr = new XMLHttpRequest(); //cree l'objet xml
    xhr.open("POST", "php/ajout-sms.php");
    xhr.addEventListener("load", ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
            champ.value="" //une fois le sms enregistrer, le champ de saisie sera vide a nouveau
            scrollEnBas()
            }

        }
    })
    //on envoie les donnés a php avec ajax
    let formData = new FormData(form);
    xhr.send(formData); //envoie a php
} )
chatBox.addEventListener("mouseenter", ()=>{
    //ajax appelle la fonction de scroll chaque 500ms donc il sera impossible de scroller en haut dcp on arrete l'appel
    chatBox.classList.add("active");
})
chatBox.addEventListener("mouseleave", ()=>{
    //ajax appelle la fonction de scroll chaque 500ms donc il sera impossible de scroller en haut dcp on arrete l'appel
    chatBox.classList.remove("active");
})

setInterval(() => {
    let xhr = new XMLHttpRequest(); //cree l'objet xml
    xhr.open("POST", "php/get-discussion.php",true); 
    xhr.addEventListener("load", ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                 //si la barre de recherche n'est pas active, on ajoute la data 
                chatBox.innerHTML = data
                if(!chatBox.classList.contains("active")){//si il n'est pas active
                    scrollEnBas();
                }
            }
        }
    })
        //on envoie les donnés a php avec ajax
    let formData = new FormData(form);
    xhr.send(formData); //envoie a php
}, 500); //sera executé chaque 1/2secondes

function scrollEnBas() {
    chatBox.scrollTop = chatBox.scrollHeight; //scroll directement vers le bas. (un ptit detail mais qui compte)
}