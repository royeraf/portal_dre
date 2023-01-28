<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="Anil z" name="author">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Eduglobal - College & University HTML Template">
<meta name="keywords" content="academy, course, education, elearning, learning, education html template, university template, college template, school template, online education template, tution center template">

<!-- SITE TITLE -->
<title>{{ config('app.name', 'DRE - HUANUCO') }}</title>
<!-- Favicon Icon -->
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/ico.png') }}">
<!-- Animation CSS -->
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/css/animate.css') }}">	
<!-- Latest Bootstrap min CSS -->
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/bootstrap/css/bootstrap.min.css') }}">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
<!-- Icon Font CSS -->
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/css/ionicons.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/css/themify-icons.css') }}">
<!-- FontAwesome CSS -->
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/css/all.min.css') }}">
<!--- owl carousel CSS-->
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/owlcarousel/css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/owlcarousel/css/owl.theme.css') }}">
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/owlcarousel/css/owl.theme.default.min.css') }}">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/css/magnific-popup.css') }}">
<!-- Style CSS -->
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('plantillas/eduglobal/assets/css/responsive.css') }}">
<link rel="stylesheet" id="layoutstyle" href="{{ asset('plantillas/eduglobal/assets/color/theme.css') }}">

</head>

<body>
@include('principal.header')
@yield('content')


@include('principal.footer')



<!-- Latest jQuery --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/jquery-1.12.4.min.js') }}"></script> 
<!-- jquery-ui --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/jquery-ui.js') }}"></script>
<!-- popper min js --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/popper.min.js') }}"></script>
<!-- Latest compiled and minified Bootstrap --> 
<script src="{{ asset('plantillas/eduglobal/assets/bootstrap/js/bootstrap.min.js') }}"></script> 
<!-- owl-carousel min js  --> 
<script src="{{ asset('plantillas/eduglobal/assets/owlcarousel/js/owl.carousel.min.js') }}"></script> 
<!-- magnific-popup min js  --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/magnific-popup.min.js') }}"></script> 
<!-- waypoints min js  --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/waypoints.min.js') }}"></script> 
<!-- parallax js  --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/parallax.js') }}"></script> 
<!-- countdown js  --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/jquery.countdown.min.js') }}"></script> 
<!-- jquery.counterup.min js --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/jquery.counterup.min.js') }}"></script>
<!-- imagesloaded js --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<!-- isotope min js --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/isotope.min.js') }}"></script>
<!-- jquery.parallax-scroll js -->
<script src="{{ asset('plantillas/eduglobal/assets/js/jquery.parallax-scroll.js') }}"></script>
<!-- scripts js --> 
<script src="{{ asset('plantillas/eduglobal/assets/js/scripts.js') }}"></script>


<script>
    $(document).ready(function(){
      $('#modalpopup').modal('show');       
    })
  </script>
</script>

</body>
</html>



