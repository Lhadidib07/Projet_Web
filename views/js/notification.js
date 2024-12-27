function showNotification(message) {
    const notification = document.getElementById('notification');
    const messageElement = document.getElementById('notification-message');

    // Mettre à jour le message
    messageElement.textContent = message;

    // Afficher la notification
    notification.classList.remove('hidden');
    notification.classList.add('visible');

    // Masquer automatiquement après 5 secondes (optionnel)
    setTimeout(() => {
        hideNotification();
    }, 5000);
}

function hideNotification() {
    const notification = document.getElementById('notification');
    notification.classList.remove('visible');
    notification.classList.add('hidden');
}