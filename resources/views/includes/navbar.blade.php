<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        
      <a class="navbar-brand" href="{{ url('/') }}" > {{ config('app.name', 'Laravel') }}</a>   
     
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">


          @if (in_array(Auth::user()->role, ['admin']))
          <li class="nav-item ">
            <a class="nav-link  {{ (request()->is('entities')) ? 'active' : '' }}" href="{{url('/entities')}}">Entities</a>
          </li>

          <li class="nav-item ">
            <a class="nav-link  {{ (request()->is('users')) ? 'active' : '' }}" href="{{url('/users')}}">Users</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link  {{ (request()->is('providers')) ? 'active' : '' }}" href="{{url('/providers')}}">Providers</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link  {{ (request()->is('accounts')) ? 'active' : '' }}" href="{{url('/accounts')}}">Accounts</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link  {{ (request()->is('cloudapi')) ? 'active' : '' }}" href="{{url('/cloudapi')}}">Cloudapi</a>
          </li>
          @endif
          {{-- <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li> --}}
        </ul>
        <div class="d-flex">

            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                  <li class="nav-item dropdown">

                    <div class="btn-group">

                      <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                      </button>

                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                        <li><button class="dropdown-item" type="button">{{ auth::user()->entity->name }}</button></li>
                        <li><a class="dropdown-item" href="{{url('/users')}}">User Management</a></li>
                        <li><button class="dropdown-item" type="button"
                                href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                          >{{ __('Logout') }}</button></li>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                      </ul>
                    </div>

                  </li> 
              
                @endguest
            </ul>
        </div>
      </div>
    </div>
  </nav>