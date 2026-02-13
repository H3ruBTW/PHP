let box = document.getElementById("box")
box.hidden = true

let button = document.getElementById("button")
if(button.dataset.b == "button"){
    button.addEventListener("click", function(){
        box.hidden = false
        button.disabled = true
    })
}



let button2 = document.getElementById("button3")
if(button2.dataset.b === "button"){
    button2.addEventListener("click", function(){
        box.hidden = true
        button.disabled = false
    })
}
