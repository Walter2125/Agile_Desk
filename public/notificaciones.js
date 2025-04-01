document.addEventListener("DOMContentLoaded", function () {
    loadNotifications();
    
    document.getElementById('markAllAsRead')?.addEventListener('click', function (e) {
        e.preventDefault();
        markAllAsRead();
    });
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
        let notificationCount = 0;
        let notificationList = document.getElementById('notificationList');
        
        if (!notificationList) return;
        
        notificationList.innerHTML = '';
        
        if (data.length === 0) {
            notificationList.innerHTML = '<li class="px-3 py-2 text-center">No hay notificaciones</li>';
            document.getElementById('notificationCount').innerText = '0';
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
        
        document.getElementById('notificationCount').innerText = notificationCount || '0';
    })
    .catch(error => console.error('Error cargando notificaciones:', error));
}

function markAsRead(id, element) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/notificaciones/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        let countElement = document.getElementById('notificationCount');
        let count = parseInt(countElement.innerText) || 0;
                  
        if (count > 0) {
            countElement.innerText = count - 1;
        }
        
        let listItem = element.closest('li');
        if (listItem) {
            listItem.remove();
        }
        
        let notificationList = document.getElementById('notificationList');
        if (notificationList.children.length === 0) {
            notificationList.innerHTML = '<li class="px-3 py-2 text-center">No hay notificaciones</li>';
        }
    })
    .catch(error => console.error('Error:', error));
}

function markAllAsRead() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/notificaciones/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(() => {
        document.getElementById('notificationCount').innerText = '0';
        let notificationList = document.getElementById('notificationList');
        notificationList.innerHTML = '<li class="px-3 py-2 text-center">No hay notificaciones</li>';
    })
    .catch(error => console.error('Error:', error));
}