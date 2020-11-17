<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/panel">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      @if (authMenu('panel.configUser'))
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Config. Usuario
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

          @if (authMenu('panel.userType'))
          <a class="dropdown-item" href="/panel/users_type">Tipo de usuario</a>
          @endif

          @if (authMenu('panel.user'))
          <a class="dropdown-item" href="/panel/user">Usuario</a>
          @endif
        </div>
      </li>
      @endif

    </ul>

    <span class="navbar-text">
      <a class="nav-link" href="{{ route('panel.user.form', [ 'id' => Auth::user()->id ]) }}">
        {{ Auth::user()->name }}
      </a>
    </span>
    <span class="navbar-text">
      <a class="nav-link" href="/panel/login/logout">
        Sair
      </a>
    </span>
  </div>
</nav>