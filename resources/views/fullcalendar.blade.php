@extends('adminlte::page')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fullcalendar/common.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@stop

@section('content')
<!-- migajas de pan-->
<div class="container py-3 migajas" id="migajas">
    <ul class="breadcrumb">
        <li class="breadcrumb__item breadcrumb__item-firstChild">
            <span class="breadcrumb__inner">
                <a href="/HomeUser" class="breadcrumb__title">Home</a>
            </span>
        </li>
        <li class="breadcrumb__item breadcrumb__item--active">
            <span class="breadcrumb__inner">
                <a href="#" class="breadcrumb__title">Calendario</a>
            </span>
        </li>
    
    </ul>
</div>  
   
    <div class="container">
        <h2 class="mb-4">Calendario de Eventos</h2>
        <div class="mb-4">
            <button class="btn btn-primary" id="createEventBtn">
                <i class="fas fa-plus me-2"></i>Nuevo Evento
            </button>
        </div>
        <div id="calendar"></div>
    </div>

    <!-- Modal para los eventos -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gestión de Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Título del Evento</label>
                                    <input type="text" class="form-control" id="eventTitle" required>
                                    <div class="invalid-feedback">Este campo es obligatorio</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Evento</label>
                                    <select class="form-select" id="eventType">
                                        <option value="meeting">Reunión</option>
                                        <option value="reminder">Recordatorio</option>
                                        <option value="task">Tarea</option>
                                        <option value="holiday">Feriado</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Color del Evento</label>
                                    <input type="color" class="form-control form-control-color" 
                                           id="eventColor" value="#0d6efd">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha y Hora de Inicio</label>
                                    <input type="datetime-local" class="form-control" 
                                           id="eventStart" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Fecha y Hora de Fin</label>
                                    <input type="datetime-local" class="form-control" 
                                           id="eventEnd">
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" 
                                           id="allDayCheck">
                                    <label class="form-check-label">Todo el día</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" id="eventDescription" 
                                      rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" 
                            id="deleteEventBtn" style="display: none;">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                    <button type="button" class="btn btn-secondary" 
                            data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" 
                            id="saveEventBtn">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script> 
    <script src="{{ asset('vendor/fullcalendar/core.global.min.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/daygrid.global.min.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/timegrid.global.min.js') }}"></script>
    <script src="{{ asset('vendor/fullcalendar/list.global.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script> 
<script>
  // plantilla de URL con placeholder ":id"
  const deleteProjectUrlTemplate = "{{ route('projects.destroy', ['project' => ':id']) }}";
  window.calendar;
</script>

    <script>
        // Tomamos el elemento del modal
        const eventModalEl = document.getElementById('eventModal');

        // Cuando se vaya a ocultar el modal...
        eventModalEl.addEventListener('hide.bs.modal', () => {
        const focused = document.activeElement;
        // si el elemento activo está dentro del modal, quitamos el foco
        if (eventModalEl.contains(focused)) {
            focused.blur();
        }
        });

        // Opcional: una vez que se oculte por completo, retiramos aria-hidden
        eventModalEl.addEventListener('hidden.bs.modal', () => {
        eventModalEl.removeAttribute('aria-hidden');
        });



    function confirmDeleteProject(projectId) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción eliminará el proyecto y todos sus datos relacionados. No podrá revertirse.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteProject(projectId);
        }
    });
}

