document.querySelector("#filter-marketing").addEventListener("change", filterMarketing)
document.querySelector("#filter-coding").addEventListener("change", filterCoding)
document.querySelector("#filter-design").addEventListener("change", filterDesign)


function filterMarketing() {
    hideAllCards();

    if(document.querySelector("#filter-marketing").checked) {
        var marketingCards = document.querySelectorAll(".marketing");
        marketingCards.forEach(marketingCard => {
            marketingCard.style.display = "block";
        });

        

        document.querySelector("#filter-coding").checked = false;
        document.querySelector("#filter-design").checked = false;
    } else {
        showAllCards();
    }        
    }


    function filterCoding() {
        hideAllCards();

        if(document.querySelector("#filter-coding").checked) {
            var codingCards = document.querySelectorAll(".coding");
            codingCards.forEach(codingCard => {
                codingCard.style.display = "block";
            });

            document.querySelector("#filter-marketing").checked = false;
            document.querySelector("#filter-design").checked = false;
        } else{
            showAllCards();
        }
        }
    

    function filterDesign() {
        hideAllCards();

        if(document.querySelector("#filter-design").checked) {
            var designCards = document.querySelectorAll(".design");
            designCards.forEach(designCard => {
                designCard.style.display = "block";
            });

            document.querySelector("#filter-marketing").checked = false;
            document.querySelector("#filter-coding").checked = false;
        } else {
            showAllCards();
        }
    }

    function hideAllCards() {
        var allCards = document.querySelectorAll(".card");

        allCards.forEach( card => {
            card.style.display = "none"
        });
    }

    function showAllCards() {
        var allCards = document.querySelectorAll(".card");

        allCards.forEach(card => {
            card.style.display ="block"
        });
    }