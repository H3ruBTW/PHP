if(window.tab == 2){
    let buttons = document.querySelectorAll("td button");

    // Aggiunge un listener a ogni bottone nella tabella
    buttons.forEach(button => {
        button.addEventListener("click", function Handle(event){

            let index = button.id // Ottiene l'ID del bottone cliccato

            button.innerHTML = "CONFIRM UPDATE" // Cambia il testo del bottone

            event.target.removeEventListener("click", Handle) // Rimuove il listener corrente

            // Seleziona tutte le celle della riga corrispondente all'ID
            let texts = document.querySelectorAll("tr#" + CSS.escape(index) + " td")

            // Itera sulle celle della riga, escludendo le ultime due colonne
            for(let j=0; j<texts.length-2; j++){
                if(j==6){continue} // Salta la colonna password

                let text = texts[j].textContent // Ottiene il contenuto della cella

                // Sostituisce il contenuto della cella con un'area di testo
                texts[j].innerHTML = "<textarea cols=\"12\" rows=\"5\" style=\"resize:none\">" + text + "</textarea>";
            }

            // Aggiunge un nuovo listener per confermare l'aggiornamento
            button.addEventListener("click", function Handle2(){
                let texts = document.querySelectorAll("tr#" + CSS.escape(index) + " td textarea") // Seleziona tutte le aree di testo
                let inputs = document.querySelectorAll("tr#" + CSS.escape(index) + " td form input") // Seleziona tutti gli input del form

                // Aggiorna i valori degli input con i dati delle aree di testo
                for(let j=0; j<texts.length; j++){
                    let text = texts[j].value
                    inputs[j].setAttribute("value", text)
                }

                let thisform = document.getElementById("mod" + index) // Seleziona il form corrispondente
                thisform.submit() // Invia il form
            })
        })
    });

    // Ordinamento delle colonne della tabella
    let keys = document.querySelectorAll("tr#keys th")

    keys.forEach (key => {
        if(key.innerHTML != "Modifica" && key.innerHTML != "Cancella"){ // Esclude la colonna "Modifica" e "Cancella"
            key.addEventListener("click", function(){
                let url

                // Determina l'ordine (ascendente o discendente) in base al valore corrente
                if(window.di == "i" && window.orderby == key.innerHTML){
                    url = "Pannello.php?id=2&orderby=" + key.innerHTML + "&di=d"               
                } else {
                    url = "Pannello.php?id=2&orderby=" + key.innerHTML + "&di=i"  
                }

                // Cambia la pagina con i nuovi parametri di ordinamento
                window.location.href = url + "&pag=" + window.pag
            })
        }
    })

    // Gestione dei bottoni per la cancellazione
    let delButtons = document.querySelectorAll("td input[type^=\"button\"]")
    
    delButtons.forEach(dbtn => {
        dbtn.addEventListener("click", function Handle3(event){
            dbtn.value = "CONFIRM\nDELETE" // Cambia il testo del bottone
            dbtn.setAttribute("type", "submit") // Cambia il tipo del bottone a "submit"

            event.preventDefault() // Previene il comportamento predefinito

            event.target.removeEventListener("click", Handle3) // Rimuove il listener corrente
        })
    });

    let displaybox = document.getElementById("displaybox")

    // Mostra il displaybox se ha una classe assegnata
    if(displaybox.getAttribute("class") != ""){
        displaybox.hidden = false
    }
}

