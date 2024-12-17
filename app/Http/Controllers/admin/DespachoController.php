<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Despacho;
use App\Models\Detalle_despacho;
use App\Models\Materia_prima;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;


class DespachoController extends Controller
{


    public function index(Request $request)
    {
        $user = Auth::user();
        $roles = $user->roles->pluck('id')->toArray();
        $today = Carbon::now('America/La_Paz')->format('Y-m-d');

        if (in_array(1, $roles) || in_array(2, $roles)) {
            // Usuarios con rol ID 1 o 2 ven todos los despachos
            $despachos = Despacho::orderBy('id', 'desc')->get();
        } else {
            // Otros usuarios solo ven los despachos de hoy
            $despachos = Despacho::whereDate('fecha', $today)->get();
        }

        // Array para almacenar los nombres de los receptores
        $receptores = [];

        foreach ($despachos as $despacho) {
            // Obtener el nombre del receptor usando el ID guardado en 'receptor'
            $receptorId = $despacho->receptor;
            $receptor = User::where('id', $receptorId)->value('name');

            // Agregar el nombre del receptor al array
            $receptores[$despacho->id] = $receptor;
        }

        return view('admin.despacho.index', compact('despachos', 'receptores'));
    }




    public function create()
    {
        $fechaActual = Carbon::now();
        $dia = $fechaActual->format('d');
        $mes = strtoupper($fechaActual->format('M'));
        $anio = $fechaActual->format('Y');
        $ultimaEntrega = Despacho::whereDate('created_at', $fechaActual->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimaEntrega) {
            $ultimoCodigo = $ultimaEntrega->codigo;
            $partes = explode('-', $ultimoCodigo);
            $numeroEntrega = (int) $partes[1] + 1;
        } else {
            $numeroEntrega = 1;
        }

        $codigo = "MT-{$numeroEntrega}-{$dia}-{$mes}-{$anio}";
        $users = User::with('roles')->where('tipo', 1)->get(); // Cargar los usuarios con sus roles

        // Filtrar materias primas que pertenecen a categoría_id = 1
        $materia_primas = Materia_prima::/* whereHas('subcategoria', function ($query) {
            $query->where('categoria_id', 1);
        }) */
       where('subcategoria_id', 1)->get();

       $sabores = include(app_path(). '/dataCustom/sabores.php');
        return view('admin.despacho.create', compact('codigo', 'users', 'materia_primas', 'sabores'));
    }

