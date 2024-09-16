if (document.querySelector('html').lang === 'pl-PL') {
    const companyNameInput = document.querySelector('.pwe-exhibitor-worker-generator input[placeholder="FIRMA ZAPRASZAJĄCA"]');
    const companyEmailInput = document.querySelector('.pwe-exhibitor-worker-generator input[placeholder="E-MAIL OSOBY ZAPRASZANEJ"]');
    if (companyNameInput && companyEmailInput) {
        companyNameInput.placeholder = 'FIRMA';
        companyEmailInput.placeholder = 'E-MAIL';
    }
} else {
    const companyNameInputEn = document.querySelector('.pwe-exhibitor-worker-generator input[placeholder="INVITING COMPANY"]');
    const companyEmailInputEn = document.querySelector('.pwe-exhibitor-worker-generator input[placeholder="E-MAIL OF THE INVITED PERSON"]');
    if (companyNameInputEn && companyEmailInputEn) {
        companyNameInputEn.placeholder = 'COMPANY';
        companyEmailInputEn.placeholder = 'E-MAIL';
    }
}