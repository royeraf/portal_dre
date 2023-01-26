<x-app-layout>
    <x-slot name="header">
        <h2><i class="far fa-clone"></i> Noticia
    </x-slot>
    <h1>{{ $noticia->titulo }}</h1>
    <?= $noticia->contenido ?>
    <?php 
    $image_path1 = public_path('img/noticias/').$noticia->img1; 
    $image_path2 = public_path('img/noticias/').$noticia->img2;
    $image_path3 = public_path('img/noticias/').$noticia->img3;
    ?>
    <div class="row">
        <?php if (file_exists($image_path1)){  ?>
        <div class="col">
            <img src="{{asset('img/noticias/'.$noticia->img1)}}" class="img-fluid img-thumbnail" />
        </div>
        <?php } ?>
        <?php if (file_exists($image_path2)){  ?>
        <div class="col">
            <img src="{{asset('img/noticias/'.$noticia->img2)}}" class="img-fluid img-thumbnail" />
        </div>
        <?php } ?>
        <?php if (file_exists($image_path3)){  ?>    
        <div class="col">
            <img src="{{asset('img/noticias/'.$noticia->img3)}}" class="img-fluid img-thumbnail" />
        </div>
        <?php } ?>
    </div>
</x-app-layout>

