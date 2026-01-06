import './bootstrap';
import './photos';

// Плавная прокрутка к контенту при клике на навигацию
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav__link');
    
    navLinks.forEach(link => {
        // Только для внутренних ссылок (не external)
        if (!link.hasAttribute('target')) {
            link.addEventListener('click', function(e) {
                const contentElement = document.getElementById('content');
                if (contentElement) {
                    // Небольшая задержка перед скроллом, чтобы дать странице загрузиться
                    setTimeout(() => {
                        contentElement.scrollIntoView({ 
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 100);
                }
            });
        }
    });
});
