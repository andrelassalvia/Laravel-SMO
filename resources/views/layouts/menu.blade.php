<nav class="navbar navbar-expand-lg mb-3 navbar--white navbar--main">
  <div class="container-fluid">
    
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{url('/home')}}">Home</a>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Tabelas
          </a>
          <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{route('funcao.index')}}">Funções</a></li>
            <li><a class="dropdown-item" href="{{route('setor.index')}}">Setores</a></li>
            <li><a class="dropdown-item" href="{{route('exame.index')}}">Exames</a></li>
            <li><a class="dropdown-item" href="{{route('grupo.index')}}">Grupos Homogêneos</a></li>
            <li><a class="dropdown-item" href="{{route('risco.index')}}">Riscos</a></li>
            <li><a class="dropdown-item" href="{{route('tipoatendimento.index')}}">Tipos de Atendimentos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Cadastros
          </a>
          <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Empregados</a></li>
            <li><a class="dropdown-item" href="#">Coordenador de PCMSO</a></li>
            <li><a class="dropdown-item" href="#">Atendimentos</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Segurança
          </a>
          <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{route('tipousuario.index')}}">Tipos de Usuários</a></li>
            <li><a class="dropdown-item" href="#">Usuários</a></li>
          </ul>
        </li>
        
      </ul>
      <ul class="navbar-nav nav--usuario ">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu ">
            <li><a class="dropdown-item" href="#">Mudança de Senha</a></li>
            <li><a class="dropdown-item" href="{{url('/logout')}}">Sair</a></li>
            
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>