// Gestione della tab 3
if(window.tab == 3){
    let displaybox = document.getElementById("displaybox")

    let buttons = document.querySelectorAll("td button");

    // Aggiunge un listener a ogni bottone nella tabella
    buttons.forEach(button => {
        button.addEventListener("click", function Handle(event){

            let index = button.id // Ottiene l'ID del bottone cliccato

            button.innerHTML = "CONFIRM UPDATE" // Cambia il testo del bottone

            event.target.removeEventListener("click", Handle) // Rimuove il listener corrente

            // Seleziona tutte le celle della riga corrispondente all'ID
            let texts = document.querySelectorAll("tr#" + CSS.escape(index) + " td")

            // Itera sulle celle della riga, escludendo le ultime due colonne
            for(let j=0; j<texts.length-2; j++){
                if(j==6){continue} // Salta la colonna Password

                let text = texts[j].textContent // Ottiene il contenuto della cella
                let olddata = texts[j].dataset.old // Ottiene il valore precedente dai dati della cella

                // Sostituisce il contenuto della cella con un'area di testo
                texts[j].innerHTML = "<textarea data-old=\"" + olddata + "\" cols=\"12\" rows=\"5\" style=\"resize:none\">" + text + "</textarea>";
            }

            // Aggiunge un nuovo listener per confermare l'aggiornamento
            button.addEventListener("click", function Handle2(event){
                let displaybox = document.getElementById("displaybox")
                let textareas = document.querySelectorAll("tr#" + CSS.escape(index) + " td textarea") // Seleziona tutte le aree di testo
                let texts = document.querySelectorAll("tr#" + CSS.escape(index) + " td") // Seleziona tutte le celle della riga

                let inputs = document.querySelectorAll("tr#" + CSS.escape(index) + " td form input") // Seleziona tutti gli input del form

                // Aggiorna i valori degli input con i dati delle aree di testo
                for(let j=0; j<textareas.length; j++){
                    let text = textareas[j].value
                    inputs[j].value = text
                }

                let thisform = document.getElementById("mod" + index) // Seleziona il form corrispondente
                let dataform = new FormData(thisform) // Crea un oggetto FormData con i dati del form

                // Mostra un loader durante l'invio dei dati
                document.body.classList.add("loading");
                document.getElementById("loader").style.display = "block";

                // Invia i dati al server tramite fetch
                fetch(
                    "updatetable.php", 
                    {method: "POST", body: dataform}
                ).then(response => {
                    displaybox.className = ""
                    void displaybox.offsetWidth // Resetta l'animazione
                    if (!response.ok) {
                        return response.text().then(text => { throw new Error(text) })
                    }
                    return response.text() // Riceve i dati ottenuti
                }).then(data => {
                    document.body.classList.remove("loading");
                    document.getElementById("loader").style.display = "none";

                    displaybox.querySelector("p").textContent = data // Mostra il messaggio di successo
                    displaybox.hidden = false
                    displaybox.classList.add("succ")

                    // Aggiorna i dati nella tabella con i nuovi valori
                    for(let j=0; j<textareas.length; j++){

                        let text = textareas[j].value
                        if(j<6){
                            texts[j].innerHTML = text
                            texts[j].dataset.old = text
                        } else {
                            texts[j+1].innerHTML = text
                            texts[j+1].dataset.old = text
                        }
                    }

                }).catch(error =>{
                    document.body.classList.remove("loading");
                    document.getElementById("loader").style.display = "none";

                    displaybox.querySelector("p").textContent = error // Mostra il messaggio di errore
                    displaybox.hidden = false
                    displaybox.classList.add("err")

                    // Ripristina i valori precedenti in caso di errore
                    textareas.forEach(textarea => {
                        textarea.value = textarea.dataset.old
                    });

                    for(let j=0; j<textareas.length; j++){

                        let text = textareas[j].value
                        if(j<6)
                            texts[j].innerHTML = text
                        else
                            texts[j+1].innerHTML = text
                    }
                })

                event.target.removeEventListener("click", Handle2) // Rimuove il listener corrente

                button.innerHTML = "UPDATE" // Ripristina il testo del bottone

                event.target.addEventListener("click", Handle) // Aggiunge nuovamente il listener iniziale
            })
        })
    });

    // Ordinamento delle colonne della tabella
    let keys = document.querySelectorAll("tr#keys th")

    keys.forEach (key => {
        if(key.innerHTML != "Modifica" && key.innerHTML != "Cancella"){ // Esclude la colonna "Modifica" e "Cancella"
            key.addEventListener("click", function(){
                let url

                // Determina l'ordine (ascendente o discendente) in base al valore corrente
                if(window.di == "i" && window.orderby == key.innerHTML){
                    url = "Pannello.php?id=3&orderby=" + key.innerHTML + "&di=d"               
                } else {
                    url = "Pannello.php?id=3&orderby=" + key.innerHTML + "&di=i"  
                }

                // Cambia la pagina con i nuovi parametri di ordinamento
                window.location.href = url + "&pag=" + window.pag
            })
        }
    })

    // Gestione dei bottoni per la cancellazione
    let delButtons = document.querySelectorAll("td input[type^=\"button\"]")
    
    delButtons.forEach(dbtn => {
        dbtn.addEventListener("click", function Handle3(event){
            dbtn.value = "CONFIRM\nDELETE" // Cambia il testo del bottone
            dbtn.setAttribute("type", "submit") // Cambia il tipo del bottone a "submit"

            event.preventDefault() // Previene il comportamento predefinito

            event.target.removeEventListener("click", Handle3) // Rimuove il listener corrente
        })
    });

    // Mostra il displaybox se ha una classe assegnata
    if(displaybox.getAttribute("class") != ""){
        displaybox.hidden = false
    }
}