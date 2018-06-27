<div class="container-fluid pr-0 pl-0">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('brand/logo.jpg') }}" width="50" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">

        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                {{--<li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>--}}
                {{--<li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>--}}
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-arrow-alt-circle-down"></i> Cadastros <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @can('produto-view')
                        <a href="/painel/produtos" class="dropdown-item">
                            Cadastrar produtos
                        </a>
                        @endcan
                        @can('lista-view')
                        <a href="/painel/listas" class="dropdown-item">
                            Cadastrar lista
                        </a>
                        @endcan
                    </div>
                </li>
                @if(Gate::check('usuario-view') || Gate::check('papel-view'))
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-cog"></i> Configurações <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @can('usuario-view')
                        <a href="/painel/usuarios" class="dropdown-item">
                            Usuários
                        </a>
                        @endcan
                        @can('papel-view')
                            <a href="/painel/papeis" class="dropdown-item">
                                Papéis
                            </a>
                        @endcan
                    </div>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @can('perfil-view')
                        <a class="dropdown-item" href="">
                            Perfil
                        </a>
                        @endcan
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sair
                        </a>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</div>
