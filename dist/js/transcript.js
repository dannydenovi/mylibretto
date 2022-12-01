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
var eligibility = $("#eligibility");


//Al caricamento della pagina viene definita la funzione che se cliccato sul tasto aggiungi
//Viene aggiunto un esame, se cliccato sul tasto modifica viene modificato l'esame
//Il tasto viene modificato in base al tasto che apre il modal
//Viene inoltre aggiornato il libretto
$(document).ready(function () {
    $("#addSubject").click(function () {
        if (addModalButton.text() === "Aggiungi") {
            addExam();
        } else if (addModalButton.text() === "Modifica") {
            editExam();
        }
    });
    $("#addSubjButton").click(function () {
        newModalInstance(0, {});
    });
    getExams();
});


eligibility.change(function () {
    if (eligibility.prop('checked')) {
        eligibility.val('1');
        mark.val('0');
        professor.val('-');
        $("#markComponent").hide();
        $("#professorComponent").hide();
    } else {
        eligibility.val('0');
        mark.val('');
        professor.val('');
        $("#markComponent").show();
        $("#professorComponent").show();
    }
});



//Questa funzione converte le date del database da yyyy-mm-dd a dd-mm-yyyy
function convertDate(date) {
    var date_new = new Date(date);
    return new Intl.DateTimeFormat('it-IT').format(date_new);
}


//Questa funzione si occupa della validazione, nel caso in cui dovesse trovare il messaggio di errore
//Relativo all'elemento allora inserisce la classe "is-invalid"
function validateExam(data) {
    data.subject ? subject.addClass("is-invalid") : subject.removeClass("is-invalid");
    data.cfu ? cfu.addClass("is-invalid") : cfu.removeClass("is-invalid");
    data.professor ? professor.addClass("is-invalid") : professor.removeClass("is-invalid");
    data.exam_date ? exam_date.addClass("is-invalid") : exam_date.removeClass("is-invalid");
    data.mark ? mark.addClass("is-invalid") : mark.removeClass("is-invalid");
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

    if(data.eligibility === "1"){
        eligibility.prop('checked', true);
        eligibility.val('1')
        $("#markComponent").hide();
        $("#professorComponent").hide();
        mark.val('0');
        professor.val('-');
    } else {
        eligibility.prop('checked', false);
        eligibility.val('0')
        $("#markComponent").show();
        $("#professorComponent").show();
    }

    //Viene mostrato il modal
    addSubjectModal.modal("show");
}


// Vengono recuperati tutti gli esami e mostrati in tabella
function getExams() {
    $.ajax({
        type: "GET",
        url: "../php/exams.php",
        cache: false,
        success: function (data) {
            var json = JSON.parse(data);
            if (!json.error) {
                var exams = json.exams;
                var max_laude = json.info.laude_value;
                var effective_credits = 0;
                var html = "";
                var average = 0;
                var mean = 0;
                var numEligible = 0;

                $("#marksTable").empty();
                for (var i = 0; i < exams.length; i++) {
                    html += "<tr id=" + exams[i].id + ">";
                    html += "<td>" + exams[i].subject + "</td>";
                    html += "<td>" + exams[i].professor + "</td>";
                    html += "<td>" + convertDate(exams[i].exam_date) + "</td>";
                    html += "<td>" + exams[i].cfu + "</td>";
                    if(exams[i].eligibility === "0")
                        html += "<td>" + (exams[i].mark > 30 ? "30 e lode" : exams[i].mark) + "</td>";
                    else
                        html += "<td>" + "Idoneità/Attività" + "</td>";
                    html += "<td>";
                    html += "<button type='button' class='btn btn-warning m-2' onclick='getExam(" + exams[i].id + ")'><i class='bi bi-pen' ></i></button>";
                    html += "<button type='button' class='btn btn-danger m-2' onclick='deleteExam(" + exams[i].id + ")'><i class='bi bi-trash'></i></button></td>";
                    html += "</tr>";

                    if(exams[i].eligibility === "0"){
                        average += parseInt(exams[i].mark);
                        mean += (parseInt(exams[i].mark) * parseInt(exams[i].cfu));
                        effective_credits += parseInt(exams[i].cfu);
                    } else {
                        numEligible++;
                    }
                }
                //Vengono calcolate la media aritmetica e la media ponderata
                average /= exams.length - numEligible;
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


// Questa funzione recupera i dati relativi ad un singolo esame tramite l'id
function getExam(id) {
    $.ajax({
        url: "../php/exams.php",
        type: "GET",
        data: {
            "id": id,
        },
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json);
            newModalInstance(EDIT_SUBJECT, json.exams[0]);
        }
    });
    //Viene posto come id di modifica quello corrente
    editSubjectID = id;
}

//Questa funzione si occupa di aggiungere un esame e di aggiorna la lista
function addExam() {
    $.ajax({
        type: "POST",
        url: "../php/exams.php",
        data: {
            subject: subject.val(),
            cfu: cfu.val(),
            professor: professor.val(),
            exam_date: exam_date.val(),
            mark: mark.val(),
            eligibility: eligibility.val()
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
function editExam() {
    $.ajax({
        type: "PUT",
        url: "../php/exams.php",
        data: {
            id: editSubjectID,
            subject: subject.val(),
            cfu: cfu.val(),
            professor: professor.val(),
            exam_date: exam_date.val(),
            mark: mark.val(),
            eligibility: eligibility.val()
        },
        cache: false,
        success: function (data) {
            var json = JSON.parse(data);
            if (json.success) {
                getExams();
                $('#addSubjectModal').modal('hide');
            } else {
                validateExam(json);
            }
        }
    });
}


// Elimina un esame tramite l'id
function deleteExam(id) {
    //Viene identificato l'elemento tabellare da eliminare più vicino all'elemento con quello specifico id
    var tr = $("#" + id).closest('tr');
    $.ajax({
        method: 'DELETE',
        url: "../php/exams.php",
        data: {
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


