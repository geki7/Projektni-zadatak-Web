//Prijava 

function openLoginForm() {
    var loginForm = document.getElementById("loginForm");
    loginForm.style.display = "block";
}

function closeLoginForm() {
    var loginForm = document.getElementById("loginForm");
    loginForm.style.display = "none";
}

// Close the form if the user clicks outside of it
window.onclick = function(event) {
    var loginForm = document.getElementById("loginForm");
    if (event.target == loginForm) {
        loginForm.style.display = "none";
    }
}

//Registracija 

// Function to open the registration form
function openRegistrationForm() {
    var registrationForm = document.getElementById("registrationForm");
    registrationForm.style.display = "block";
}

// Function to close the registration form
function closeRegistrationForm() {
    var registrationForm = document.getElementById("registrationForm");
    registrationForm.style.display = "none";
}

function closeOpisModal() {
    var natjecajModal = document.getElementById("zadatak-opis-modal");
    natjecajModal.style.display = "none";
}

function closeDodajPoduzece() {
    var natjecajModal = document.getElementById("poduzece-modal");
    natjecajModal.style.display = "none";
}

function dodajKnjigu() {
    var zadatakModal = document.getElementById("poduzece-modal");
    zadatakModal.style.display = "block";

    const zadatakForm = document.getElementById("poduzece-form");
    zadatakForm.addEventListener("submit", function(e){
        e.preventDefault();
        const values = e.target;
        const naziv = values.elements['naziv'].value;
        const opis = values.elements['opis'].value;
        const autor = values.elements['autor'].value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../dodaj_poduzece.php", true); // Create call_function.php to call the function
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from call_function.php if needed
                console.log(xhr.responseText);
            }
        };
    
        // Construct the data to send
        const data = "&naziv=" + encodeURIComponent(naziv) + "&opis=" + encodeURIComponent(opis) + "&autor=" + encodeURIComponent(autor);
        xhr.send(data);

        closeDodajPoduzece();
    });
}

function odjaviMe() {
    // Make an HTTP request to session.php to trigger obrisiSesiju()
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../session.class.php?logout=true", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            // Redirect to another page after logout if needed
            window.location.href = "../index.php";
        }
    };
    xhr.send();
}

function editKorisnik(id) {
    console.log("ID", id)
    var zadatakModal = document.getElementById("edit-korisnik-modal");
    zadatakModal.style.display = "block";

    const korisnikForm = document.getElementById("edit-korisnik-form");
    korisnikForm.addEventListener("submit", function(e){
        e.preventDefault();
        const values = e.target;
        const ime = values.elements['ime'].value;
        const prezime = values.elements['prezime'].value;
        const email = values.elements['email'].value;
        const username = values.elements['username'].value;
        const uloga = values.elements['uloga'].value;
        const blokiran = values.elements['blokiran'].value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../edit_korisnik.php", true); // Create call_function.php to call the function
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from call_function.php if needed
                console.log(xhr.responseText);
            }
        };
    
        // Construct the data to send
        const data = "&id=" + encodeURIComponent(id) + "&ime=" + encodeURIComponent(ime) + "&prezime=" + encodeURIComponent(prezime) + "&email=" + encodeURIComponent(email)
         + "&username=" + encodeURIComponent(username) + "&uloga=" + encodeURIComponent(uloga) + "&blokiran=" + encodeURIComponent(blokiran);
        xhr.send(data);

        closeEditKorisnik();
    });
}

function closeEditKorisnik() {
    var natjecajModal = document.getElementById("edit-korisnik-modal");
    natjecajModal.style.display = "none";
}

function editKnjiga(knjiga_id) {
    openeditKnjiga(knjiga_id);

}

function openeditKnjiga(knjiga_id) {
    var knjigaModal = document.getElementById("edit-knjiga-modal");
    knjigaModal.style.display = "block";

    const knjigaForm = document.getElementById("edit-knjiga-form");
    knjigaForm.addEventListener("submit", function(e) {
        e.preventDefault();
        const values = e.target;
        const naziv = values.elements['naziv'].value;
        const opis = values.elements['opis'].value;
        const autor = values.elements['autor'].value;
        console.log(knjiga_id, "knjiga");
        //Send data and trigger query
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../edit_knjiga.php", true); // Create call_function.php to call the function
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from call_function.php if needed
                console.log(xhr.responseText);
            }
        };
    
        // Construct the data to send
        const data = "knjiga_id=" + encodeURIComponent(knjiga_id) + "&naziv=" + encodeURIComponent(naziv) + "&opis=" + encodeURIComponent(opis) + "&autor=" + encodeURIComponent(autor);
        xhr.send(data);

        closeEditKnjiga();
    });
}

function closeEditKnjiga() {
    var knjigaModal = document.getElementById("edit-knjiga-modal");
    knjigaModal.style.display = "none";
}


function obrisiKnjigu(knjiga_id) {
        //Send data and trigger query
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../brisanje_knjige.php", true); // Create call_function.php to call the function
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from call_function.php if needed
                console.log(xhr.responseText);
            }
        }
        // Construct the data to send
        const data = "knjiga_id=" + encodeURIComponent(knjiga_id);
        xhr.send(data);
}
