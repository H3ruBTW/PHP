document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    const submit = document.getElementById('button'); 
    const inputs = form.querySelectorAll('input[pattern], input[required]');
    

    function valida() {
        let valido = true;

        const nome = form.querySelector('input[name="name"]').value.toUpperCase();
        const cognome = form.querySelector('input[name="surname"]').value.toUpperCase();
        const username = form.querySelector('input[name="user"]');
        const userValue = username.value.toUpperCase();

        inputs.forEach(input => {
            

            if (input.hasAttribute('required') && input.value.trim() === "") {
                input.setAttribute('class', 'rosso'); 
                valido = false
            } else if (!input.checkValidity()) {
                input.setAttribute('class', 'rosso');
                valido = false 
            } else {
                input.setAttribute('class', '');
            }  
        });

        if(userValue.includes((nome!="") ? nome : " ") || userValue.includes((cognome!="") ? cognome : " ")){
            username.setAttribute('class', 'rosso'); 
            valido = false
        }

        return valido;
    }

    submit.addEventListener('click', function(event) {
        if(!valida()) event.preventDefault()
    });
});