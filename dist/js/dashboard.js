
//Questa funzione converte la data dal formato yyyy-mm-dd al formato dd/mm/yyyy
function convertDate(date) {
    var date_new = new Date(date);
    return new Intl.DateTimeFormat('it-IT').format(date_new);
}

//Viene recuperata l'università e il corso di studi per poi mostrarlo sulla Dashboard
function getUniversity() {
    $.ajax({
        url: "./php/user.php",
        type: "GET",
        success: function (data) {
            $("#university").text(data.university);
            $("#course").text(data.faculty);
        }
    });
}

//Questa funzione recupera tutte le tasse relative all'utente loggato, identificato tramite l'id salvato in sessione
function getTaxes() {
    $.ajax({
        url: "../php/taxes.php",
        type: "GET",
        success: function (data) {
            var json = JSON.parse(data);
            var url = ""
            //Viene controllato se ci sono tasse
            if (json.taxes.length > 0) {
                var total = 0;
                var paid = 0
                var percentage = 0;
                //Viene calcolato il totale e il totale pagato delle tasse e viene calcolato il relativo percentuale di pagamento
                //Viene effettuato un parsing a Float in quanto sul database per comodità sono salvati come stringhe
                for (var i = 0; i < json.taxes.length; i++) {
                    total += parseFloat(json.taxes[i].amount);
                    if (json.taxes[i].paid == 1) {
                        paid += parseFloat(json.taxes[i].amount);
                    }
                }
                percentage = (parseFloat(paid) * 100) / parseFloat(total);
                percentage = percentage.toFixed(2);
                $("#taxes").html("Pagati: " + parseFloat(paid).toFixed(2) + "€/" + parseFloat(total).toFixed(2) + "€");
                url = "https://quickchart.io/chart?c={type:'progressBar',data:{datasets:[{data:[" + percentage + "]}]}}";
                $("#taxesChart").attr("src", url);
            } else {
                //Nel caso in cui non dovessero essere presenti tasse viene mostrato un messaggio
                $("#taxes").html("Nessuna tassa da pagare");
                url = "https://quickchart.io/chart?c={type:'progressBar',data:{datasets:[{data:[100]}]}}";
                $("#taxesChart").attr("src", url);
            }
        },
        error: function (data) {
            console.log(data);
        }
    });
}

