<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class=" fas fa-building"></i><span>Panel de Opciones</span>
    </a>
    @can('ver-usuario')
    <a class="nav-link" href="/usuarios">
        <i class=" fas fa-users"></i><span>Usuarios</span>
    </a>
    @endcan
    @can('ver-rol')
    <a class="nav-link" href="/roles">
        <i class=" fas fa-user-lock"></i><span>Roles</span>
    </a>
    @endcan
    @can('ver-materia')
    <a class="nav-link" href="/materias">
        <i class=" fas fa-bookmark"></i><span>Materias</span>
    </a>
    @endcan
    @can('ver-grupo')
    <a class="nav-link" href="/grupos">
        <i class=" fas fa-book-open"></i><span>Grupos</span>
    </a>
    @endcan
    @can('mi-grupo')
    <a class="nav-link" href="/Mis-Grupos">
        <i class=" fas fa-book-reader"></i><span>Mis Grupos</span>
    </a>
    @endcan
</li>
