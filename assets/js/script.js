const bouton = document.querySelector('.btn-jouer');
bouton.addEventListener('mouseenter', () => {
    bouton.style.transform = 'scale(1.2)';
    bouton.style.boxShadow = '0 0 25px #00ff95';
});
bouton.addEventListener('mouseleave', () => {
    bouton.style.transform = 'scale(1)';
    bouton.style.boxShadow = 'none';
});

$(document).ready(function() {
    // Animation du bonhomme qui réfléchit
    function animateBonhomme() {
        $('#bonhomme').animate({
            rotate: '10deg'
        }, 1000).animate({
            rotate: '0deg'
        }, 1000);
    }

    // Lancer l'animation de réflexion
    setInterval(animateBonhomme, 2000); // Répéter toutes les 2 secondes pour simuler la réflexion
});
