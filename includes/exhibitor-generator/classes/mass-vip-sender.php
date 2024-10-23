<?php 

/**
 * Class PWEMassVipSender
 */
class PWEMassVipSender extends PWEExhibitorGenerator {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $output = '';

        $output .='
        <div class="modal__element">
            <div class="inner">
                <span class="btn-close">x</span>
                <p style="max-width:90%;">'.
                    PWECommonFunctions::languageChecker(
                        <<<PL
                        Uzupełnij poniżej nazwę firmy zapraszającej oraz wgraj plik (csv, xls, xlsx) z danymi osób, które powinny otrzymać zaproszenia VIP GOLD. Przed wysyłką zweryfikuj zgodność danych.
                        PL,
                        <<<EN
                        Fill in below the name of the inviting company and the details of the people who should receive VIP GOLD invitations. Verify the accuracy of the data before sending.
                        EN
                    )
                .'</p>
                <input type="text" class="company" placeholder="'.
                    PWECommonFunctions::languageChecker(
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
                    <p class="under-label">'.
                    PWECommonFunctions::languageChecker(
                        <<<PL
                        Dozwolone rozszerzenia .csv, .xls, .xlsx;&nbsp;&nbsp;&nbsp; Rozmiar ~1MB
                        PL,
                        <<<EN
                        Allowed extensions: .csv, .xls, .xlsx;&nbsp;&nbsp;&nbsp; Size ~1MB
                        EN
                    )
                    .'</p>
                    <p class="file-size-error error-color"">'.
                        PWECommonFunctions::languageChecker(
                            <<<PL
                            Zbyt duży plik &nbsp;&nbsp;&nbsp; 
                            PL,
                            <<<EN
                            File is to big &nbsp;&nbsp;&nbsp;
                            EN
                        )
                    .'<span class="info-box-sign">i</span></p>
                    <div class="file-size-info">
                        <h5 style="margin-top: 0">
                            '.
                        PWECommonFunctions::languageChecker(
                            <<<PL
                            Jak obniżyć wielkość pliku:</h5>
                            <ul>
                                <li>Zapisz plik (eksportuj) w formacie CSV</li>
                                <li>Usuń kolumny poza Imionami oraz Emailami</li>
                                <li>Użyj darmowego programu (LibreOffice, Open Office ...) do ponownego przetworzenia i zapisania pliku</li>
                                <li>Podziel plik na mniejsze pliki</li>
                            </ul>
                            PL,
                            <<<EN
                            How to reduce file size:</h5>
                                <ul>
                                    <li>Save the file (export) in CSV format</li>
                                    <li>Remove columns other than First Names and Emails</li>
                                    <li>Use free software (LibreOffice, Open Office, etc.) to reprocess and save the file</li>
                                    <li>Split the file into smaller files</li>
                                </ul>
                            EN
                        ). '
                    </div>    
                </div>
                <button class="wyslij btn-gold">'.
                    PWECommonFunctions::languageChecker(
                        <<<PL
                        Wyślij
                        PL,
                        <<<EN
                        Send
                        EN
                    )
                .'</button>
            <div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        ';

        return $output;
    }
}