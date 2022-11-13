const search = document.querySelector(".users .search input"),
searchBtn = document.querySelector(".users .search button"),
userList = document.querySelector(".users .user_list");
searchBtn.addEventListener("click", ()=>{
    search.classList.toggle("active");
    search.focus();
    searchBtn.classList.toggle("active");
})
search.addEventListener("keyup", ()=>{
    let recherche = search.value;
    if(recherche != ""){
        search.classList.add("active")
    }else{
        search.classList.remove("active")
    }
    let xhr = new XMLHttpRequest(); //cree l'objet xml
    xhr.open("POST", "php/search.php",true); 
    xhr.addEventListener("load", ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                userList.innerHTML = data;
            }
        }
    })
    /*on envoie la recherche sur search.php sinon $_Post va gueuler disant oué
    je connais pas la clé recherche sur le $_POST["recherche"] gnagnagnagnagnagna... bref*/
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xhr.send("recherche="+ recherche);
})
setInterval(() => {
    let xhr = new XMLHttpRequest(); //cree l'objet xml
    xhr.open("GET", "php/profil.php",true); //on va plutot partit sur un GET on recoit des donnés
    xhr.addEventListener("load", ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                 //si la barre de recherche n'est pas active, on ajoute la data 
                if (!search.classList.contains("active")) {
                    userList.innerHTML = data;//sinon le setinterval va se reexecuter et gacher la reecherche
                }
            }
        }
    })
    xhr.send();
}, 500); //sera executé chaque 1/2secondes
