const form = $("#form-body");
const modeButton = $("#register-login");
const action = $("#action");
const modeText = $("#mode-text");


function generateLogin() {
    //Nel caso della generazione di un login viene fatto un append degli elementi necessari
    form.html(`
        <div>
            <p class="" style="display: none;">Errore password</p>
        </div>
        <div class="form-outline mb-4">
            <input type="email" id="email" class="form-control form-control-lg"
                placeholder="Email" />
        </div>

        <div class="form-outline mb-4">
            <input type="password" id="password" class="form-control form-control-lg"
                placeholder="Password" />
        </div>
    `);
    //E viene cambiato il testo del bottone e del titolo
    modeText.text("Accedi");
    modeButton.text("Registrati");
    action.text("Login");
}

function generateRegister() {
    //Nel caso della generazione di un register viene fatto un append degli elementi necessari
    //Vengono recuperate le università italiane tramite un api
    var universities = []
    $.ajax({
        url: "http://universities.hipolabs.com/search?country=italy",
        type: "GET",
        success: function (data) {
            //Vengono aggiunte le università ad un array
            for (var i = 0; i < data.length; i++) {
                universities.push(data[i].name);
            }

            //Vengono aggiunti i campi necessari alla registrazione
            form.html(`
                <div>
                    <p class="" style="display: none;">Errore password</p>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="name" class="form-control form-control-lg"
                        placeholder="Nome" />
                    <p class="text-danger"></p>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="surname" class="form-control form-control-lg"
                        placeholder="Cognome" />
                    <p class="text-danger"></p>
                </div>

                <div class="form-outline mb-4">
                    <select class="form-control form-control-lg mb-4" id="university" aria-label="Università">
                        <option selected disabled>Seleziona la tua università</option>
                    <p class="text-danger"></p>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="faculty" class="form-control form-control-lg"
                        placeholder="Facoltà" />
                    <p class="text-danger"></p>
                </div>

                <div class="row form-outline mb-4">
                    <div class="col">
                        <input type="text" class="form-control form-control-lg" id="cfu" placeholder="CFU Totali" aria-label="CFU Totali">
                        <p class="text-danger"></p>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control form-control-lg" id="laude" placeholder="Valore Lode" aria-label="Valore Lode">
                        <p class="text-danger"></p>
                    </div>
                </div>

                <div class="form-outline mb-4">
                    <input type="email" id="email" class="form-control form-control-lg"
                        placeholder="Email" />
                    <p class="text-danger"></p>
                </div>

                <div class="form-outline mb-4">
                    <input type="password" id="password" class="form-control form-control-lg"
                        placeholder="Password" />
                    <p class="text-danger"></p>
                </div>

                <div class="form-outline mb-4">
                    <input type="password" id="password-confirmation" class="form-control form-control-lg"
                        placeholder="Conferma Password" />
                    <p class="text-danger"></p>
                </div>
            `);

            //Vengono aggiunte le università all'elemento select
            for (var i = 0; i < universities.length; i++) {
                $("#university").append(`<option value="${universities[i]}">${universities[i]}</option>`);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });

    //E viene cambiato il testo del bottone e del titolo
    modeText.text("Registrati");
    modeButton.text("Accedi");
    action.text("Registrati");
}

function validate(json) {
    //Vengono controllati i campi del json
    //Nel caso in cui dovesse trovare un riferimento allo specifico elemento vuol dire che il server ha restituito un errore sull'elemento in questione
    //Viene aggiunta la classe "is-invalid" che evidenzia il campo in rosso
    if(!json.success) {
        if(json.name){
            $("#name").addClass("is-invalid");
            $("#name").next().text(json.name);
        } else {
            $("#name").removeClass("is-invalid");
            $("#name").next().text("");
        }
        if(json.surname){
            $("#surname").addClass("is-invalid");
            $("#surname").next().text(json.surname);
        } else {
            $("#surname").removeClass("is-invalid");
            $("#surname").next().text("");
        }
        if(json.university){
            $("#university").addClass("is-invalid");
            $("#university").next().text(json.university);
        } else {
            $("#university").removeClass("is-invalid");
            $("#university").next().text("");
        }
        if(json.faculty){
            $("#faculty").addClass("is-invalid");
            $("#faculty").next().text(json.faculty);
        } else {
            $("#faculty").removeClass("is-invalid");
            $("#faculty").next().text("");
        }
        if(json.cfu){
            $("#cfu").addClass("is-invalid");
            $("#cfu").next().text(json.cfu);
        } else {
            $("#cfu").removeClass("is-invalid");
            $("#cfu").next().text("");
        }
        if(json.laude){
            $("#laude").addClass("is-invalid");
            $("#laude").next().text(json.laude);
        } else {
            $("#laude").removeClass("is-invalid");
            $("#laude").next().text("");
        }
        if(json.email){
            $("#email").addClass("is-invalid");
            $("#email").next().text(json.email);
        } else {
            $("#email").removeClass("is-invalid");
            $("#email").next().text("");
        }
        if(json.password){
            $("#password").addClass("is-invalid");
            $("#password").next().text(json.password);
        } else {
            $("#password").removeClass("is-invalid");
            $("#password").next().text("");
        }
        if(json.passwordConfirmation){
            $("#password-confirmation").addClass("is-invalid")
            $("#password-confirmation").next().text(json.passwordConfirmation);
        } else {
            $("#password-confirmation").removeClass("is-invalid");
            $("#password-confirmation").next().text("");
        }
    } else {
        return true;
    }
}
