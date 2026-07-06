document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            once: true,
            offset: 20,
            easing: 'ease-out'
        });
        console.log('✅ AOS initialized');
    }
});
