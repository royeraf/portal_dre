        <!-- ########## START: LEFT PANEL ########## -->
        <div class="br-logo"><a href=""><span>[</span>Huaca. <i>UGEL</i><span>]</span></a></div>
        <div class="br-sideleft sideleft-scrollbar">
        <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
        <ul class="br-sideleft-menu">
            <li class="br-menu-item">
            <a href="{{route('intranet')}}" class="br-menu-link active">
                <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
                <span class="menu-item-label">Home</span>
            </a><!-- br-menu-link -->
            </li><!-- br-menu-item -->
            <li class="br-menu-item">
                <a href="{{route('home')}}" class="br-menu-link">
                  <i class="menu-item-icon icon ion-ios-color-filter-outline tx-24"></i>
                  <span class="menu-item-label">Portal</span>
                </a><!-- br-menu-link -->
            </li>
            <li class="br-menu-item">
            <a href="{{route('archivo')}}" class="br-menu-link">
                <i class="menu-item-icon icon ion-ios-email-outline tx-24"></i>
                <span class="menu-item-label">Archivos</span>
            </a><!-- br-menu-link -->
            </li><!-- br-menu-item -->
            <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
                <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
                <span class="menu-item-label">Menu</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{route('formregistro')}}" class="sub-link">Administrar</a></li>
            </ul>
            </li>
            <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
                <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
                <span class="menu-item-label">Slider</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{route('slide.create')}}" class="sub-link">Registrar</a></li>
            </ul>
            </li><!-- br-menu-item -->
            <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
                <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
                <span class="menu-item-label">Convocatorias</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub nav flex-column">
                <li class="sub-item"><a href="{{route('convocatoria.create')}}" class="sub-link">Registrar</a></li>
                <li class="sub-item"><a href="{{route('convocatoria')}}" class="sub-link">Administrar</a></li>
            </ul>
            </li><!-- br-menu-item -->
            <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
                <i class="menu-item-icon icon ion-ios-briefcase-outline tx-22"></i>
                <span class="menu-item-label">Directorio</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="{{route('directorio.create')}}" class="sub-link">Registrar</a></li>
                <li class="sub-item"><a href="{{route('directorio')}}" class="sub-link">Administrar</a></li>
            </ul>
            </li><!-- br-menu-item -->
            <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
                <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
                <span class="menu-item-label">Noticias</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub nav flex-column">
                <li class="sub-item"><a href="{{route('noticias')}}" class="sub-link">Administrar</a></li>
                <li class="sub-item"><a href="{{route('noticias.create')}}" class="sub-link">Nueva</a></li>
            </ul>
            </li><!-- br-menu-item -->
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub">
                    <i class="menu-item-icon icon ion-ios-paper-outline tx-22"></i>
                    <span class="menu-item-label">Popup</span>
                </a><!-- br-menu-link -->
                <ul class="br-menu-sub nav flex-column">
                    <li class="sub-item"><a href="{{route('popup')}}" class="sub-link">Administrar</a></li>
                    <li class="sub-item"><a href="{{route('popup.create')}}" class="sub-link">Nueva</a></li>
                </ul>
            </li><!-- br-menu-item -->
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub">
                  <i class="menu-item-icon icon ion-ios-book-outline tx-22"></i>
                  <span class="menu-item-label">Imagen Eventos</span>
                </a><!-- br-menu-link -->
                <ul class="br-menu-sub nav flex-column">
                    <li class="sub-item"><a href="{{route('galeria')}}" class="sub-link">Administrar</a></li>
                    <li class="sub-item"><a href="{{route('galeria.create')}}" class="sub-link">Nueva</a></li>
                </ul>
            </li>
            <li class="br-menu-item">
                <a href="#" class="br-menu-link with-sub">
                  <i class="menu-item-icon icon ion-ios-list-outline tx-22"></i>
                  <span class="menu-item-label">Comunicados</span>
                </a><!-- br-menu-link -->
                <ul class="br-menu-sub nav flex-column">
                    <li class="sub-item"><a href="{{route('comunicado')}}" class="sub-link">Administrar</a></li>
                    <li class="sub-item"><a href="{{route('comunicado.create')}}" class="sub-link">Nueva</a></li>
                </ul>
            </li>            
        </ul><!-- br-sideleft-menu -->
        <br>
        </div><!-- br-sideleft -->
        <!-- ########## END: LEFT PANEL ########## -->
        <!-- ########## START: HEAD PANEL ########## -->
        <div class="br-header">
        <div class="br-header-left">
            <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href=""><i class="icon ion-navicon-round"></i></a></div>
            <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>
        </div><!-- br-header-left -->
        <div class="br-header-right">
            <nav class="nav">
            <div class="dropdown">
                <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
                <span class="logged-name hidden-md-down">{{ Auth::user()->name }}</span>
                <img src="{{ asset('img/avatar.png') }}" class="wd-32 rounded-circle" alt="">
                <span class="square-10 bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-250">
                <hr>
                <hr>
                <ul class="list-unstyled user-profile-nav">
                    <li><a href="{{route('profile.edit')}}"><i class="icon ion-ios-person"></i> Editar Perfil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{route('logout')}}" onclick="event.preventDefault();
                            this.closest('form').submit();"><i class="icon ion-power"></i> {{ __('Cerrar Session') }}</a>
                        </form>                    
                    </li>

                </ul>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
            </nav>
        </div><!-- br-header-right -->
        </div><!-- br-header -->
        <!-- ########## END: HEAD PANEL ########## -->