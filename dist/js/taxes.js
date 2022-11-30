
//Vengono definiti gli elementi della pagina
var taxName = $("#tax_name");
var taxDate = $("#tax_date");
var taxAmount = $("#tax_amount");
var taxPaid = $("#tax_paid");
var taxTable = $("#taxTable");
var addTaxModal = $("#addTaxModal");
var addTaxModalLabel = $("#addTaxModalLabel");
var addTaxButton = $("#addTax");
var ADD_TAX = 0;
var EDIT_TAX = 1;
var taxId = 0;


taxPaid.change(function () {
    if (taxPaid.prop('checked')) {
        taxPaid.val('1');
    } else {
        taxPaid.val('0');
    }
});

//Viene definita la funzione per aggiungere una tassa
$("#addTaxModalButton").click(function () {
    newModalInstance(ADD_TAX, {});
});

//Al caricamento del documento viene caricata la tabella delle tasse
$(document).ready(function () {
    getTaxes();
});

//Converte una data in formato dd/mm/yyyy
function convertDate(date) {
    var date_new = new Date(date);
    return new Intl.DateTimeFormat('it-IT').format(date_new);
}


//Questa funzione si occupa di generare il modal corretto
function newModalInstance(mode, data) {
    switch (mode) {
        case 0:
            //Nel caso di aggiunta di una tassa
            addTaxModalLabel.text("Aggiungi Tassa")
            addTaxButton.text("Aggiungi")
            break;
        case 1:
            //Nel caso della modifica di una tassa
            addTaxModalLabel.text("Modifica Tassa")
            addTaxButton.text("Modifica")
            break;
    }

    //Vengono rimosse le classi "is-invalid" in modo tale da non mostrare errori all'apertura del modal
    taxName.removeClass("is-invalid");
    taxDate.removeClass("is-invalid");
    taxAmount.removeClass("is-invalid");
    taxPaid.removeClass("is-invalid");

    //Vengono posti i campi vuoti o con i dati della tassa selezionata
    taxName.val("" || data.name);
    taxDate.val("" || data.date);
    taxAmount.val("" || data.amount);
    taxPaid.val("" || (data.paid === "1" ? "1" : "0"));
    taxPaid.val() === "1" ? taxPaid.prop('checked', true) : taxPaid.prop('checked', false);

    //Viene mostrato il modal
    addTaxModal.modal("show");
}


//Questa funzione si occupa della validazione in base ai valori presenti nel json
function validation(data) {
    data.tax_name ? taxName.addClass("is-invalid") : taxName.removeClass("is-invalid");
    data.tax_date ? taxDate.addClass("is-invalid") : taxDate.removeClass("is-invalid");
    data.tax_amount ? taxAmount.addClass("is-invalid") : taxAmount.removeClass("is-invalid");
    data.tax_paid ? taxPaid.addClass("is-invalid") : taxPaid.removeClass("is-invalid");
}


//Questa funzione recupera tutte le tasse dell'utente
function getTaxes() {

    var toPay = 0;

    $.ajax({
        url: "../php/taxes.php",
        type: "GET",
        success: function (data) {
            var json = JSON.parse(data);
            var html = ""
            for (var i = 0; i < json.taxes.length; i++) {
                var paid = json.taxes[i].paid == 1 ? "Si" : "No";
                html += "<tr id=" + json.taxes[i].tax_id + ">";
                html += "<td>" + json.taxes[i].name + "</td>";
                html += "<td>" + paid + "</td>";
                html += "<td>" + parseFloat(json.taxes[i].amount).toFixed(2) + "€</td>";
                html += "<td>" + convertDate(json.taxes[i].date) + "</td>";
                html += "<td>";
                html += "<button type='button' class='btn btn-warning m-2' onclick='getTax(" + json.taxes[i].tax_id + ")'><i class='bi bi-pen' ></i></button>";
                html += "<button type='button' class='btn btn-danger m-2' onclick='deleteTax(" + json.taxes[i].tax_id + ")'><i class='bi bi-trash'></i></button></td>";
                html += "</tr>";
                if (json.taxes[i].paid == 0) {
                    toPay += parseFloat(json.taxes[i].amount);
                }
            }
            taxTable.empty();
            taxTable.append(html);

            //Viene aggiunto il testo per il totale da pagare
            $("#toPay").text(toPay.toFixed(2) + "€");
        },
        error: function (data) {
            console.log("Problema con la richiesta");
        }
    });
}

//Questa funzione si occupa di recuperare i dati di una tassa in base all'id
function getTax(id) {
    $.ajax({
        method: 'GET',
        url: "../php/taxes.php",
        data: {
            id: id
        },
        cache: false,
        success: function (result) {
            var json = JSON.parse(result);
            if (json.error)
                console.log(result);
            else {
                //Nel caso in cui non ci fossero errori viene mostrato il modal con i dati della tassa
                //e viene impostato l'id della tassa
                taxId = id;
                newModalInstance(EDIT_TAX, json.taxes[0]);;
            }
        }
    });
}

//Questa funzione si occupa di aggiungere una tassa
function setTax() {
    $.ajax({
        url: "../php/taxes.php",
        type: "POST",
        data: {
            tax_name: taxName.val(),
            tax_date: taxDate.val(),
            tax_amount: taxAmount.val(),
            tax_paid: taxPaid.val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            if (json.success) {
                //Nel caso in cui la richiesta vada a buon fine viene chiuso il modal e viene ricaricata la tabella
                getTaxes();
                $("#addTaxModal").modal("hide");
            } else {
                validation(json);
            }
        },
        error: function (data) {
            console.log("Problema con la richiesta");
        }
    });
}


//Questa funzione si occupa di aggiornare una tassa
function editTax() {
    $.ajax({
        method: 'PUT',
        url: "../php/taxes.php",
        data: {
            id: taxId,
            tax_name: taxName.val(),
            tax_date: taxDate.val(),
            tax_amount: taxAmount.val(),
            tax_paid: taxPaid.val()
        },
        cache: false,
        success: function (result) {
            var json = JSON.parse(result);
            if (json.error)
                console.log(result);
            else {
                //Nel caso in cui non ci fossero errori viene chiuso il modal e viene ricaricata la tabella
                getTaxes();
                $("#addTaxModal").modal("hide");
            }
        }
    });
}


//Questa funzione si occupa di eliminare una tassa in base all'id
function deleteTax(id) {
    //Viene identificata la riga da eliminare
    var tr = $("#" + id).closest('tr');
    $.ajax({
        method: 'DELETE',
        url: "../php/taxes.php",
        data: {
            id: id
        },
        cache: false,
        success: function (result) {
            var json = JSON.parse(result);
            if (json.error)
                console.log(result);
            else {
                //Nel caso in cui non ci fossero errori viene eliminata la riga
                tr.fadeOut(1000, function () {
                    getTaxes();
                });
            }
        }
    });
};




//Il tasto svolgerà una determinata azione in base al suo testo, se è "Aggiungi" verrà aggiunta una nuova tassa, se è "Modifica" verrà modificata una tassa
$("#addTax").click(function () {
    if (addTaxButton.text() == "Aggiungi")
        setTax();
    else
        editTax();
});