    public function creates()
    {
        $fechaActual = Carbon::now();
        $dia = $fechaActual->format('d');
        $mes = strtoupper($fechaActual->format('M'));
        $anio = $fechaActual->format('Y');
        $ultimaEntrega = Despacho::whereDate('created_at', $fechaActual->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimaEntrega) {
            $ultimoCodigo = $ultimaEntrega->codigo;
            $partes = explode('-', $ultimoCodigo);
            $numeroEntrega = (int) $partes[1] + 1;
        } else {
            $numeroEntrega = 1;
        }

        $codigo = "MT-{$numeroEntrega}-{$dia}-{$mes}-{$anio}";
        $users = User::with('roles')->where('tipo', 2)->get(); // Cargar los usuarios con sus roles

        // Filtrar materias primas que pertenecen a categoría_id = 1
        $materia_primas = Materia_prima::whereHas('subcategoria', function ($query) {
            $query->where('categoria_id', 2);
        })->get();

        return view('admin.despacho.creates', compact('codigo', 'users', 'materia_primas'))->with('correcto', 'Subcategorium added!');
    }
    public function store(Request $request)
    {
        // dd($request->total);
        // Validar y convertir la fecha antes de la validación
        $request->validate([
            'codigo' => 'required|string|max:50',
            'sabor' => 'required|string|max:255',
            'fecha' => 'required|date_format:d-M-Y', // Asegura que la fecha tenga el formato correcto
            'receptor' => 'required|exists:users,id',
            'observacion' => 'nullable|string|max:255',
            'salida_esperada' => 'nullable|string|max:50',
            'carrito' => 'required|string',
        ]);

        // Convertir la fecha al formato de base de datos
        $fecha_formato_db = \Carbon\Carbon::createFromFormat('d-M-Y', $request->fecha)->format('Y-m-d');
        $user_id = Auth::id();

        // Obtener el usuario que es el receptor
        $receptor = User::findOrFail($request->receptor);

        // Determinar el tipo basado en el rol del receptor
        $tipo = $receptor->roles->contains('id', 5) ? 2 : 1;
// dd($tipo);
        DB::beginTransaction();

        try {
            // Crear el despacho con la fecha convertida y el tipo determinado
            $despacho = Despacho::create([
                'codigo' => $request->codigo,
                'sabor' => $request->sabor,
                'fecha' => $fecha_formato_db,
                'user_id' => $user_id,
                'observacion' => $request->observacion,
                'salida_esperada' => $request->salida_esperada,
                'receptor' => $request->receptor,
                'total' => $request->total,
                'tipo' => $tipo,
            ]);

            // Procesar los detalles del despacho
            $carrito = json_decode($request->carrito, true);

            foreach ($carrito as $detalle) {
                Detalle_Despacho::create([
                    'despacho_id' => $despacho->id,
                    'materia_prima_id' => $detalle['id'], // Asegúrate de que el índice 'id' sea correcto
                    'cantidad_presentacion' => $detalle['cantidad_presentacion'],
                    'cantidad_unidad' => $detalle['cantidad_unidad'],
                ]);

                // Actualizar el stock del producto
                $producto = Materia_prima::findOrFail($detalle['id']);
                $producto->stock_presentacion -= $detalle['cantidad_presentacion'];
                $producto->stock_unidad -= $detalle['cantidad_unidad'];
                $producto->save();
            }

            DB::commit();

            return redirect()->route('despacho.index')->with('correcto', 'Despacho registrado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Hubo un error al registrar el despacho: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        // Buscar el despacho con el id proporcionado
        $despacho = Despacho::findOrFail($id);

        // Obtener los detalles del despacho
        $detalles = Detalle_despacho::where('despacho_id', $id)->get();

        // Obtener el id del receptor desde el despacho
        $receptorId = $despacho->receptor;

        // Buscar el usuario con el id del receptor
        $receptor = User::where('id', $receptorId)->value('name');

        // Retornar la vista con los datos del despacho, detalles y el nombre del receptor
        return view('admin.despacho.show', compact('despacho', 'detalles', 'receptor'));
    }


    public function edit($id)
    {
        $despacho = Despacho::findOrFail($id);

        $fechaActual = Carbon::now();
        $dia = $fechaActual->format('d');
        $mes = strtoupper($fechaActual->format('M'));
        $anio = $fechaActual->format('Y');
        $ultimaEntrega = Despacho::whereDate('created_at', $fechaActual->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimaEntrega) {
            $ultimoCodigo = $ultimaEntrega->codigo;
            $partes = explode('-', $ultimoCodigo);
            $numeroEntrega = (int) $partes[1] + 1;
        } else {
            $numeroEntrega = 1;
        }

        $codigo = "MT-{$numeroEntrega}-{$dia}-{$mes}-{$anio}";
        $users = User::with('roles')->where('tipo', 2)->get(); // Cargar los usuarios con sus roles

        // Filtrar materias primas que pertenecen a categoría_id = 1
        $materia_primas = Materia_prima::whereHas('subcategoria', function ($query) {
            $query->where('categoria_id', 2);
        })->get();
        $detalles = Detalle_despacho::where('despacho_id', $id)->get();

        return view('admin.despacho.edit', compact('codigo', 'users', 'materia_primas','despacho'))->with('correcto', 'Subcategorium added!');
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $despacho = Despacho::findOrFail($id);
        $despacho->update($requestData);

        return redirect('admin/despacho')->with('correcto', 'Despacho updated!');
    }

    public function destroy($id)
    {
        Despacho::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/despacho')->with('correcto', 'Despacho deleted!');
    }

    public function reingresar($id)
    {
        Despacho::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/despacho')->with('correcto', 'Despacho deleted!');
    }
}
