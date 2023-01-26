<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Portfolio Details - Sailor Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('plantillas/Sailor/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('plantillas/Sailor/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('plantillas/Sailor/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('plantillas/Sailor/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('plantillas/Sailor/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('plantillas/Sailor/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('plantillas/Sailor/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('plantillas/Sailor/assets/css/style.css') }}" rel="stylesheet">


  <!-- Fontawesome -->
  <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet">


</head>

<body>

  <main id="main">

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">
                @foreach ($imagenes as $item)
                    <div class="swiper-slide">
                        <img src="{{asset('img/imageneventos/'.$item->archivo_img)}}" alt="" width="200px">
                    </div>    
                @endforeach
              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>{{$galeria->titulo}}</h3>
            </div>
            <div class="portfolio-description">
              <p>
                {{$galeria->descripcion}}
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('plantillas/Sailor/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('plantillas/Sailor/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{ asset('plantillas/Sailor/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('plantillas/Sailor/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{ asset('plantillas/Sailor/assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{ asset('plantillas/Sailor/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('plantillas/Sailor/assets/js/main.js')}}"></script>


</body>

</html>