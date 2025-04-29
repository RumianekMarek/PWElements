
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById("myModal");
    const modalTitle = document.getElementById("modal-title");
    const modalContent = document.getElementById("modal-content");
    const closeBtn = modal.querySelector(".close");

    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function () {
        modalTitle.textContent = this.dataset.title;
        modalContent.textContent = this.dataset.content;
        modal.style.display = "block";
        });
    });

    closeBtn.onclick = function () {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target === modal) {
        modal.style.display = "none";
        }
    }
});

querySelector('.store-contact-submit').addEventListener('click', function(){
    console.log('click');
});