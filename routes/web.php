<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PopupController;
use App\Http\Controllers\DirectorioController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\ImagenEventoController;
use App\Http\Controllers\ComunicadoController;
use App\Http\Controllers\MainrightController;
use App\Http\Controllers\DocumentogestionController;
use App\Http\Controllers\InfraestructuraController;
use App\Http\Controllers\PaginaWebController;
use App\Http\Controllers\VideoEmbevidoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiagieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', HomeController::class)->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/noticia/{noticia}', [HomeController::class, 'noticia'])->name('noticia');
Route::get('/directorioweb', [HomeController::class, 'directorio'])->name('directorioweb');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');
Route::get('/mision', [HomeController::class, 'mision'])->name('mision');
Route::get('/vision', [HomeController::class, 'vision'])->name('vision');
Route::get('/portafoliodet/{galeria}', [HomeController::class, 'portafoliodet'])->name('portafoliodet');
Route::get('/galeria/{galeria}/json', [HomeController::class, 'galeriaJson'])->name('galeria.json');
Route::get('/allnoticias', [HomeController::class, 'allnoticias'])->name('allnoticias');
Route::get('/galeriaimagenes', [HomeController::class, 'galeria'])->name('galerias');
Route::get('/convocatoriaweb', [HomeController::class, 'convocatoriaweb'])->name('convocatoriaweb');


Route::get('/verconvocatoria/{convocatoria}', [HomeController::class, 'verconvocatoria'])->name('verconvocatoria');
Route::get('/comunicadosall', [HomeController::class, 'comunicadosall'])->name('comunicadosall');
Route::get('/documentosdegestionweb', [HomeController::class, 'documentosdegestionweb'])->name('documentosdegestionweb');
Route::get('/infraestructuraall', [HomeController::class, 'infraestructura'])->name('infraestructuraall');
Route::get('/resoluciones', [HomeController::class, 'resoluciones'])->name('resoluciones');
Route::get('/paginas/{pagina}', [HomeController::class, 'showpaginaweb'])->name('pagina.showpaginaweb');

Route::get('menus/paginaweb/{pagina}', [MenuController::class, 'showpaginaweb'])->name('menus.showpaginaweb');

