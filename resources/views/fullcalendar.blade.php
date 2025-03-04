@extends('adminlte::page')

@section('adminlte_css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
@stop

@section('content')
    <div class="container">
        <h2>Calendario</h2>
        <div id="calendar"></div>
    </div>
@stop

@section('adminlte_js')
    <!-- FullCalendar (JS) desde CDN versión moderna -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // Debug: muestra las URLs generadas
        console.log("Ajax events URL: {{ url('fullcalendar/ajax') }}");
        console.log("Store URL: {{ url('fullcalendar/store') }}");

        // Inicializamos el calendario con la API moderna
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          selectable: true,
          selectMirror: true,
          // Cargar eventos existentes desde el servidor usando URL absoluta
          events: {
              url: "{{ url('fullcalendar/ajax') }}"
          },

          // Al seleccionar un rango de fechas (o un día si se hace click y arrastra)
          select: function(info) {
            var title = prompt('Título del evento:');
            if (title) {
              // Enviar datos al servidor para crear el evento en la base de datos
              fetch("{{ url('fullcalendar/store') }}", { 
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                  title: title,
                  start: info.startStr,
                  end: info.endStr,
                  allDay: info.allDay
                })
              })
              .then(response => response.json())
              .then(data => {
                // Agregar el evento al calendario usando los datos retornados por el servidor
                calendar.addEvent({
                  id: data.id,
                  title: data.nombre, // en el modelo usamos 'nombre'
                  start: data.fecha_inicio,
                  end: data.fecha_fin,
                  allDay: info.allDay
                });
                displayMessage("Evento creado correctamente");
              })
              .catch(error => {
                console.error('Error:', error);
              });
            }
            calendar.unselect();
          },

          // Opcional: al hacer click en un día, se pregunta por el título del evento
          dateClick: function(info) {
            var title = prompt('Título del evento:');
            if (title) {
              fetch("{{ url('fullcalendar/store') }}", {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                  title: title,
                  start: info.dateStr,
                  end: info.dateStr,
                  allDay: true
                })
              })
              .then(response => response.json())
              .then(data => {
                console.log('Evento creado:', data);
                calendar.addEvent({
                  id: data.id,
                  title: data.nombre,
                  start: data.fecha_inicio,
                  end: data.fecha_fin,
                  allDay: true
                });
                displayMessage("Evento creado correctamente");
              })
              .catch(error => {
                console.error('Error:', error);
              });
            }
          }
        });

        // Renderizamos el calendario
        calendar.render();
      });

      // Función para mostrar mensajes; usa toastr si lo tienes o un alert de lo contrario.
      function displayMessage(message) {
        if (typeof toastr !== 'undefined') {
          toastr.success(message, 'Evento creado');
        } else {
          alert(message);
        }
      }
    </script>
@stop

@section('adminlte_js')
    <script src="{{ asset('color.js') }}"></script>
@stop
