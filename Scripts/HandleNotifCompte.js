document.addEventListener("DOMContentLoaded", () => {

    const form = document.querySelector("#rechargerDiv form");
    const message = document.getElementById("messageSolde");

    form.addEventListener("submit", async (event) => {
        event.preventDefault(); // ⛔ Empêche le rechargement de la page

        const formData = new FormData(form);

        // On envoie les données en AJAX
        await fetch("", {
            method: "POST",
            body: formData,
        });

        // Puis on affiche ton message
        message.style.display = "block";

        // Optionnel : disparition après 5 secondes
        setTimeout(() => {
            message.style.display = "none";
        }, 5000);
    });
});
