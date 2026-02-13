function funcFetch(){
    document.body.classList.add("loading");
    document.getElementById("loader").style.display = "block";

    fetch('APIfetch.php')
    .then(res => res.json())
    .then(data => {
        document.body.classList.remove("loading");
        document.getElementById("loader").style.display = "none";

        if (data.errore) {
            document.getElementById('content').innerHTML = `<p style="color:red"><strong>Nome:</strong>${data.errore}</p>`
        } else {
            document.getElementById('content').innerHTML = `
            <p><strong>Nome:</strong> ${data.Nome}</p>
            <p><strong>Email:</strong> ${data.Email}</p>
            `
        }
    })
    .catch(error => {
        document.body.classList.remove("loading");
        document.getElementById("loader").style.display = "none";

        console.error('Errore:', error)
        document.getElementById('content').innerHTML = '<p style="color:red"><strong>Nome:</strong>Errore durante il caricamento.</p>'
    })
}

let button = document.getElementById("button")
button.addEventListener("click", funcFetch)