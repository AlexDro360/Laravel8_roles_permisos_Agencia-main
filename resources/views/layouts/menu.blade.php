<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class=" fas fa-building"></i><span>Dashboard</span>
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
    @can('ver-blog')
    <a class="nav-link" href="/blogs">
        <i class=" fas fa-blog"></i><span>Materias</span>
    </a>
    @endcan
    @can('ver-escuela')
    <a class="nav-link" href="/escuelas">
        <i class=" fas fa-blog"></i><span>Maestros</span>
    </a>
    @endcan
    @can('ver-asignar')
    <a class="nav-link" href="/asignar">
        <i class=" fas fa-blog"></i><span>Asignar</span>
    </a>
    @endcan
    @can('ver-materias')
    <a class="nav-link" href="/materias">
        <i class=" fas fa-blog"></i><span>Materias</span>
    </a>
    @endcan
</li>
