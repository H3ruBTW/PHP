let box = document.getElementById("box")
box.hidden = true

let button = document.getElementById("button")
let button2 = document.getElementById("cancel")
if(button != null){
    button.addEventListener("click", function(){
        box.hidden = false
        button.disabled = true
    })

    button2.addEventListener("click", function(){
        box.hidden = true
        button.disabled = false
    })
}
    