Route::controller(MenuController::class)->middleware(['auth', 'verified'])->group(function(){
    Route::get('menus', 'index')->name('menu');
    Route::get('menus/edit/{menu}', 'edit')->name('menu.edit');
    Route::get('menus/create', 'create')->name('formregistro');
    Route::post('menus', 'store')->name('menus.store');
    Route::get('menus/paginaweb', 'paginaweb')->name('menus.paginaweb');
    Route::put('menus/update/{menu}', 'update')->name('menus.update');
    Route::get('menus/{menu}', 'destroy')->name('menus.destroy');
    Route::get('menus/submenus/{menu}', 'submenus')->name('menu.submenus');
    Route::post('menus/submenusstore', 'submenusstore')->name('submenus.store');
    Route::delete('menus/submenu/{submenu}', 'submenudestroy')->name('submenu.destroy');
    Route::post('menus/paginawebstore', 'paginawebstore')->name('pagina.paginawebstore');
});
Route::controller(ArchivoController::class)->group(function(){
    Route::get('archivos/inicio', 'index')->middleware(['auth', 'verified'])->name('archivo');
    Route::get('archivos/{archivo}', 'destroy')->middleware(['auth', 'verified'])->name('archivos.destroy');
    Route::get('archivos/edit/{archivo}', 'edit')->middleware(['auth', 'verified'])->name('archivos.edit');
    Route::post('archivos/store', 'store')->middleware(['auth', 'verified'])->name('archivos.store');
    Route::put('archivos/update/{archivo}', 'update')->middleware(['auth', 'verified'])->name('archivos.update');
});
Route::controller(SliderController::class)->middleware(['auth', 'verified'])->group(function(){
    Route::get('slider/create', 'create')->name('slide.create');
    Route::post('slider/store', 'store')->name('slide.store');
    Route::get('slider/edit/{slider}', 'edit')->name('slide.edit');
    Route::put('slider/update/{slider}', 'update')->name('slide.update');
    Route::get('slider/{slider}', 'destroy')->name('slide.destroy');
    Route::get('slider/{menu}', 'show');
});
Route::controller(NoticiaController::class)->group(function(){
    Route::get('noticias', 'index')->middleware(['auth', 'verified'])->name('noticias');
    Route::get('noticias/create', 'create')->middleware(['auth', 'verified'])->name('noticias.create');
    Route::post('noticias/store', 'store')->middleware(['auth', 'verified'])->name('noticias.store');
    Route::get('noticias/{noticia}', 'destroy')->middleware(['auth', 'verified'])->name('noticias.destroy');
    Route::get('noticias/edit/{noticia}', 'edit')->middleware(['auth', 'verified'])->name('noticias.edit');
    Route::put('noticias/update/{noticia}', 'update')->middleware(['auth', 'verified'])->name('noticias.update');
    Route::get('noticias/show/{noticia}', 'show')->middleware(['auth', 'verified'])->name('noticias.show');
});
Route::controller(PopupController::class)->group(function(){
    Route::get('popup', 'index')->middleware(['auth', 'verified'])->name('popup');
    Route::get('popup/create', 'create')->middleware(['auth', 'verified'])->name('popup.create');
    Route::post('popup/store', 'store')->middleware(['auth', 'verified'])->name('popup.store');
    Route::post('popup/imagen/store/{popup}', 'store2')->middleware(['auth', 'verified'])->name('popup.imagen.store');
    Route::get('popup/{popup}', 'destroy')->middleware(['auth', 'verified'])->name('popup.destroy');
    Route::get('popup/imagen/{imagenpopup}', 'destroy2')->middleware(['auth', 'verified'])->name('popup.imagen.destroy');
    Route::get('popup/edit/{popup}', 'edit')->middleware(['auth', 'verified'])->name('popup.edit');
    Route::put('popup/update/{popup}', 'update')->middleware(['auth', 'verified'])->name('popup.update');
    Route::get('popup/show/{popup}', 'show')->middleware(['auth', 'verified'])->name('show');
});
Route::controller(ComunicadoController::class)->group(function(){
    Route::get('comunicado', 'index')->middleware(['auth', 'verified'])->name('comunicado');
    Route::get('comunicado/create', 'create')->middleware(['auth', 'verified'])->name('comunicado.create');
    Route::post('comunicado/store', 'store')->middleware(['auth', 'verified'])->name('comunicado.store');
    Route::get('comunicado/{comunicado}', 'destroy')->middleware(['auth', 'verified'])->name('comunicado.destroy');
    Route::get('comunicado/edit/{comunicado}', 'edit')->middleware(['auth', 'verified'])->name('comunicado.edit');
    Route::put('comunicado/update/{comunicado}', 'update')->middleware(['auth', 'verified'])->name('comunicado.update');
    Route::get('comunicado/show/{comunicado}', 'show')->middleware(['auth', 'verified'])->name('comunicado.show');
});
Route::controller(DirectorioController::class)->group(function(){
    Route::get('directorio', 'index')->middleware(['auth', 'verified'])->name('directorio');
    Route::get('directorio/create', 'create')->middleware(['auth', 'verified'])->name('directorio.create');
    Route::post('directorio/store', 'store')->middleware(['auth', 'verified'])->name('directorio.store');
    Route::get('directorio/{directorio}', 'destroy')->middleware(['auth', 'verified'])->name('directorio.destroy');
    Route::get('directorio/edit/{directorio}', 'edit')->middleware(['auth', 'verified'])->name('directorio.edit');
    Route::put('directorio/update/{directorio}', 'update')->middleware(['auth', 'verified'])->name('directorio.update');
});
Route::controller(ConvocatoriaController::class)->group(function(){
    Route::get('convocatoria', 'index')->middleware(['auth', 'verified'])->name('convocatoria');
    Route::get('convocatoria/create', 'create')->middleware(['auth', 'verified'])->name('convocatoria.create');
    Route::post('convocatoria/store', 'store')->middleware(['auth', 'verified'])->name('convocatoria.store');
    Route::get('convocatoria/{convocatoria}', 'destroy')->middleware(['auth', 'verified'])->name('convocatoria.destroy');
    Route::get('convocatoria/edit/{convocatoria}', 'edit')->middleware(['auth', 'verified'])->name('convocatoria.edit');
    Route::put('convocatoria/update/{convocatoria}', 'update')->middleware(['auth', 'verified'])->name('convocatoria.update');
    Route::get('convocatoria/show/{convocatoria}', 'show')->middleware(['auth', 'verified'])->name('convocatoria.show');
    Route::get('convocatoria/archivocreate/{convocatoria}', 'archivo_convocatoriacreate')->middleware(['auth', 'verified'])->name('archivo.convocatoria.create');
    Route::get('convocatoria/archivo/{archivoconvocatoria}', 'archivoconvocatoriadestroy')->middleware(['auth', 'verified'])->name('archivo.convocatoria.destroy');
    Route::get('convocatoria/editarchivo/{archivoconvocatoria}', 'archivoedit')->middleware(['auth', 'verified'])->name('archivo.convocatoria.edit');
    Route::post('convocatoria/archivo/store/{convocatoria}', 'archivocstore')->middleware(['auth', 'verified'])->name('archivo.convocatoria.store');
});
Route::controller(ImagenEventoController::class)->group(function(){
    Route::get('galeria', 'index')->middleware(['auth', 'verified'])->name('galeria');
    Route::get('galeria/create', 'create')->middleware(['auth', 'verified'])->name('galeria.create');
    Route::post('galeria/store', 'store')->middleware(['auth', 'verified'])->name('galeria.store');
    Route::get('galeria/{galeria}', 'destroy')->middleware(['auth', 'verified'])->name('galeria.destroy');
    Route::get('galeria/imagen/{imagenevento}', 'destroyarchivo')->middleware(['auth', 'verified'])->name('galeria.destroyarchivo');
    Route::get('galeria/edit/{galeria}', 'edit')->middleware(['auth', 'verified'])->name('galeria.edit');
    Route::put('galeria/update/{galeria}', 'update')->middleware(['auth', 'verified'])->name('galeria.update');
    Route::get('galeria/show/{galeria}', 'show')->middleware(['auth', 'verified'])->name('galeria.show');
    Route::get('galeria/agregarimagen/{galeria}', 'agregarimagen')->middleware(['auth', 'verified'])->name('galeria.agregarimagen');
    Route::post('galeria/storeimagen', 'storeimagen')->middleware(['auth', 'verified'])->name('galeria.storeimagen');
});
Route::controller(MainrightController::class)->group(function(){
    Route::get('mainright', 'index')->middleware(['auth', 'verified'])->name('mainright');
    Route::post('mainright/store', 'store')->middleware(['auth', 'verified'])->name('mainright.store');
    Route::get('mainright/{mainright}', 'destroy')->middleware(['auth', 'verified'])->name('mainright.destroy');
});
Route::controller(DocumentogestionController::class)->group(function(){
    Route::get('Documentogestion', 'index')->middleware(['auth', 'verified'])->name('Documentogestion');
    Route::post('Documentogestion/store', 'store')->middleware(['auth', 'verified'])->name('Documentogestion.store');
    Route::get('Documentogestion/{Documentogestion}', 'destroy')->middleware(['auth', 'verified'])->name('Documentogestion.destroy');
    Route::get('Documentogestion/archivo/{archivoDocumentogestion}', 'destroy2')->middleware(['auth', 'verified'])->name('archivoDocumentogestion.destroy');
    Route::get('Documentogestion/show/{Documentogestion}', 'show')->middleware(['auth', 'verified'])->name('Documentogestion.show');
    Route::post('archivoDocumentogestion/store/{Documentogestion}', 'store2')->middleware(['auth', 'verified'])->name('archivoDocumentogestion.store');
});
Route::controller(InfraestructuraController::class)->group(function(){
    Route::get('Infraestructura', 'index')->middleware(['auth', 'verified'])->name('Infraestructura');
    Route::post('Infraestructura/store', 'store')->middleware(['auth', 'verified'])->name('infraestructura.store');
    Route::get('Infraestructura/{infraestructura}', 'destroy')->middleware(['auth', 'verified'])->name('infraestructura.destroy');
});
Route::controller(PaginaWebController::class)->group(function(){
    Route::get('PaginaWeb', 'index')->middleware(['auth', 'verified'])->name('paginawebadmin');
    Route::post('PaginaWeb/store', 'store')->middleware(['auth', 'verified'])->name('paginaweb.store');
    Route::put('paginas/update/{pagina}', 'update')->middleware(['auth', 'verified'])->name('paginaweb.update');
    Route::get('paginas/destroy/{pagina}', 'destroy')->middleware(['auth', 'verified'])->name('pagina.destroy');
    Route::get('paginas/edit/{pagina}', 'edit')->middleware(['auth', 'verified'])->name('pagina.edit');
});
Route::controller(VideoEmbevidoController::class)->group(function(){
    Route::get('videoembevido', 'create')->middleware(['auth', 'verified'])->name('videoembevido');
    Route::post('videoembevido/store', 'store')->middleware(['auth', 'verified'])->name('videoembevido.store');
    Route::put('videoembevido/update/{videoembevido}', 'update')->middleware(['auth', 'verified'])->name('videoembevido.update');
    Route::get('videoembevido/destroy/{videoembevido}', 'destroy')->middleware(['auth', 'verified'])->name('videoembevido.destroy');
    Route::get('videoembevido/edit/{videoembevido}', 'edit')->middleware(['auth', 'verified'])->name('videoembevido.edit');
});

