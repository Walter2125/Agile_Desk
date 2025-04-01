<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Área personal</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/cursos') }}">Mis cursos</a></li>
        @isset($curso)
            <li class="breadcrumb-item"><a href="{{ url('/cursos/'.$curso->id) }}">{{ $curso->codigo }}</a></li>
        @endisset
        @isset($seccion)
            <li class="breadcrumb-item active" aria-current="page">{{ $seccion }}</li>
        @endisset
    </ol>
</nav>