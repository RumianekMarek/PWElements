<?php 

/**
 * Class PWEExhibitorVisitorGenerator
 */
class PWEExhibitorVisitorGenerator extends PWEExhibitorGenerator {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    private static function generateToken() {
        $domain = $_SERVER["HTTP_HOST"];
        $secret_key = '^GY0ZlZ!xzn1eM5';
        return hash_hmac('sha256', $domain, $secret_key);
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {

        extract( shortcode_atts( array(
            'exhibitor_generator_form_id' => '',
            'exhibitor_generator_html_text' => '',
        ), $atts ));

        $send_file = plugins_url('other/mass_vip.php', dirname(dirname(dirname(__FILE__))));
        $token = $_GET['token'];

        $generator_html_text_decoded = base64_decode($exhibitor_generator_html_text);
        $generator_html_text_decoded = urldecode($generator_html_text_decoded);
        $generator_html_text_content = wpb_js_remove_wpautop($generator_html_text_decoded, true);

        $output = '';
        $output .= '
        <div class="exhibitor-generator">
            <div class="exhibitor-generator__wrapper">
                <div class="exhibitor-generator__left">
                    <div class="exhibitor-generator__left-wrapper">
                        <h3>' . self::languageChecker('WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!', 'GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!') . '</h3>
                    </div>
                </div>
                <div class="exhibitor-generator__right">
                    <div class="exhibitor-generator__right-wrapper">
                        <div class="exhibitor-generator__right-title">
                            <h3>' . self::languageChecker('WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!', 'GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!') . '</h3>
                        </div>
                        <div class="exhibitor-generator__right-icons">
                            <h5>' . self::languageChecker('Identyfikator VIP uprawnia do:', 'The VIP invitation entitles you to:') . '</h5>
                            <div class="exhibitor-generator__right-icons-wrapper">
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico1.png" alt="icon1">
                                    <p>' . self::languageChecker('Bezpłatnego skorzystania ze strefy VIP ROOM', 'Free use of the VIP ROOM zone') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico3.png" alt="icon3">
                                    <p>' . self::languageChecker('Fast track', 'Fast track') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico4.png" alt="icon4">
                                    <p>' . self::languageChecker('Opieki concierge`a', 'Concierge care') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico2.png" alt="icon2">
                                    <p>' . self::languageChecker('Uczestnictwa<br>we wszystkich konferencjach branżowych', 'Participation<br>in all industry conferences') . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="exhibitor-generator__right-form">
                            [gravityform id="'. $exhibitor_generator_form_id .'" title="false" description="false" ajax="false"]
                        </div>';
                        // if ($token == "masowy") {
                            $output .= '<button class="tabela-masowa btn-gold">' . self::languageChecker('Wysyłka zbiorcza', 'Collective send') . '</button>';
                        // }
                        if (!empty($generator_html_text_content)) {
                            $output .= '<div class="exhibitor-generator__right-text">' . $generator_html_text_content . '</div>';
                        }
                    $output .= '    
                    </div>
                </div>
            </div>
        </div>
        ';

        // if ($token == "masowy") {
            $output .= '
            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    let fileContent = "";
                    let fileArray = "";

                    $(".tabela-masowa").on("click",function(){
                        const tableCont = [];

                        $("footer").hide();

                        let modalBox = "";
                        const $modal = $("<div></div>")
                            .addClass("modal")
                            .attr("id", "my-modal");

                        modalBox = `<div class="modal__elements">
                                        <span class="btn-close">x</span>
                                        <p style="max-width:90%;">'.
                                            self::languageChecker(
                                                <<<PL
                                                Uzupełnij poniżej nazwę firmy zapraszającej oraz wgraj plik (csv, xls, xlsx) z danymi osób, które powinny otrzymać zaproszenia VIP GOLD. Przed wysyłką zweryfikuj zgodność danych.
                                                PL,
                                                <<<EN
                                                Fill in below the name of the inviting company and the details of the people who should receive VIP GOLD invitations. Verify the accuracy of the data before sending.
                                                EN
                                            )
                                        .'</p>
                                        <input type="text" class="company" placeholder="'.
                                            self::languageChecker(
                                                <<<PL
                                                Firma Zapraszająca (wpisz nazwę swojej firmy)
                                                PL,
                                                <<<EN
                                                Inviting Company (your company's name)
                                                EN
                                            )
                                        .'"></input>
                                        <div class="file-uloader">
                                            <label for="fileUpload">Wybierz plik z danymi</label>
                                            <input type="file" id="fileUpload" name="fileUpload" accept=".csv, .xls, .xlsx">
                                            <p class="under-label">Dozwolone rozszerzenia .csv, .xls, .xlsx</p>
                                        </div>
                                        <button class="wyslij btn-gold">'.
                                            self::languageChecker(
                                                <<<PL
                                                Wyślij
                                                PL,
                                                <<<EN
                                                Send
                                                EN
                                            )
                                        .'</button>
                                    </div>`;

                        $modal.html(modalBox);

                        $(".page-wrapper").prepend($modal);

                        $modal.css("display", "flex");
                        let $closeBtn = $modal.find(".btn-close");

                        $closeBtn.on("click", function () {
                            $modal.hide();
                            $("footer").show();
                        });

                        $modal.on("click", function (event) {
                            if ($(event.target)[0] === $modal[0]) {
                                $modal.hide();
                                $("footer").show();
                            }
                        });
                        
                        $("#mass-table, .company").on("click", function(){
                            if($(this).next().hasClass("company-error")){
                                $(this).next().remove();
                            }
                        });

                        $(document).ready(function() {
                            $("#fileUpload").on("change", function(event) {
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

                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    fileContent = e.target.result;

                                    if(file.name.split(".").pop().toLowerCase() != "csv"){
                                        const data = new Uint8Array(e.target.result);
                                        const workbook = XLSX.read(data, { type: "array" });
                                        const firstSheetName = workbook.SheetNames[0];
                                        const worksheet = workbook.Sheets[firstSheetName];
                                        fileContent = XLSX.utils.sheet_to_csv(worksheet);
                                    } else {
                                        fileContent = e.target.result;
                                    }

                                    fileArray = fileContent.split("\n");
                                    const fileLabel = fileArray[0].split(",");

                                    $(".file-uloader").after(`<div class="file-selctor"><label>Kolumna z adresami e-mail</label><select type="select" id="email-column" name="email-column" class="selectoret"></select></div>`);
                                    $(".file-uloader").after(`<div class="file-selctor"><label>Kolumna z imionami i nazwiskami</label><select type="select" id="name-column" name="name-column" class="selectoret"></select></div>`);
                                    
                                    $(".selectoret").each(function(){
                                        $(this).append(`<option value="">Wybierz</option>`);
                                    });

                                    fileLabel.forEach(function(element) {
                                        $(".selectoret").each(function(){
                                            $(this).append(`<option value="${element}">${element}</option>`);
                                        })
                                    });
                            
                                    $("#fileContent").text(fileContent);
                                };

                                if (fileExtension === "csv") {
                                    reader.readAsText(file);
                                } else {
                                    reader.readAsArrayBuffer(file);
                                }
                            });
                        });

                        $(".wyslij").on("click",function(){
                            pageLang = "' . get_locale() . '" == "pl_PL" ? "pl" : "en";
                            let company_name = "";
                            let emailColumn = "";
                            let nameColumn = "";

                            if ($(".company").val() != ""){
                                company_name = $(".company").val();
                            } else {
                                $(".company").after(`<p class="company-error error-color" >'.
                                    self::languageChecker(
                                        <<<PL
                                        Nazwa firmy jest wymagana
                                        PL,
                                        <<<EN
                                        Company Name is required
                                        EN
                                    )
                                .'</p>`);
                            }

                            if ($("#email-column").val() != ""){
                                emailColumn = $("#email-column").val();
                            } else {
                                $(".file-selctor").has("#email-column").after(`<p class="company-error error-color" >'.
                                    self::languageChecker(
                                        <<<PL
                                        Wybierz kolumne z danymi
                                        PL,
                                        <<<EN
                                        Company Name is required
                                        EN
                                    )
                                .'</p>`);
                            }
                            if ($("#name-column").val() != ""){
                                nameColumn = $("#name-column").val();
                            } else {
                                $(".file-selctor").has("#name-column").after(`<p class="company-error error-color" >'.
                                    self::languageChecker(
                                        <<<PL
                                        Wybierz kolumne z danymi
                                        PL,
                                        <<<EN
                                        Company Name is required
                                        EN
                                    )
                                .'</p>`);
                            }
                            
                            if(company_name == "" || emailColumn == "" || nameColumn == ""){
                                return;
                            }

                            let fileLabel = fileArray.shift();

                            fileLabel = fileLabel.split(",");
                            const namelIndex = fileLabel.indexOf(nameColumn);
                            const emailIndex = fileLabel.indexOf(emailColumn);
                                        
                            const tableCont = fileArray.reduce((acc, row) => {
                                const rowArray = row.split(",");
                                if (rowArray[emailIndex] && rowArray[emailIndex].length > 5) {
                                    acc.push({ "name": rowArray[namelIndex], "email": rowArray[emailIndex] });
                                }
                                return acc;
                            }, []);

                            if (tableCont.length > 0 && tableCont.length < 5000 ){
                                $(".modal__elements").html("<span class=btn-close>x</span>");
                                $(".modal__elements").append("<div id=spinner class=spinner></div>");
                                $closeBtn = $modal.find(".btn-close");
                                $.post("' . $send_file . '", {
                                    token: "' . self::generateToken() .'",
                                    lang: pageLang,
                                    company: $(".company").val(),
                                    data: tableCont
                                }, function(response) {

                                    resdata = JSON.parse(response);
                                    
                                    if (resdata == 1){
                                        $(".modal__elements").append(`<p style="color:green; font-weight: 600; width: 90%;">Dziękujemy za skorzystanie z generatora zaproszeń. Państwa goście wkrótce otrzymają zaproszenia VIP.</p>`);
                                    } else {
                                        $(".modal__elements").append(`<p style="color:red; font-weight: 600; width: 90%;">Przepraszamy, wystąpił problem techniczny. Spróbuj ponownie później lub zgłoś problem mailowo</p>`);
                                    }
                                    console.log(resdata);
                                    
                                    $("#spinner").remove();
                                    tableCont.splice(0, tableCont.length);
                                    $("#dataContainer").empty();
                                });
                            } else {
                                $(".wyslij").before(`<p class="company-error error-color" style="font-weight:700;">'.
                                    self::languageChecker(
                                        <<<PL
                                        Przepraszamy, wystąpił problem techniczny. Spróbuj ponownie później lub zgłoś problem mailowo
                                        PL,
                                        <<<EN
                                        Company Name is required
                                        EN
                                    )
                                .'</p>`);
                            }
                        });
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
                })

            </script>';
        // }

        return $output; 
    }
}