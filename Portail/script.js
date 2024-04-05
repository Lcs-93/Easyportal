document.getElementById("sendMessageButton").addEventListener("click", function() {
    var message = "Ouvrir"; // Spécifiez le message que vous souhaitez envoyer

    // Envoie du message au serveur Flask
    fetch('http://192.168.0.94:8080/message', {
        method: 'POST', // Utilisation de la méthode POST pour envoyer les données
        headers: {
            'Content-Type': 'application/json' // Définition du type de contenu à JSON
        },
        body: JSON.stringify({ message: message }) // Envoie le message sous forme de JSON
    })
    .then(response => response.json()) // Traitement de la réponse JSON de retour du serveur
    .then(data => {
        console.log('Réponse du serveur:', data); // Affichage de la réponse du serveur dans la console
        // Ajoutez ici le code pour traiter la réponse du serveur si nécessaire
    })
    .catch(error => {
        console.error('Erreur lors de l\'envoi du message:', error); // Gestion des erreurs lors de l'envoi du message
    });
});