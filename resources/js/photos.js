// Модальное окно для фотографий
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('photoModal');
    if (!modal) return;
    
    const modalImage = modal.querySelector('.photo-modal__image');
    const modalCaption = modal.querySelector('.photo-modal__caption');
    const modalClose = modal.querySelector('.photo-modal__close');
    const modalOverlay = modal.querySelector('.photo-modal__overlay');
    const photoItems = document.querySelectorAll('.photos-item');
    
    // Получаем данные фотографий из JSON
    const photosDataElement = document.getElementById('photos-data');
    const photosData = photosDataElement ? JSON.parse(photosDataElement.textContent) : [];

    // Открытие модального окна
    photoItems.forEach(item => {
        item.addEventListener('click', function() {
            const photoId = parseInt(this.dataset.photoId);
            const photo = photosData.find(p => p.id === photoId);
            
            if (photo) {
                // Устанавливаем изображение
                modalImage.src = photo.image;
                modalImage.alt = photo.title || 'Фото';
                
                // Устанавливаем подпись/описание
                if (photo.title || photo.description) {
                    let captionHTML = '';
                    if (photo.title) {
                        captionHTML += `<h3>${photo.title}</h3>`;
                    }
                    if (photo.description) {
                        captionHTML += `<p>${photo.description}</p>`;
                    }
                    modalCaption.innerHTML = captionHTML;
                } else {
                    modalCaption.innerHTML = '';
                }
                
                // Показываем модальное окно
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Закрытие модального окна
    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }

    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (modalOverlay) modalOverlay.addEventListener('click', closeModal);
    
    // Закрытие по ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
});
