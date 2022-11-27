//Array di pagine
var elements = [$("#dashboard"), $("#libretto"), $("#tasse"), $("#orarioLezioni"), $("#impostazioni")];

//Al click su uno degli elementi presenti nella topbar
//Viene caricata la pagina corrispondente e viene aggiunta la classe active
$("#libretto").click(function () {
    $("#main").empty();
    selectedItemMenu($("#libretto"));
    $("#main").load("dist/html/libretto.html");
});

$("#dashboard").click(function () {
    $("#main").empty();
    selectedItemMenu($("#dashboard"));
    $("#main").load("dist/html/dashboard.html");
});

$("#tasse").click(function () {
    $("#main").empty();
    selectedItemMenu($("#tasse"));
    $("#main").load("dist/html/tasse.html");
});

$("#orarioLezioni").click(function () {
    $("#main").empty();
    selectedItemMenu($("#orarioLezioni"));
    $("#main").load("dist/html/orariolezioni.html");
});

$("#impostazioni").click(function () {
    $("#main").empty();
    selectedItemMenu($("#impostazioni"));
    $("#main").load("dist/html/impostazioni.html");
});


//Funzione che aggiunge la classe active all'elemento selezionato
//e rimuove la classe active agli altri elementi
function selectedItemMenu(activeElement) {
    for (var i = 0; i < elements.length; i++) {
        elements[i].removeClass("link-secondary");
        elements[i].addClass("link-dark");
    }

    activeElement.addClass("link-secondary");
    activeElement.removeClass("link-dark");
}

//Acqiuisizione dei dati dell'utente
function getNameSurname() {
    $.ajax({
        url: "./php/user.php",
        type: "POST",
        data: {
            action: "getInfo"
        },
        success: function (data) {
            var json = JSON.parse(data);
            $("#namePlace").text(json.name + " " + json.surname);
        }
    });
}

//Al caricamento del documento viene caricata la pagina dashboard.html
$("document").ready(function () {
    $("#main").load("dist/html/dashboard.html");
    getNameSurname()
});


//Al click sul logout viene eseguito il logout
//Viene effettuata una chiamata ajax per distruggere la sessione
$("#logout-button").click(function () {
    $.ajax({
        url: "php/loginManager.php",
        type: "POST",
        success: function (data) {
            window.location.href = "login.php";
        }
    });
});