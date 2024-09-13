let id = (id) => document.getElementById(id);

let fullname = id('name'),
company = id('companyName'),
email = id('email'),
phone = id('phonenr'),
student = id('studentOptions'),
form = id('form'),
nameError = id('nameError'),
companyError = id('companyError'),
emailError = id('emailError'),
phoneError = id('phoneError'),
studentError = id('studentError');
const selectMenu = document.querySelector(".select-selected");
const pattern = { 
    email:/^([a-zA-Z\d\.\-\_]+)@([a-zA-Z\d-]+)\.([a-zA-Z]{2,8})(\.[a-zA-Z]{2,8})?$/, phone:/^\+389([\d]{8,9})$/
}
const allInputs = document.querySelectorAll('input')


form.addEventListener('submit', e => {
    if (fullname.value === '' || fullname.value == null ) {
        nameError.classList.add("visible");
        fullname.style.outline = "2px solid rgb(233, 16, 9)";
        e.preventDefault();
    } else {
        fullname.style.outline = "2px solid #52c41a";
        nameError.classList.remove("visible");
    }


    if (company.value === '' || company.value == null){
        companyError.classList.add("visible");
        company.style.outline = "2px solid rgb(233, 16, 9)";
        e.preventDefault();
    } else {
        company.style.outline = "2px solid #52c41a";
        companyError.classList.remove("visible");
    }

    if (email.value === '' || email.value == null || pattern['email'].test(email.value)==false){
        emailError.classList.add("visible");
        email.style.outline = "2px solid rgb(233, 16, 9)";
        e.preventDefault();
    } else {
        email.style.outline = "2px solid #52c41a";
        emailError.classList.remove("visible");
    }

    if (phone.value === '' || phone.value == null || pattern['phone'].test(phone.value)==false){
        phoneError.classList.add("visible");
        phone.style.outline = "2px solid rgb(233, 16, 9)";
        e.preventDefault();
    } else {
        phone.style.outline = "2px solid #52c41a";
        phoneError.classList.remove("visible");

    }

    if(selectMenu.innerHTML=="Изберете тип на студент"){
        selectMenu.style.outline="2px solid rgb(233, 16, 9)";
        e.preventDefault();
        } else if (selectMenu.innerHTML!=="Изберете тип на студент"){
         selectMenu.style.outline="2px solid #52c41a";
        }
});


allInputs.forEach((input) => {
    input.addEventListener("keyup", (e) => {
        validate(e.target,pattern[e.target.attributes.name.value])
    })
});

function validate(field, regex){
    if(regex.test(field.value)){
        field.style.outline = "2px solid #52c41a";
    } else {
        field.style.outline = "2px solid rgb(233, 16, 9)"
    }
}