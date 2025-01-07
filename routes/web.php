<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ProveedorController;
use App\Http\Controllers\admin\CategoriumController;
use App\Http\Controllers\admin\SubcategoriumController;
use App\Http\Controllers\admin\Materia_primaController;
use App\Http\Controllers\admin\ProduccionController;
use App\Http\Controllers\admin\CompraController;
use App\Http\Controllers\admin\DespachoController;
use App\Http\Controllers\admin\ProcesoController;
use App\Http\Controllers\admin\MaquinaController;
use App\Models\Proceso;

use App\Http\Controllers\admin\PreSalidaMolinoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('admin/users', [UserController::class, 'store'])->name('users.store');
    Route::get('admin/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.delete');
    Route::get('users/{user}/deleted', [UserController::class, 'reingresar'])->name('users.reingresar');


     Route::post('admin/roles', [RoleController::class, 'store'])->name('roles.store');
     Route::get('admin/roles', [RoleController::class, 'index'])->name('roles.index');
     Route::get('admin/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
     Route::get('admin/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');

     Route::resource('admin/proveedores', ProveedorController::class);
     Route::delete('admin/proveedores/{proveedores}', [ProveedorController::class, 'destroy'])->name('proveedores.delete');
     Route::get('admin/proveedores/{proveedores}/deleted', [ProveedorController::class, 'reingresar'])->name('proveedores.reingresar');



     Route::put('admin/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
     Route::delete('admin/roles/{role}', [RoleController::class, 'destroy'])->name('roles.delete');
     Route::get('admin/roles/{role}/deleted', [RoleController::class, 'reingresar'])->name('roles.reingresar');

     Route::resource('admin/categorias', CategoriumController::class);
     Route::delete('admin/categorias/{categorias}', [CategoriumController::class, 'destroy'])->name('cateogria.delete');
     Route::get('admin/categorias/{categorias}/deleted', [CategoriumController::class, 'reingresar'])->name('categoria.reingresar');

     Route::resource('admin/subcategorias', SubcategoriumController::class);
     Route::delete('admin/subcategorias/{subcategorias}', [SubcategoriumController::class, 'destroy'])->name('subcategoria.delete');
     Route::get('admin/subcategorias/{subcategorias}/deleted', [SubcategoriumController::class, 'reingresar'])->name('subcategoria.reingresar');

     Route::resource('admin/materia_prima', Materia_primaController::class);
     Route::delete('admin/materia_prima/{materia_prima}', [Materia_primaController::class, 'destroy'])->name('materia_prima.delete');
     Route::get('admin/materia_prima/{materia_prima}/deleted', [Materia_primaController::class, 'reingresar'])->name('materia_prima.reingresar');
     Route::get('get-subcategorias', [Materia_primaController::class, 'getSubcategorias'])->name('getSubcategorias');

     Route::get('get-states', [CompraController::class, 'getStates'])->name('getStates');

    Route::get('admin/compra/{compra}/generateInvoice)', [CompraController::class, 'generateInvoice'])->name('compra.generateInvoice');
    Route::get('admin/compra/deleted', [CompraController::class, 'eliminados'])->name('compra.index2');
    Route::resource('admin/compra', CompraController::class);
    Route::get('admin/compra/{compra}/deleted', [CompraController::class, 'reingresar'])->name('compra.reingresar');


    Route::get('admin/despacho/{despacho}/generateInvoice)', [DespachoController::class, 'generateInvoice'])->name('despacho.generateInvoice');
    Route::get('admin/despacho/deleted', [DespachoController::class, 'eliminados'])->name('despacho.index2');
    Route::resource('admin/despacho', DespachoController::class);
    Route::get('admin/despacho/{despacho}/deleted', [DespachoController::class, 'reingresar'])->name('despacho.reingresar');
    Route::get('admin/despachoproceso', [DespachoController::class, 'creates'])->name('despacho.creates');

    Route::get('admin/proceso/deleted', [ProcesoController::class, 'eliminados'])->name('proceso.index2');
    Route::resource('admin/proceso', ProcesoController::class);
    Route::get('admin/proceso/{proceso}/deleted', [ProcesoController::class, 'reingresar'])->name('proceso.reingresar');
    Route::get('get-detalles-despacho', [ProcesoController::class, 'getDetalleDespacho'])->name('getDetalleDespacho');

    Route::get('admin/proceso/{proceso}/entrega)', [ProduccionController::class, 'creates'])->name('proceso.produccion');


    Route::get('admin/produccion/{produccion}/generateInvoice)', [ProduccionController::class, 'generateInvoice'])->name('produccion.generateInvoice');
    Route::get('admin/produccion/deleted', [ProduccionController::class, 'eliminados'])->name('produccion.index2');
    Route::resource('admin/produccion', ProduccionController::class);
    Route::get('admin/produccion/{produccion}/deleted', [ProduccionController::class, 'reingresar'])->name('produccion.reingresar');

    // mine
    Route::get('admin/pre_salida_molino/{id_proceso}', [PreSalidaMolinoController::class, 'index'])->name('preSalidaMolino');
    Route::get('admin/maquina', [MaquinaController::class, 'index'])->name('maquina.index');
});

// api
Route::get('admin/get_salidas_molino/{fecha}', [ProduccionController::class, 'get_salidas_by_date']);

require __DIR__.'/auth.php';






