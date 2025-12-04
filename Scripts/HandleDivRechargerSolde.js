document.addEventListener("DOMContentLoaded", function () {

    // BOUTON "Charger"
    const btnCharger = document.getElementById("btnCharger");
    const chargerDiv = document.getElementById("chargerDiv");

    if (btnCharger && chargerDiv) {
        btnCharger.addEventListener("click", function () {
            chargerDiv.style.display = "block";
        });
    }

    // BOUTON "Recharger"
    const btnRecharger = document.getElementById("btnRecharger");
    const rechargerDiv = document.getElementById("rechargerDiv");

    if (btnRecharger && rechargerDiv) {
        btnRecharger.addEventListener("click", function () {
            rechargerDiv.style.display = "block";
        });
    }

});
