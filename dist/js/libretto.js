var editSubjectID = 0;
var ADD_SUBJECT = 0;
var EDIT_SUBJECT = 1;
var addSubjectModalLabel = $("#addSubjectModalLabel")
var addModalButton = $("#addSubject")
var addSubjectButton = $("#addSubjButton")
var addSubjectModal = $("#addSubjectModal")
var subject = $("#subject")
var cfu = $("#cfu")
var professor = $("#professor")
var exam_date = $("#exam_date")
var mark = $("#mark")


//Al caricamento della pagina viene definita la funzione che se cliccato sul tasto aggiungi
//Viene aggiunto un esame, se cliccato sul tasto modifica viene modificato l'esame
//Il tasto viene modificato in base al tasto che apre il modal
//Viene inoltre aggiornato il libretto
$(document).ready(function () {
    $("#addSubject").click(function () {
        if (addModalButton.text() === "Aggiungi") {
            addExam();
        } else if (addModalButton.text() === "Modifica") {
            editSingleExam();
        }
    });
    $("#addSubjButton").click(function () {
        newModalInstance(0, {});
    });
    getExams();
});



//Questa funzione converte le date del database da yyyy-mm-dd a dd-mm-yyyy
function convertDate(date) {
    var date_new = new Date(date);
    return new Intl.DateTimeFormat('it-IT').format(date_new);
}

//Questa funzione si occupa di generare il modal corretto in base al tasto che lo apre
function newModalInstance(mode, data) {
    switch (mode) {
        case 0:
            //Nel caso in cui fosse in modalità aggiunta
            addSubjectModalLabel.text("Aggiungi Materia")
            addModalButton.text("Aggiungi")
            break;
        case 1:
            //Nel caso in cui fosse in modalità modifica
            addSubjectModalLabel.text("Modifica Materia")
            addModalButton.text("Modifica")
            break;
    }

    //Vengono rimosse le classi di errore
    subject.removeClass("is-invalid");
    cfu.removeClass("is-invalid");
    professor.removeClass("is-invalid");
    exam_date.removeClass("is-invalid");
    mark.removeClass("is-invalid");


    //Vengono rimossi i valori se è un modal di aggiunta oppure utilizzati quelli passati in input se è un modal di modifica
    subject.val("" || data.subject);
    cfu.val("" || data.cfu);
    professor.val("" || data.professor);
    exam_date.val("" || data.exam_date);
    mark.val("" || data.mark);

    //Viene mostrato il modal
    addSubjectModal.modal("show");
}


// Questa funzione recupera i dati relativi ad un singolo esame tramite l'id
function editExam(id) {
    $.ajax({
        url: "../php/exams.php",
        type: "POST",
        data: {
            "id": id,
            "action": "getSingleExam"
        },
        success: function (data) {
            var json = JSON.parse(data);
            newModalInstance(EDIT_SUBJECT, json)
        }
    });
    //Viene posto come id di modifica quello corrente
    editSubjectID = id;
}


// Vengono recuperati tutti gli esami e mostrati in tabella
function getExams() {
    $.ajax({
        type: "POST",
        url: "../php/exams.php",
        data: {
            action: "getExams"
        },
        cache: false,
        success: function (data) {
            var json = JSON.parse(data);
            if (!json.error) {
                var exams = json.exams;
                var max_laude = json.info.laude_value;
                var total_credits = parseInt(json.info.total_credits);
                var effective_credits = 0;
                var html = "";
                var average = 0;
                var mean = 0;
                $("#marksTable").empty();
                for (var i = 0; i < exams.length; i++) {
                    html += "<tr id=" + exams[i].id + ">";
                    html += "<td>" + exams[i].subject + "</td>";
                    html += "<td>" + exams[i].professor + "</td>";
                    html += "<td>" + convertDate(exams[i].exam_date) + "</td>";
                    html += "<td>" + exams[i].cfu + "</td>";
                    html += "<td>" + (exams[i].mark > 30 ? "30 e lode" : exams[i].mark) + "</td>";
                    html += "<td>";
                    html += "<button type='button' class='btn btn-warning m-2' onclick='editExam(" + exams[i].id + ")'><i class='bi bi-pen' ></i></button>";
                    html += "<button type='button' class='btn btn-danger m-2' onclick='deleteExam(" + exams[i].id + ")'><i class='bi bi-trash'></i></button></td>";
                    html += "</tr>";
                    average += parseInt(exams[i].mark);
                    mean += (parseInt(exams[i].mark) * parseInt(exams[i].cfu));
                    effective_credits += parseInt(exams[i].cfu);
                }
                //Vengono calcolate la media aritmetica e la media ponderata
                average /= exams.length;
                mean /= effective_credits;

                //Vengono mostrati i dati relativi al libretto
                $("#average").text(average.toFixed(2));
                $("#mean").text(mean.toFixed(2));
                $("#marksTable").append(html);
                $("#mark").attr("max", max_laude);
            } else {
                alert(json.error);
            }
        }
    });
}

// Elimina un esame tramite l'id
function deleteExam(id) {
    //Viene identificato l'elemento tabellare da eliminare più vicino all'elemento con quello specifico id
    var tr = $("#" + id).closest('tr');
    $.ajax({
        method: 'POST',
        url: "../php/exams.php",
        data: {
            action: "deleteExam",
            id: id
        },
        cache: false,
        success: function (result) {
            var json = JSON.parse(result);
            if (json.error)
                console.log(result);
            else {
                //Nel caso in cui non vi siano errori viene fatto un fadeout dell'elemento e aggiornata la lista
                tr.fadeOut(1000, function () {
                    getExams();
                });
            }
        }
    });
};

//Questa funzione si occupa della validazione, nel caso in cui dovesse trovare il messaggio di errore
//Relativo all'elemento allora inserisce la classe "is-invalid"
function validateExam(data) {
    data.subject ? subject.addClass("is-invalid") : subject.removeClass("is-invalid");
    data.cfu ? cfu.addClass("is-invalid") : cfu.removeClass("is-invalid");
    data.professor ? professor.addClass("is-invalid") : professor.removeClass("is-invalid");
    data.exam_date ? exam_date.addClass("is-invalid") : exam_date.removeClass("is-invalid");
    data.mark ? mark.addClass("is-invalid") : mark.removeClass("is-invalid");
}

//Questa funzione si occupa di aggiungere un esame e di aggiorna la lista
function addExam() {
    $.ajax({
        type: "POST",
        url: "../php/exams.php",
        data: {
            action: "setExams",
            subject: subject.val(),
            cfu: cfu.val(),
            professor: professor.val(),
            exam_date: exam_date.val(),
            mark: mark.val()
        },
        cache: false,
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json);
            if (json.success) {
                $('#addSubjectModal').modal('hide');
                getExams();
            } else {
                validateExam(json);
            }
        }
    });
}

//Questa funzione aggiunge un singolo esame e aggiorna la lista
//Nel caso in cui il backend non dovesse restituire success allora viene effettuata la validazione dei campi in base al json restituito
function editSingleExam() {
    $.ajax({
        type: "POST",
        url: "../php/exams.php",
        data: {
            action: "editExam",
            id: editSubjectID,
            subject: subject.val(),
            cfu: cfu.val(),
            professor: professor.val(),
            exam_date: exam_date.val(),
            mark: mark.val()
        },
        cache: false,
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json);
            if (json.success) {
                getExams();
                $('#addSubjectModal').modal('hide');
            } else {
                validateExam(json);
            }
        }
    });
}