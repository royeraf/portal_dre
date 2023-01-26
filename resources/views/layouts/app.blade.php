<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>UGEL - HUACAYBAMBA</title>
        <link href="{{ asset('plantillas/bracketplus/app/lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="{{asset('plantillas/bracketplus/app/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
        <link href="{{asset('plantillas/bracketplus/app/lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">
        <link href="{{asset('plantillas/bracketplus/app/lib/select2/css/select2.min.css')}}" rel="stylesheet">
        <!-- Bracket CSS -->
        <link rel="stylesheet" href="{{asset('plantillas/bracketplus/app/css/bracket.css')}}">
        <!-- summernote -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    </head>
    <body>
        @include('layouts.navigation')
        <div class="br-mainpanel">      
            <div class="br-pagetitle">
              @if (isset($header))
                {{ $header }}
              @endif
            </div>
            <!-- Page Content -->
            <div class="br-pagebody">
                <div class="br-section-wrapper">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <script src="{{asset('plantillas/bracketplus/app/lib/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/lib/jquery-ui/ui/widgets/datepicker.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/lib/moment/min/moment.min.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/lib/peity/jquery.peity.min.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/lib/highlightjs/highlight.pack.min.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/lib/select2/js/select2.min.js')}}"></script>
        <script src="{{asset('plantillas/bracketplus/app/js/bracket.js')}}"></script>
        <script src="{{asset('js/script.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
        <script>
            $(function(){
                $("#mysummernote").summernote({
                    height:200
                });
              'use strict'
              $('.form-layout .form-control').on('focusin', function(){
                $(this).closest('.form-group').addClass('form-group-active');
              });
              $('.form-layout .form-control').on('focusout', function(){
                $(this).closest('.form-group').removeClass('form-group-active');
              });
              // Select2
              $('#select2-a, #select2-b').select2({
                minimumResultsForSearch: Infinity
              });
        
              $('#select2-a').on('select2:opening', function (e) {
                $(this).closest('.form-group').addClass('form-group-active');
              });
        
              $('#select2-a').on('select2:closing', function (e) {
                $(this).closest('.form-group').removeClass('form-group-active');
              });
            // Toggles
            $('#br-toggle1').on('click', function(e){
                e.preventDefault();
                if($('#link_menu').val()=='#'){
                    //$('.select2').attr('disabled', false);
                    $('#contenidopagina').removeClass('d-none'); 
                    $('#link_menu').val(''); 
                    $('#nom_pagina').val($('input[name=nom_menu]').val());
                }else{
                    //$('.select2').attr('disabled', true);
                    $('#link_menu').val('#'); 
                    $('#contenidopagina').addClass('d-none'); 
                    $('#nom_pagina').val('');
                }
                $(this).toggleClass('on');
            });
            $('#br-toggle2').on('click', function(e){
                e.preventDefault();
                if($('input[name=activo_menu]').val()=='1'){
                    $('input[name=activo_menu]').val('0'); 
                }else{
                    $('input[name=activo_menu]').val('1'); 
                }
                $(this).toggleClass('on');
            })  
            $('#br-toggle3').on('click', function(e){
                e.preventDefault();
                if($('input[name=estado]').val()=='1'){
                    $('input[name=estado]').val('0'); 
                }else{
                    $('input[name=estado]').val('1'); 
                }
                $(this).toggleClass('on');
            })         
            $('#br-toggle4').on('click', function(e){
                e.preventDefault();
                if($('input[name=es_activo]').val()=='1'){
                    $('input[name=es_activo]').val('0'); 
                }else{
                    $('input[name=es_activo]').val('1'); 
                }
                $(this).toggleClass('on');
            })                
            });
            
          </script>
        <script>
            $(document).ready(function(){
                // input plugin
                bsCustomFileInput.init();
                // get file and preview image
                $("#inputGroupFile").on('change',function(){
                    var input = $(this)[0];
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#preview').attr('src', e.target.result).fadeIn('slow');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                })
                $("#inputGroupFile1").on('change',function(){
                var input = $(this)[0];
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview1').attr('src', e.target.result).fadeIn('slow');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                })
                $("#inputGroupFile2").on('change',function(){
                var input = $(this)[0];
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview2').attr('src', e.target.result).fadeIn('slow');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                })
                $("#inputGroupFile3").on('change',function(){
                var input = $(this)[0];
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview3').attr('src', e.target.result).fadeIn('slow');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
                })          
            })
        </script>

      
    </body>
</html>
