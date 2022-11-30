function getInfo() {
    $.ajax({
        url: "../php/user.php",
        type: "GET",
        success: function (data) {
            var json = JSON.parse(data);
            $("#name").val(json.name);
            $("#surname").val(json.surname);
            $("#email").val(json.email);
            $("#university").val(json.university);
            $("#faculty").val(json.faculty);
            $("#laudeValue").val(json.laude_value);
            $("#cfu").val(json.total_credits);
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function getUniversities() {
    $.ajax({
        url: "http://universities.hipolabs.com/search?country=italy",
        type: "GET",
        success: function (data) {
            //Vengono aggiunte le università all'elemento select
            for (var i = 0; i < data.length; i++) {
                $("#university").append(`<option value="${data[i].name}">${data[i].name}</option>`);
            }
            getInfo();

        },
        error: function (error) {
            console.log(error);
        }
    });
}

function validation(data) {
    var name = $("#name");
    var surname = $("#surname");
    var email = $("#email");
    var password = $("#password");
    var passwordConfirmation = $("#passwordConfirmation");
    var university = $("#university");
    var faculty = $("#faculty");
    var laudeValue = $("#laudeValue");
    var cfu = $("#cfu");

    data.name ? name.addClass("is-invalid") : name.removeClass("is-invalid");
    data.surname ? surname.addClass("is-invalid") : surname.removeClass("is-invalid");
    data.email ? email.addClass("is-invalid") : email.removeClass("is-invalid");
    data.password ? password.addClass("is-invalid") : password.removeClass("is-invalid");
    data.password ? passwordConfirmation.addClass("is-invalid") : passwordConfirmation.removeClass("is-invalid");
    data.university ? university.addClass("is-invalid") : university.removeClass("is-invalid");
    data.faculty ? faculty.addClass("is-invalid") : faculty.removeClass("is-invalid");
    data.laude_value ? laudeValue.addClass("is-invalid") : laudeValue.removeClass("is-invalid");
    data.total_credits ? cfu.addClass("is-invalid") : cfu.removeClass("is-invalid");
}

function editUser() {

    $.ajax({
        url: "../php/user.php",
        type: "PUT",
        data: {
            name: $("#name").val(),
            surname: $("#surname").val(),
            email: $("#email").val(),
            university: $("#university").val(),
            faculty: $("#faculty").val(),
            laude_value: $("#laudeValue").val(),
            total_credits: $("#cfu").val(),
            password: $("#password").val(),
            passwordConfirmation: $("#passwordConfirmation").val()
        },
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json);
            if (json.success) {
                window.location.href = "index.php";
            } else {
                validation(json);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}

$(document).ready(function () {
    getUniversities();
});

$("#editUser").click(function () {
    editUser();
});