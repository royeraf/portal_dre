
<!-- LOADER -->
<div id="preloader">
  <span class="spinner"></span>
  <div class="loader-section section-left"></div>
  <div class="loader-section section-right"></div>
</div>
<!-- END LOADER --> 

<div class="modal fade lr_popup" id="Login" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            <form method="POST" action="{{ route('login') }}">
                @csrf
              <div class="row no-gutters">
                <div class="col-lg-5">
                    <div class="h-100 background_bg radius_ltlb_5" data-img-src="assets/images/login_img.jpg"></div>
                  </div>
                <div class="col-lg-7">	
                    <div class="padding_eight_all">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="login-tab1" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Login</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="login" role="tabpanel">
                                <div class="heading_s1 mb-3">
                                    <h4>Login</h4>
                                </div>
                                <form method="post" class="login form_style2">
                                    <div class="form-group">
                                        <input type="text" required="" class="form-control" name="email" placeholder="Email" autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" required="" type="password" name="password" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default btn-block rounded-0" name="login">Log in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </form>
        </div>
      </div>
  </div>
</div>

<!-- START HEADER -->
<header class="header_wrap dark_skin">
<div class="top-header bg_blue_dark2 light_skin">
      <div class="container">
          <div class="row align-items-center">
              <div class="col-md-6">
                  <ul class="contact_detail list_none text-center text-md-left">
                      <li><a href="#"><i class="ti-mobile"></i>+51 948998291</a></li>
                      <li><a href="#"><i class="ti-email"></i>rcoronel@drehco.gob.pe</a></li>
                  </ul>
              </div>
              <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-md-end justify-content-center mt-2 mt-md-0">
                    <ul class="list_none social_icons social_white text-center text-md-right">
                          <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                          <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                          <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                          <li><a href="#"><i class="ion-social-youtube-outline"></i></a></li>
                          <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                      </ul>
                      <ul class="list_none header_list border_list ml-1">
                          <li><a href="{{ route('intranet') }}" data-toggle="{{ Auth::user()==null ? 'modal' : '' }}" data-target="#Login">Intranet</a></li>
                          <li><a href="#" class="btn btn-default btn-sm rounded-0">Aula Virutal</a></li>
                          <li><a target="_blank" href="https://www.transparencia.gob.pe/enlaces/pte_transparencia_enlaces.aspx?id_entidad=14163#.Y9SgbXbMLrd" class=""><img src="{{asset('img/portal.png')}}" height="40px" alt=""></a></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="container">
      <nav class="navbar navbar-expand-lg"> 
          <a class="navbar-brand" href="/">
              <img class="logo_dark" src="{{ asset('img/logo.png') }}" alt="logo" />
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="ion-android-menu"></span> </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
              
            <ul class="navbar-nav">
                <li>
                    <a class="nav-link active" href="<?= URL::to('/') ?>">HOME</a>
                </li>
                <?php foreach($menus as $row){ ?>
                    <?php if($row->link_menu=='#'){ ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">{{$row->nom_menu}}</a>
                            <div class="dropdown-menu">
                                <ul> 
                                    <?php foreach($submenus as $submenu){
                                        if($submenu->categoriamenu==$row->id){ ?>
                                    <li><a class="dropdown-item nav-link nav_item" href="{{$submenu->link_menu}}">{{$submenu->nom_menu}}</a></li> 
                                    <?php } } ?>
                                </ul>
                            </div>
                        </li>
                <?php }else{ ?>
                    <li>
                        <a class="nav-link" href="{{$row->link_menu}}">{{$row->nom_menu}}</a>
                    </li>
                <?php } } ?>


              </ul>
          </div>
          <ul class="navbar-nav attr-nav align-items-center">
              <li><a href="javascript:void(0);" class="nav-link search_trigger"><i class="ion-ios-search-strong"></i></a>
                  <div class="search-overlay">
                      <div class="search_wrap">
                          <form>
                              <input type="text" placeholder="Search" class="form-control" id="search_input">
                              <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                          </form>
                      </div>
                  </div>
              </li>
          </ul>
      </nav>
  </div>
</header>
<!-- END HEADER --> 
