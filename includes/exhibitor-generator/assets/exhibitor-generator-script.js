jQuery(document).ready(function($){
    let fileContent = "";
    let fileArray = "";
    let fileLabel = "";
    let filteredArray = [];
    const tableCont = [];
    let emailTrue = true;
    const modal = $(".modal__element");
    const closeBtn = modal.find(".btn-close");

    const pageLang = (send_data['lang'] == "pl_PL") ? 'pl' : 'en';
    
    $(".tabela-masowa").on("click",function(){
        modal.show();
        $("footer").hide();
    });

    closeBtn.on("click", function () {
        modal.hide();
        $("footer").show();
    });
        
    $("#mass-table, .company").on("click", function(){
        if($(this).next().hasClass("company-error")){
            $(this).next().remove();
        }
    });

    $('.info-box-sign').on('mouseenter', function(){
        $('.file-size-info').show();
    }).on('mouseleave', function(){
        $('.file-size-info').hide();
    });

    $("#fileUpload").on("change", function(event) {
        filteredArray = [];

        $('.file-selector').remove();
        $('.file-error').remove();
        $('.file-size-error').hide();

        const file = event.target.files[0];

        if (!file) {
            alert("Nie wybrano pliku.");
            return;
        }

        const allowedExtensions = ["csv", "xls", "xlsx"];
        const fileExtension = file.name.split(".").pop().toLowerCase();

        if (!allowedExtensions.includes(fileExtension)) {
            alert("Niewłaściwy typ pliku. Proszę wybrać plik CSV, XLS lub XLSX.");
            return;
        }

        $(".modal__element").find('.inner').prepend("<div id='spinner' class='spinner'></div>");

        const reader = new FileReader();
        
        reader.onload = function(e) {
            if(file.name.split(".").pop().toLowerCase() != "csv"){
                const data = new Uint8Array(e.target.result);

                if( data.length > 1200000) {
                    $(".email-error").remove();
                    $(".file-size-error").show();
                    return;
                }

                const workbook = XLSX.read(data, { type: "array" });
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                fileContent = XLSX.utils.sheet_to_csv(worksheet);
            } else {
                fileContent = e.target.result;

                if (fileContent.length > 1200000){
                    $(".email-error").remove();
                    $(".file-size-error").show();
                    return;
                }
            }
            
            fileContent = fileContent.replace(/\r/g, "");
                                
            fileArray = fileContent.split(/\n(?=(?:[^"]|"[^"]*")*$)/);

            fileArray.forEach(function(element){
                if (element.trim() !== "" && !/^[,\s"]+$/.test(element)){
                    let newElement = element.split(/,(?=(?:[^"]|"[^"]*")*$)/);

                    newElement = newElement.map(function(elem){ 
                        elem = elem.replace(/\\\\/g, ``);
                        elem = elem.replace(/\\"/g, ``);
                        return elem;
                    });

                    filteredArray.push(newElement);
                }
            });

            fileLabel = filteredArray[0];

            // $("#spinner").remove();
            $(".file-uloader").after("<div class='file-selector'><label>Kolumna z adresami e-mail</label><select type='select' id='email-column' name='email-column' class='selectoret'></select></div>");
            $(".file-uloader").after("<div class='file-selector'><label>Kolumna z imionami i nazwiskami</label><select type='select' id='name-column' name='name-column' class='selectoret'></select></div>");
            
            $(".selectoret").each(function(){
                $(this).append("<option value=''>Wybierz</option>");
            });

            fileLabel.forEach(function(element) {
                $(".selectoret").each(function(){
                    if(element != ""){
                        $(this).append(`<option value="${element}">${element}</option>`);
                    }
                })
            });

            $("#email-column").on("change", function(){
                const chosenLabel = $(this).val();
                const chosenID = fileLabel.findIndex(label => label == chosenLabel );
                let chosenErrors = -1;
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
                for (let i = 1; i < filteredArray.length; i++){
                    const rowArray = filteredArray[i];

                    if (chosenErrors > 5){
                        if (!$(".file-selector").next(".email-error").length) { 
                            if(pageLang == "pl"){
                                $(".file-selector").has("#email-column").after("<p class='email-error error-color'>W wybranej kolumnie znajduje się więcej niż 5 błędnych maili proszę o poprawienie przed kontynuacją.");
                            } else {
                                $(".file-selector").has("#email-column").after("<p class='email-error error-color'>In the selected column, there are more then 5 wrong email, please please correct them before continue</p>");
                            }
                        }
                        emailTrue = false;
                        break ;
                    } else if (rowArray[chosenID].length < 5 || !emailPattern.test(rowArray[chosenID].trim())){
                        console.log('wrong email - ' + rowArray[chosenID]);
                        chosenErrors++;
                    } else {
                        emailTrue = true;
                    }
                };

                if(emailTrue){
                    $(".error-color").remove();
                }
            });
        };

        $(".vars-to-insert").on("change", function(){
            if($(this).parent().next().attr("class").match(/-error/) == "-error"){
                $(this).parent().next().remove();
            }
        });

        if (fileExtension === "csv") {
            reader.readAsText(file);
        } else {
            reader.readAsArrayBuffer(file);
        }
    });

    $(".wyslij").on("click",function(){
        if(!emailTrue){                 
            return;
        }
        let company_name = "";
        let emailColumn = "";
        let nameColumn = "";
        let fileTrue = false;


        if ($("#fileUpload").val() != ""){
            fileTrue = true;
        } else {
            if(pageLang == "pl"){
                $("#fileUpload").after("<p class='file-error error-color'>Proszę zamieścić plik</p>");
            } else {
                $("#fileUpload").after("<p class='file-error error-color'>Please add an file</p>");
            }
        }

        if ($(".company").val() != ""){
            company_name = $(".company").val();
        } else {
            if(pageLang == "pl"){
                $(".company").after("<p class='company-error error-color'>Nazwa firmy jest wymagana</p>");
            } else {
                $(".company").after("<p class='company-error error-color'>Company Name is required</p>");
            }
        }

        if ($("#email-column").val() != ""){
            emailColumn = $("#email-column").val();
        } else {
            if(pageLang == "pl"){
                $(".file-selector").has("#email-column").after("<p class='company-error error-color'>Wybierz kolumne z emailami</p>");
            } else {
                $(".file-selector").has("#email-column").after("<p class='company-error error-color'>Email required</p>");
            }
        }

        if ($("#name-column").val() != ""){
            nameColumn = $("#name-column").val();
        } else {
            if(pageLang == "pl"){
                $(".file-selector").has("#name-column").after("<p class='company-error error-color'>Wybierz kolumne z danymi</p>");
            } else {
                $(".file-selector").has("#name-column").after("<p class='company-error error-color'>Names required</p>");
            }
        }
        
        if(company_name == "" || emailColumn == "" || nameColumn == "" || fileTrue === false){
            return;
        }

        const namelIndex = fileLabel.indexOf(nameColumn);
        const emailIndex = fileLabel.indexOf(emailColumn);
        let emailErrors = 0;

        const tableCont = filteredArray.reduce((acc, row) => {
            const rowArray = row;
            if (rowArray[emailIndex] && rowArray[emailIndex].length > 5 && emailErrors < 5) {
                acc.push({ "name": rowArray[namelIndex], "email": rowArray[emailIndex] });
            } else if (emailErrors < 5) {
                emailErrors++;
            } else {
                emailTrue = true;
            }
            return acc;
        }, []);

        if (tableCont.length > 0 && tableCont.length < 5000 && emailErrors < 5){
            $(".modal__element .inner").prepend("<div id=spinner class=spinner></div>");

            $.post(send_data['send_file'], {
                token: send_data['secret'],
                lang: pageLang,
                company: $(".company").val(),
                data: tableCont

            }, function(response) {

                resdata = JSON.parse(response);
                $(".modal__element .inner").children().each(function(){
                    $(this).not('.btn-close').remove();
                })
                if (resdata == 1){
                    $(".modal__element .inner").append("<p style='color:green; font-weight: 600; width: 90%;'>Dziękujemy za skorzystanie z generatora zaproszeń. Państwa goście wkrótce otrzymają zaproszenia VIP.</p>");
                } else {
                    $(".modal__element .inner").append("<p style='color:red; font-weight: 600; width: 90%;'>Przepraszamy, wystąpił problem techniczny. Spróbuj ponownie później lub zgłoś problem mailowo</p>");
                }
                //console.log(resdata);
                
            $("#spinner").remove();
                tableCont.splice(0, tableCont.length);
                $("#dataContainer").empty();
            });
        } else {
            if(pageLang == "pl"){
                $(".wyslij").before("<p class='company-error error-color' style='font-weight:700;'>Przepraszamy, wystąpił problem techniczny. Spróbuj ponownie później lub zgłoś problem mailowo</p>");
            } else {
                $(".wyslij").before("<p class='company-error error-color' style='font-weight:700;'>Company Name is required</p>");
            }
        }
    });
});

var btnExhElements = document.querySelectorAll(".btn-exh");
btnExhElements.forEach(function(btnExhElement) {
    btnExhElement.addEventListener("click", function() {
        var containerElements = document.querySelectorAll(".container");
        var infoItemElements = document.querySelectorAll(".info-item");

        containerElements.forEach(function(containerElement) {
            containerElement.classList.toggle("log-in");
        });

        infoItemElements.forEach(function(infoItemElement) {
            infoItemElement.classList.toggle("none");
        });
    });
});

            
if (document.querySelector("html").lang === "pl") {
    const companyNameInput = document.querySelector(".pwe-exhibitor-worker-generator input[placeholder='FIRMA ZAPRASZAJĄCA']");
    const companyEmailInput = document.querySelector(".pwe-exhibitor-worker-generator input[placeholder='E-MAIL OSOBY ZAPRASZANEJ']");
    if (companyNameInput && companyEmailInput) {
        companyNameInput.placeholder = "FIRMA";
        companyEmailInput.placeholder = "E-MAIL";
    }
} else {
    const companyNameInputEn = document.querySelector(".pwe-exhibitor-worker-generator input[placeholder='INVITING COMPANY']");
    const companyEmailInputEn = document.querySelector(".pwe-exhibitor-worker-generator input[placeholder='E-MAIL OF THE INVITED PERSON']");
    if (companyNameInputEn && companyEmailInputEn) {
        companyNameInputEn.placeholder = "COMPANY";
        companyEmailInputEn.placeholder = "E-MAIL";
    }
}