//NUEVA RUTA PARA CONVIVENCIA SIN VIOLENCIA
use App\Http\Controllers\ConvivenciaSinViolenciaController;

Route::get('convivenciasinviolencia', [ConvivenciaSinViolenciaController::class, 'index'])->name('convivenciasinviolencia');

Route::get('prueba', [MenuController::class, 'prueba'])->name('prueba');
Route::get('/intranet', function () {
    \Log::info('[INTRANET-HIT]', [
        'authenticated' => auth()->check(),
        'user_id'       => auth()->id(),
        'session_id'    => session()->getId(),
    ]);
    return response()->view('dashboard')->header('Cache-Control', 'no-store, no-cache, must-revalidate, private');
})->middleware(['auth'])->name('intranet');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Nuevo módulo de direcciones y áreas
use App\Http\Controllers\DireccionController;

// Rutas públicas para direcciones
Route::get('/direcciones/{direccion}', [DireccionController::class, 'show'])->name('direcciones.show');
Route::get('/direcciones/{direccion}/{area}', [DireccionController::class, 'show'])->name('direcciones.area');
Route::get('/menus/paginaweb/{idpagina}', [DireccionController::class, 'showPorPagina']);

// Rutas administrativas (con middleware auth)
Route::middleware(['auth', 'verified'])->group(function () {
    // Direcciones - CRUD básico
    Route::get('admin/direcciones', [DireccionController::class, 'admin'])->name('admin.direcciones');
    Route::get('admin/direcciones/create', [DireccionController::class, 'create'])->name('admin.direcciones.create');
    Route::post('admin/direcciones', [DireccionController::class, 'store'])->name('admin.direcciones.store');
    Route::get('admin/direcciones/{direccion}/edit', [DireccionController::class, 'edit'])->name('admin.direcciones.edit');
    Route::put('admin/direcciones/{direccion}', [DireccionController::class, 'update'])->name('admin.direcciones.update');
    Route::get('admin/direcciones/{direccion}/destroy', [DireccionController::class, 'destroy'])->name('admin.direcciones.destroy');
    
    // Direcciones - Gestión de contenido web
    Route::get('admin/direcciones/{direccion}/contenido', [DireccionController::class, 'adminContenido'])->name('admin.direcciones.contenido');
    Route::put('admin/direcciones/{direccion}/contenido', [DireccionController::class, 'updateContenido'])->name('admin.direcciones.contenido.update');
    
    // Áreas de direcciones
    Route::get('admin/direcciones/{direccion}/areas', [DireccionController::class, 'adminAreas'])->name('admin.direcciones.areas');
    Route::post('admin/direcciones/{direccion}/areas', [DireccionController::class, 'storeArea'])->name('admin.areas.store');
    Route::get('admin/areas-menu/{area}/edit', [DireccionController::class, 'editArea'])->name('admin.areas-menu.edit');
    Route::put('admin/areas-menu/{area}', [DireccionController::class, 'updateArea'])->name('admin.areas-menu.update');
    Route::delete('admin/areas-menu/{area}', [DireccionController::class, 'destroyArea'])->name('admin.areas-menu.destroy');

    // Eventos de áreas
    Route::get('/admin/areas/{area}/eventos', [DireccionController::class, 'eventosArea'])->name('admin.areas.eventos');
    Route::post('/admin/areas/{area}/eventos', [DireccionController::class, 'storeEvento'])->name('admin.eventos.store');

    Route::get('/admin/eventos/{evento}/edit', [DireccionController::class, 'editEvento'])->name('admin.eventos.edit');
    Route::put('/admin/eventos/{evento}', [DireccionController::class, 'updateEvento'])->name('admin.eventos.update');
    Route::delete('/admin/eventos/{evento}', [DireccionController::class, 'destroyEvento'])->name('admin.eventos.destroy');
    Route::get('/admin/eventos/{evento}/archivos', [DireccionController::class, 'getEventoArchivos'])->name('admin.eventos.archivos');
    Route::delete('/admin/eventos/{evento}/archivo/{numeroArchivo}', [DireccionController::class, 'eliminarArchivoEvento'])->name('admin.eventos.eliminar-archivo');
});

    // Rutas para EPR
    Route::get('/epr', [App\Http\Controllers\EPRController::class, 'index'])->name('epr.index');
    Route::get('/epr/pdf/{id}', [App\Http\Controllers\EPRController::class, 'showPdf'])->name('epr.pdf');
    Route::get('/epr/serve/{id}', [App\Http\Controllers\EPRController::class, 'servePdf'])->name('epr.serve');
    Route::get('/epr/download/{id}', [App\Http\Controllers\EPRController::class, 'downloadPdf'])->name('epr.download');

    // Rutas públicas SIAGIE
    Route::get('siagie', [SiagieController::class, 'index'])->name('siagie.index');
    Route::get('siagie/{slug}', [SiagieController::class, 'showReport'])->name('siagie.show');

    // Rutas admin SIAGIE (protegidas)
    Route::prefix('intranet/siagie')->name('admin.siagie.')->middleware(['auth'])->group(function () {
        // ⭐ RUTAS ESTÁTICAS PRIMERO
        Route::get('reports', [SiagieController::class, 'reportsIndex'])->name('reports.index');
        Route::get('reports/create', [SiagieController::class, 'create'])->name('reports.create');
        
        // ⭐ API AJAX (antes de las rutas con parámetros dinámicos)
        Route::get('api/reports/{slug}/details', [SiagieController::class, 'getReportDetails'])->name('api.report-details');
        
        // ⭐ RUTAS CON PARÁMETROS AL FINAL
        Route::get('reports/{report}/edit', [SiagieController::class, 'editReport'])->name('reports.edit');
        Route::post('reports', [SiagieController::class, 'storeReport'])->name('reports.store');
        Route::put('reports/{report}', [SiagieController::class, 'updateReport'])->name('reports.update');
        Route::post('reports/{report}/toggle-publish', [SiagieController::class, 'togglePublish'])->name('reports.toggle-publish');
        Route::delete('reports/{report}', [SiagieController::class, 'destroyReport'])->name('reports.destroy');
    });
// Debug temporal — ELIMINAR después del diagnóstico
Route::get('/test-cookie', function () {
    return response()->json(['ok' => true])
        ->cookie('test_cookie', 'hello123', 5, '/', null, false, false, false, 'lax')
        ->header('Cache-Control', 'no-store, no-cache');
});

Route::get('/debug-session', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user_id'       => auth()->id(),
        'session_id'    => session()->getId(),
        'cookie_header' => request()->header('Cookie'),
    ])->header('Cache-Control', 'no-store, no-cache, must-revalidate');
});

// CSRF token fresco para el modal de login (no cacheable)
Route::get('/csrf-token', function () {
    return response()->json(['token' => csrf_token()])
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
})->middleware('web');

// OPcache reset — protegido con hash del APP_KEY, solo para deploy
Route::get('/_flush/{token}', function (string $token) {
    if (!hash_equals(hash('sha256', config('app.key')), $token)) abort(404);
    if (function_exists('opcache_reset')) opcache_reset();
    return 'OK';
});

require __DIR__.'/auth.php';
