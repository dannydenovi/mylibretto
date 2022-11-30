//Vengono definiti gli elementi
var subject = $("#subject");
var professor = $("#professor");
var weekday = $("#weekday");
var timeStart = $("#time-start");
var timeEnd = $("#time-end");
var place = $("#place");
var ADD_CLASS = 0;
var EDIT_CLASS = 1;
var addClassModalLabel = $("#addClassModalLabel");
var addClassModal = $("#addClassModal");
var addClassButton = $("#addClass");
var editClassId = 0;

//Al caricamento della pagina viene definito che se il tasto di aggiunta è stato premuto, viene generato un modal
//Vengono recuperate le lezioni
$(document).ready(function () {
    $("#addClassBtn").click(function () {
        newModalInstance(ADD_CLASS, {});
    });
    getClasses()
});

//Questa funzione si occupa di generare il modal corretto
function newModalInstance(mode, data) {
    switch (mode) {
        case 0:
            //Nel caso di aggiunta di una lezione
            addClassModalLabel.text("Aggiungi Lezione")
            addClassButton.text("Aggiungi")
            break;
        case 1:
            //Nel caso della modifica di una lezione
            addClassModalLabel.text("Modifica Lezione")
            addClassButton.text("Modifica")
            break;
    }

    //Vengono rimosse le classi "is-invalid" in modo tale da non mostrare errori all'apertura del modal
    subject.removeClass("is-invalid");
    professor.removeClass("is-invalid");
    weekday.removeClass("is-invalid");
    timeStart.removeClass("is-invalid");
    timeEnd.removeClass("is-invalid");
    place.removeClass("is-invalid");

    console.log(data.day)
    //Vengono posti i campi vuoti o con i dati della lezione selezionata
    subject.val("" || data.name);
    professor.val("" || data.professor);
    data.day ? weekday.val(data.day) : weekday.val("-1");
    timeStart.val("" || data.timeStart);
    timeEnd.val("" || data.timeEnd);
    place.val("" || data.place);

    //Viene mostrato il modal
    addClassModal.modal("show");
}

//Questa funzione controlla se vi sono dei campi relativi alle lezioni nel json
//In caso di esito positivo viene aggiunta la classe "is-invalid"
function validation(data) {
    console.log(data)
    data.subject ? subject.addClass("is-invalid") : subject.removeClass("is-invalid")
    data.professor ? professor.addClass("is-invalid") : professor.removeClass("is-invalid")
    data.weekday ? weekday.addClass("is-invalid") : weekday.removeClass("is-invalid")
    data.timeStart ? timeStart.addClass("is-invalid") : timeStart.removeClass("is-invalid")
    data.timeEnd ? timeEnd.addClass("is-invalid") : timeEnd.removeClass("is-invalid")
    data.place ? place.addClass("is-invalid") : place.removeClass("is-invalid")
}

//Questa funzione recupera tutte le lezioni per l'utente
function getClasses() {
    $.ajax({
        url: "../php/classes.php",
        type: "GET",
        success: function (data) {
            var json = JSON.parse(data);
            var mondayHtml = "";
            var tuesdayHtml = "";
            var wednesdayHtml = "";
            var thursdayHtml = "";
            var fridayHtml = "";
            var saturdayHtml = "";

            for (var i = 0; i < json.length; i++) {
                var subject = json[i].name;
                var professor = json[i].professor;
                var weekday = json[i].day;
                var timeStart = json[i].timeStart;
                var timeEnd = json[i].timeEnd;
                var place = json[i].place;
                var id = json[i].class_id;

                //Viene creato un elemento html per ogni lezione
                var html = "<tr id=" + id + "><td>" + subject + "</td><td>" + professor + "</td><td>" + timeStart + " - " + timeEnd + "</td><td>" + place + "</td><td><button class='btn btn-warning m-2' onclick='getClass(" + id + ")'><i class='bi bi-pen'></i></button><button class='btn btn-danger m-2' onclick='deleteClass(" + id + ")'><i class='bi bi-trash'></i></button></td></tr>";

                //Viene aggiunto l'elemento html nella stringa corrispondente al giorno della settimana
                if (weekday == "Monday") {
                    mondayHtml += html;
                } else if (weekday == "Tuesday") {
                    tuesdayHtml += html;
                } else if (weekday == "Wednesday") {
                    wednesdayHtml += html;
                } else if (weekday == "Thursday") {
                    thursdayHtml += html;
                } else if (weekday == "Friday") {
                    fridayHtml += html;
                } else if (weekday == "Saturday") {
                    saturdayHtml += html;
                }

                //Viene aggiunto l'elemento html nella tabella corrispondente al giorno della settimana
                $("#mondayTable").empty().append(mondayHtml);
                $("#tuesdayTable").empty().append(tuesdayHtml);
                $("#wednesdayTable").empty().append(wednesdayHtml);
                $("#thursdayTable").empty().append(thursdayHtml);
                $("#fridayTable").empty().append(fridayHtml);
                $("#saturdayTable").empty().append(saturdayHtml);
            }
        }
    })
}

//Questa funzione si occupa di ottenere i dati relativi ad una lezione per poter istanziare il modal
function getClass(id) {
    $.ajax({
        url: "../php/classes.php",
        type: "GET",
        data: {
            id: id
        },
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json);
            if (!json.error) {
                editClassId = id;
                newModalInstance(EDIT_CLASS, json[0]);
            }
        }
    })
}

//Questa funzione si occupa di aggiungere una lezione
function setClass() {
    $.ajax({
        url: "../php/classes.php",
        type: "POST",
        data: {
            name: subject.val(),
            professor: professor.val(),
            day: weekday.val(),
            timeStart: timeStart.val(),
            timeEnd: timeEnd.val(),
            place: place.val()
        },
        success: function (data) {
            console.log("dati" + data);
            var json = JSON.parse(data);
            if (json.success) {
                $("#addClassModal").modal("hide");
                getClasses();
            } else {
                validation(json)
            }
        }
    })
}


//Questa funzione si occupa di modificare una lezione
function editClass() {
    $.ajax({
        url: "../php/classes.php",
        type: "PUT",
        data: {
            id: editClassId,
            name: subject.val(),
            professor: professor.val(),
            day: weekday.val(),
            timeStart: timeStart.val(),
            timeEnd: timeEnd.val(),
            place: place.val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            if (!json.error) {
                $("#addClassModal").modal("hide");
                getClasses();
            } else {
                validation(json)
            }
        }
    })
}

//Questa funzione si occupa di modificare una lezione
function deleteClass(id) {
    var tr = $("#" + id).closest('tr');
    $.ajax({
        url: "../php/classes.php",
        type: "DELETE",
        data: {
            id: id
        },
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json);
            if (!json.error) {
                tr.fadeOut(1000, function () {
                    getClasses();
                });
            }
        }
    })
}

//Il tasto svolgerà una determinata azione in base al suo testo, se è "Aggiungi" verrà aggiunta una nuova lezione, se è "Modifica" verrà modificata una lezione
$("#addClass").click(function () {
    if (addClassButton.text() == "Aggiungi")
        setClass();
    else
        editClass();
});