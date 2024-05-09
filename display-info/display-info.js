/* Show more/less */
jQuery(function ($) { 
    let hiddenContentPWE = true; 

    $(".pwe-see-more").click(function(event) {
        let currentText = $(event.target).text();
        if (pweScriptData.locale === "pl_PL") {
            $(event.target).text(currentText === "więcej..." ? "ukryj..." : "więcej...");
        } else {
            $(event.target).text(currentText === "more..." ? "hidden..." : "more...");
        }
        hiddenContentPWE = !hiddenContentPWE;  
        $(event.target).prev().slideToggle();
    }); 
});
 