async function deleteProject(projectId) {
  // 1) Validar que venga un ID
  if (!projectId) {
    return Swal.fire('Error','ID de proyecto inválido','error');
  }

  // 2) Leer CSRF token
  const token = document.head.querySelector('meta[name="csrf-token"]').content;

  try {
    // 3) Lanzar DELETE y pedir JSON en error también
    const response = await fetch(`/projects/${projectId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
      }
    });

    // 4) Si status ≠ 2xx, leer cuerpo (texto o JSON) para mensaje
    if (!response.ok) {
      const text = await response.text();
      let msg = `Error ${response.status}`;
      try {
        const json = JSON.parse(text);
        msg = json.message || JSON.stringify(json);
      } catch {}
      throw new Error(msg);
    }

    // 5) Si todo bien, parsear JSON
    const data = await response.json();

    // 6) Ocultar el modal real
    const modalEl = document.getElementById('eventModal');
    const modalInst = bootstrap.Modal.getInstance(modalEl);
    if (modalInst) {
    modalInst.hide();
    
    // Dar tiempo a que el modal se oculte completamente antes de actualizar el calendario
    setTimeout(() => {
        // 7) Refrescar la pagina completa
        window.location.reload();
        
    }, 400); 
    } else {
    // Si no hay modal que ocultar, actualizar el calendario inmediatamente
    if (calendar && typeof calendar.refetchEvents === 'function') {
        calendar.refetchEvents();
    } else if (window.calendar && typeof window.calendar.refetchEvents === 'function') {
        window.calendar.refetchEvents();
    }
    }

    // 8) Mostrar confirmación
    await Swal.fire(
      '¡Eliminado!',
      data.message || 'El proyecto ha sido eliminado correctamente.',
      'success'
    );

  } catch (err) {
    console.error('deleteProject error:', err);
    Swal.fire('Error', err.message || 'No se pudo eliminar el proyecto','error');
  }
}




    document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const eventModal = new bootstrap.Modal('#eventModal');
    let currentEvent = null;
    
    function applyThemeToCalendar() {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        
        const calendarOptions = {
            initialView: 'dayGridMonth',
            selectable: true,
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: "{{ url('fullcalendar/ajax') }}",
            eventClick: handleEventClick,
            select: handleDateSelect,
            eventDidMount: applyEventColors,
            themeSystem: 'bootstrap5'
        };
        
        if (calendar) {
            calendar.destroy();
        }
        
        calendar = new FullCalendar.Calendar(calendarEl, calendarOptions);
        calendar.render();
    }
    
    let calendar;
    applyThemeToCalendar();
    
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
       
        const savedTheme = localStorage.getItem("theme") || "light";
        document.documentElement.setAttribute('data-theme', savedTheme);
        updateButtonIcon(savedTheme);
        
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateButtonIcon(newTheme);
            
            setTimeout(() => {
                applyThemeToCalendar();
                initializeDatePickers();
            }, 100);
        });
    }
    
    function updateButtonIcon(theme) {
        if (!themeToggle) return;
        
        const icon = theme === "dark" ? "fa-sun" : "fa-moon";
        const text = theme === "dark" ? "Modo claro" : "Modo oscuro";
        themeToggle.querySelector('i').className = `fas ${icon}`;
        themeToggle.querySelector('a').innerHTML = `<i class="fas ${icon}"></i> ${text}`;
    }

    document.getElementById('createEventBtn').addEventListener('click', () => showModal());
    document.getElementById('allDayCheck').addEventListener('change', toggleTimeInputs);
    document.getElementById('saveEventBtn').addEventListener('click', handleSaveEvent);
    document.getElementById('deleteEventBtn').addEventListener('click', handleDeleteEvent);

    function initializeDatePickers() {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        const flatpickrTheme = currentTheme === 'dark' ? 'dark' : 'light';
        
        flatpickr('#eventStart', { 
            enableTime: true, 
            dateFormat: 'Y-m-d H:i',
            theme: flatpickrTheme
        });
        
        flatpickr('#eventEnd', { 
            enableTime: true, 
            dateFormat: 'Y-m-d H:i',
            theme: flatpickrTheme
        });
    }
    


    function showModal(event = null) {
        currentEvent = event;
        resetForm();

        // Limpiar los botones de acción de proyecto que pudieran existir de una visualización anterior
        const modalFooter = document.querySelector('.modal-footer');
        const btnsToRemove = modalFooter.querySelectorAll('.project-action-btn');
        btnsToRemove.forEach(btn => btn.remove());

        // Mostrar el botón guardar que podría estar oculto
        document.getElementById('saveEventBtn').style.display = 'inline-block';

        // Habilitar campos que podrían estar deshabilitados
        document.getElementById('eventTitle').disabled = false;
        document.getElementById('eventStart').disabled = false;
        document.getElementById('eventEnd').disabled = false;
        document.getElementById('eventDescription').disabled = false;
        document.getElementById('allDayCheck').disabled = false;

        if (event) {
            document.getElementById('deleteEventBtn').style.display = 'inline-block';
            populateForm(event);
        } else {
            document.getElementById('deleteEventBtn').style.display = 'none';
        }

        eventModal.show();
    }


    function handleDateSelect(info) {
        const startStr = formatDateTimeForInput(info.start);
        const endStr = formatDateTimeForInput(info.end);
        
        document.getElementById('eventStart').value = startStr;
        document.getElementById('eventEnd').value = endStr;
        showModal();
    }

    function formatDateTimeForInput(date) {
        return date.toISOString().slice(0, 16);
    }

    function handleEventClick(info) {
    const eventType = info.event.extendedProps?.tipo === 'proyecto' ? 'proyecto' : 'sprint';
    
    if (eventType === 'proyecto') {
        // Opción 1: Mostrar detalles del proyecto en modal
        showProjectDetails(info.event);
        
        // Opción 2: Redirigir a la página de edición del proyecto
        // const projectId = info.event.extendedProps.proyecto_id;
        // window.location.href = `/projects/${projectId}/edit`;
    } else {
        // Manejador existente para sprints
        showModal(info.event);
    }
}

function showProjectDetails(event) {
    // Modal para proyectos
    currentEvent = event;
    resetForm();
    
    // Configurar campos como solo lectura
    document.getElementById('eventTitle').value = event.title;
    document.getElementById('eventTitle').disabled = true;
    
    if (event.start) {
        document.getElementById('eventStart').value = formatDateTimeForInput(event.start);
        document.getElementById('eventStart').disabled = true;
    }
    
    if (event.end) {
        document.getElementById('eventEnd').value = formatDateTimeForInput(event.end);
        document.getElementById('eventEnd').disabled = true;
    }
    
    document.getElementById('eventDescription').value = event.extendedProps.description || '';
    document.getElementById('eventDescription').disabled = true;
    document.getElementById('allDayCheck').checked = true;
    document.getElementById('allDayCheck').disabled = true;
    
    // Ocultar botón de eliminar estándar
    document.getElementById('deleteEventBtn').style.display = 'none';
    
    // Limpiar botones existentes en el footer
    const modalFooter = document.querySelector('.modal-footer');
    const btnsToRemove = modalFooter.querySelectorAll('.project-action-btn');
    btnsToRemove.forEach(btn => btn.remove());
    
    // Ocultar botones estándar
    document.getElementById('saveEventBtn').style.display = 'none';
    
    // Verificar si el usuario es administrador
    const isAdmin = {{ Auth::user()->usertype == 'admin' ? 'true' : 'false' }};
    
    if (isAdmin) {
        // Añadir botón para editar proyecto SOLO para administradores
        const projectId = event.extendedProps.proyecto_id;
        const editButton = `<button type="button" class="btn btn-primary project-action-btn" 
            onclick="window.location.href='/projects/${projectId}/edit'">
            <i class="fas fa-edit me-2"></i>Editar Proyecto
        </button>`;
        
        modalFooter.insertAdjacentHTML('beforeend', editButton);
        
        // Mostrar botón de eliminar solo para administradores
        const deleteButton = `<button type="button" class="btn btn-danger project-action-btn" 
            onclick="confirmDeleteProject(${projectId})">
            <i class="fas fa-trash me-2"></i>Eliminar Proyecto
        </button>`;
        modalFooter.insertAdjacentHTML('beforeend', deleteButton);
    }
    
    eventModal.show();
}


    async function handleSaveEvent() {
        const formData = getFormData();
        
        if (!validateForm(formData)) return;

        try {
            const url = currentEvent ? 
                `{{ url('fullcalendar/update') }}/${currentEvent.id}` : 
                "{{ url('fullcalendar/store') }}";
            
            const method = currentEvent ? 'PUT' : 'POST';
            
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message || 'Error al procesar la solicitud');
            }
            
            // Refrescar calendario
            calendar.refetchEvents();
            
            showAlert('success', currentEvent ? 
                'Evento actualizado correctamente' : 
                'Evento guardado correctamente');
            
            eventModal.hide();

        } catch (error) {
            showAlert('error', error.message || 'Error al guardar el evento');
            console.error('Error:', error);
        }
    }
             
    function getFormData() {
        return {
            id: currentEvent?.id,
            title: document.getElementById('eventTitle').value,
            start: document.getElementById('eventStart').value,
            end: document.getElementById('eventEnd').value,
            todo_el_dia: document.getElementById('allDayCheck').checked,
            color: document.getElementById('eventColor').value,
            tipo: document.getElementById('eventType').value,
            description: document.getElementById('eventDescription').value
        };
    }

    function validateForm({ title, start }) {
        if (!title.trim()) {
            document.getElementById('eventTitle').classList.add('is-invalid');
            return false;
        }
        
        if (!start) {
            showAlert('warning', 'Seleccione una fecha de inicio');
            return false;
        }
        
        return true;
    }

    function populateForm(event) {
        const extendedProps = event.extendedProps || {};
        
        document.getElementById('eventTitle').value = event.title;
        
        if (event.start) {
            document.getElementById('eventStart').value = formatDateTimeForInput(event.start);
        }
        
        if (event.end) {
            document.getElementById('eventEnd').value = formatDateTimeForInput(event.end);
        }
        
        document.getElementById('eventColor').value = event.backgroundColor || '#0d6efd';
        document.getElementById('eventType').value = extendedProps.tipo || 'meeting';
        document.getElementById('eventDescription').value = extendedProps.description || '';
        document.getElementById('allDayCheck').checked = event.allDay;
        
        toggleTimeInputs();
    }

    function resetForm() {
        document.getElementById('eventForm').reset();
        document.getElementById('eventTitle').classList.remove('is-invalid');
        document.getElementById('eventColor').value = '#0d6efd';
    }

    function toggleTimeInputs() {
        const allDay = document.getElementById('allDayCheck').checked;
        const eventStart = document.getElementById('eventStart');
        const eventEnd = document.getElementById('eventEnd');
        
        // Guardar valores actuales
        const startValue = eventStart.value;
        const endValue = eventEnd.value;
        
        // Cambiar tipo de input
        eventStart.type = allDay ? 'date' : 'datetime-local';
        eventEnd.type = allDay ? 'date' : 'datetime-local';
        
        // Restaurar valores (truncando la hora si es todo el día)
        eventStart.value = allDay ? startValue.slice(0, 10) : startValue;
        eventEnd.value = allDay ? endValue.slice(0, 10) : endValue;
    }

    function applyEventColors(info) {
        info.el.style.backgroundColor = info.event.backgroundColor;
        info.el.style.borderColor = info.event.borderColor || info.event.backgroundColor;
    }

    async function handleDeleteEvent() {
    const result = await Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch(`{{ url('fullcalendar/destroy') }}/${currentEvent.id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const result = await response.json();

        if (result.success) {
            calendar.refetchEvents();
            eventModal.hide();
            showAlert('success', result.message || 'Evento eliminado correctamente');
        } else {
            throw new Error(result.message || 'Error al eliminar el evento');
        }

    } catch (error) {
        showAlert('error', error.message || 'Error de conexión');
        console.error('Error:', error);
    }
}
    
    function showAlert(type, message) {
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        
        Swal.fire({
            icon: type,
            title: type === 'success' ? '¡Éxito!' : 'Error',
            text: message,
            timer: 3000,
            timerProgressBar: true,
            background: currentTheme === 'dark' ? '#2c3b4f' : '#fff',
            color: currentTheme === 'dark' ? '#fff' : '#000'
        });
    }
});
    </script>
@stop



