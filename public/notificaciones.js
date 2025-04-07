document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
});

function loadNotifications() {
    fetch('/notificaciones', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        let notificationCountElem = document.getElementById('notificationCount');
        let notificationList = document.getElementById('notificationList');

        if (!notificationList || !notificationCountElem) return; // Evita errores si los elementos no existen

        let notificationCount = 0;
        notificationList.innerHTML = '';

        if (data.length === 0) {
            notificationList.innerHTML = '<li class="px-3 py-2 text-center">No hay notificaciones</li>';
            notificationCountElem.innerText = '0';
            return;
        }

        data.forEach(notificacion => {
            if (!notificacion.read) {
                notificationCount++;
            }

            let listItem = document.createElement('li');
            listItem.innerHTML = `
                <a href="#" class="dropdown-item" data-id="${notificacion.id}">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">${notificacion.title}</h3>
                            <p class="text-sm">${notificacion.message}</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
            `;

            listItem.querySelector('a').addEventListener('click', function(e) {
                e.preventDefault();
                markAsRead(notificacion.id, this);
            });

            notificationList.appendChild(listItem);
        });

        notificationCountElem.innerText = notificationCount || '0';
    })
    .catch(error => console.error('Error cargando notificaciones:', error));
}

function markAsRead(notificationId, element) {
    fetch(`/notificaciones/${notificationId}/leer`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (response.ok) {
            element.closest('li').remove(); // Elimina la notificación de la lista
            loadNotifications(); // Recarga la lista de notificaciones
        }
    })
    .catch(error => console.error('Error al marcar como leída:', error));
}