//Questa funzione costruisce un grafico lineare che mostra l'andamento della media aritmetica e esponenziale nel tempo
//Vengono passati come parametri l'elemento in cui inserire l'esame (non è altro che un canvas), le date e le medie dei voti
function buildLineChart(elem, labels, data, data2) {
    const myChart = new Chart(elem, {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
                label: 'Aritmetica',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1
            },
            {
                label: 'Ponderata',
                data: data2,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    return myChart;
}

//Questa funzione costruisce un grafico a torta che mostra la distribuzione dei voti
//Vengono passati come parametri l'elemento in cui inserire il grafico (non è altro che un canvas), i voti e le relative frequenze
function buildPieChart(elem, labels, data) {
    const myChart = new Chart(elem, {
        type: "pie",
        data: {
            labels: labels,

            datasets: [{
                data: data,
                backgroundColor: [
                    'rgba(251,248,204, 0.5)',
                    'rgba(253,228,207, 0.5)',
                    'rgba(255,207,210, 0.5)',
                    'rgba(241,192,232, 0.5)',
                    'rgba(207,186,240, 0.5)',
                    'rgba(163,196,243, 0.5)',
                    'rgba(144,219,244, 0.5)',
                    'rgba(142,236,245, 0.5)',
                    'rgba(152,245,225, 0.5)',
                    'rgba(185,251,192, 0.5)',
                ],
                borderColor: [
                    'rgba(251,248,204, 1)',
                    'rgba(253,228,207, 1)',
                    'rgba(255,207,210, 1)',
                    'rgba(241,192,232, 1)',
                    'rgba(207,186,240, 1)',
                    'rgba(163,196,243, 1)',
                    'rgba(144,219,244, 1)',
                    'rgba(142,236,245, 1)',
                    'rgba(152,245,225, 1)',
                    'rgba(185,251,192, 1)',
                ],
                borderWidth: 2
            }]
        }
    });
}

//Questa funzione è responsabile di recuperare i dati relativi agli esami dell'utente loggato, identificato tramite l'id salvato in sessione
function getStats() {


    //Vengono identificati gli elementi html in cui inserire i grafici
    const average = document.getElementById('average').getContext('2d');
    const marksPie = document.getElementById('marksQuantity').getContext('2d');

    //Viene effettuata una chiamata ajax per recuperare i dati relativi agli esami

    //Vengono richiesti i cfu dell'utente
    $.ajax({
        url: "../php/stats.php",
        type: "GET",
        data: {
            action: "cfu"
        },
        success: function (data) {
            var json = JSON.parse(data);
            if (!json.error) {
                //Se non vi sono errori viene mostrato il numero di cfu e costruito il grafico
                //È importante recuperare i crediti totali e quelli ottenuti per poter calcolare il relativo percentuale e per identificare il dominio del grafico
                var missingCfu = parseInt(json.total_credits) - parseInt(json.cfu);
                $("#cfuLeft").html("Mancanti: " + (missingCfu || "180"));
                var url = "https://quickchart.io/chart?c={type:'radialGauge',data:{datasets:[{data:[" + parseInt(json.cfu) + "]}]}, options: {domain: [0," + parseInt(json.total_credits) + "]}}";
                $("#cfuGraph").attr("src", url);
            }
        }
    });

    //Vengono richiesti i voti dell'utente in modo da poter calcolare le medie nel tempo e la distribuzione dei voti
    $.ajax({
        url: "../php/stats.php",
        type: "GET",
        data: {
            action: "averages"
        },
        success: function (data) {
            var json = JSON.parse(data);

            //Se non vi sono errori nel json e non è nullo vengono eseguite le azioni seguenti...
            if (!json.error && json.exams != null) {
                var sumAverage = 0;
                var sumMean = 0
                var sumCfu = 0
                var dates = []
                var marks = [];
                var quantities = [];
                var averages = []
                var mean = []
                var markFrequencies = {};
                var maxValue = "";

                //Vengono calcolate le medie aritmetica e esponenziale e vengono salvate le date, i voti e le medie in un array
                for (var i = 0; i < json.exams.length; i++) {
                    //Vengono convertite le date in formato dd/mm/yyyy
                    dates.push(String(convertDate(json.exams[i].exam_date)));
                    sumAverage += parseInt(json.exams[i].mark);
                    sumMean += (parseInt(json.exams[i].mark) * parseInt(json.exams[i].cfu));
                    sumCfu += parseInt(json.exams[i].cfu);
                    averages.push((parseInt(sumAverage) / parseInt(i + 1)).toFixed(2));
                    mean.push((parseInt(sumMean) / parseInt(sumCfu)).toFixed(2));

                    //Se il voto è superiore a 30 allora viene identificato come 30 e lode e viene salvato come tale in un json
                    var currentMark = json.exams[i].mark > 30 ? "30L" : json.exams[i].mark;

                    //Nel caso in cui dovesse trovarlo nella lista dei voti, viene incrementata la sua frequenza, altrimenti viene aggiunto alla lista
                    if (currentMark in markFrequencies) {
                        markFrequencies[currentMark] += 1;
                    } else {
                        markFrequencies[currentMark] = 1;
                    }
                }

                //Vengono salvati i voti e le frequenze in due array in modo tale da poter costruire il grafico
                for (var key in markFrequencies) {
                    quantities.push(markFrequencies[key]);
                    marks.push(key);

                    //Viene identificato il voto più frequente
                    if (maxValue == "" || markFrequencies[key] > markFrequencies[maxValue]) {
                        maxValue = key;
                    }
                }


                //Viene calcolata la base del voto di laurea con la formula (media ponderata * 11) / 3 e viene costruito il grafico che è recuperato da una chiamata https
                var expectedDegreeMark = ((mean[json.exams.length - 1] * 11) / 3).toFixed(2);
                var url = "https://quickchart.io/chart?c={type:'radialGauge',data:{datasets:[{data:[" + expectedDegreeMark + "]}]}, options: {domain: [0,110], animation: {animateRotate: true}, centerArea: {text: " + expectedDegreeMark + "}}}";
                $("#expectedDegreeMark").attr("src", url);
                $("#expectedDegreeMarkLabel").html("Previsto: " + expectedDegreeMark);

                //Viene mostrata la media aritmetica e esponenziale nella card relativa alle medie e costruito il grafico
                $("#averageLabel").html("Media aritmetica: " + averages[json.exams.length - 1] + "<br> Media ponderata: " + mean[json.exams.length - 1]);
                buildLineChart(average, dates, averages, mean);

                //Viene mostrato il voto più frequente nella card relativa ai voti e costruito il grafico a torta
                $("#mostCommonMarkLabel").html("Voto più frequente: " + maxValue);
                buildPieChart(marksPie, marks, quantities)


            } else {
                //Se non vi sono esami allora vengono conservati gli elementi di base previsti dall'html e viene mostrato come base del voto di laurea 0
                var url = "https://quickchart.io/chart?c={type:'radialGauge',data:{datasets:[{data:[" + 0 + "]}]}, options: {domain: [0,110], animation: {animateRotate: true}, centerArea: {text: " + 0 + "}}}";
                $("#expectedDegreeMark").attr("src", url);
                $("#expectedDegreeMarkLabel").html("Previsto: 0");
            }
        }
    })
}


//Questa funzione è responsabile di recuperare le lezioni del giorno
function getTodaysClasses() {
    $.ajax({
        url: "../php/classes.php",
        type: "GET",
        success: function (data) {
            //Tramite questa variabile recupereremo il giorno corrente
            const dayOfWeekName = new Date().toLocaleString(
                'default', { weekday: 'long' }
            );
            var json = JSON.parse(data);
            var html = "";
            for (var i = 0; i < json.length; i++) {
                //Se il giorno della lezione è uguale al giorno corrente, viene aggiunta alla lista 
                if (json[i].day === dayOfWeekName) {
                    html += "<tr><td>" + json[i].name + "</td>";
                    html += "<td>" + json[i].timeStart + " - " + json[i].timeEnd + "</td>";
                    html += "<td>" + json[i].place + "</td></tr>";
                }
            }
            $("#todaysClassesTable").empty();
            $("#todaysClassesTable").append(html);
        }
    })
}

//Quando il documento viene caricato vengono eseguite le funzioni che recuperano le tasse, le statistiche e le lezioni del giorno
$("document").ready(function () {
    getTaxes();
    getStats();
    getTodaysClasses();
    getUniversity();
});

