document.addEventListener("DOMContentLoaded", function() {
    const btnRecharger = document.getElementById("btnRecharger");
    const rechargerDiv = document.getElementById("rechargerDiv");

    if (btnRecharger) {
        btnRecharger.addEventListener("click", function() {
            rechargerDiv.style.display = "block";
        });
    }
});