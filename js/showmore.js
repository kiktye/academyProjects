const cards = document.querySelectorAll(".card")
let showMoreBtn = document.querySelector(".showMore")
let visibleCards = 6;
showMoreBtn.addEventListener("click", function(){
    for (let i = visibleCards; i < visibleCards + 6; i++){
        if(cards[i]){
            cards[i].style.display = "block";
        }
    }
    visibleCards += 6;
    if(visibleCards >= cards.length){
       showMoreBtn.style.display = "none"
    }
})

