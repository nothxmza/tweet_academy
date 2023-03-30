window.onload = function () {
    // Récupérer les éléments du formulaire
    const mailInput = document.getElementById('mail');
    const passwordInput = document.getElementById('password');
    const submitButton = document.querySelector('input[type="submit"]');

    // Ajouter des écouteurs d'événements pour chaque champ
    mailInput.addEventListener('input', validateForm);
    passwordInput.addEventListener('input', validateForm);

    // Fonction de validation de formulaire
    function validateForm() {
        // Vérifier si tous les champs sont remplis
        if (mailInput.value != "" && passwordInput.value != "") {
            // Activer le bouton de soumission
            submitButton.disabled = false;
        } else {
            // Désactiver le bouton de soumission
            submitButton.disabled = true;
        }
    }
}