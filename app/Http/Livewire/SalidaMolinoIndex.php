<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\Maquina;
use App\Models\SalidasDeMolino;
use App\Models\DetalleSalidasDeMolino;
use App\Models\DetalleProcesoPreparacion;
use App\Models\ProductosEnvasados;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SalidaMolinoIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'eliminar_proceso_preparacion',
        'eliminar_balde_editar'
    ];

    public $fechaActual = "";
    public $LISTA_DE_SABORES = [];
    public $LISTA_TURNOS = [];
    public function mount(){
        $this->fechaActual = Carbon::now();#->isoFormat('YYYY-MM-DD');
        $this->anio = $this->fechaActual->isoFormat('YYYY');
        $this->mes = $this->fechaActual->isoFormat('MM');
        $this->dia = $this->fechaActual->isoFormat('DD');

        $this->statusMes = $this->statusDia = true;

        $this->LISTA_DE_SABORES = include(app_path(). '/dataCustom/sabores.php');
        $this->LISTA_TURNOS = include(app_path(). '/dataCustom/turnos.php');
        #$this->emit('mensaje', 'FECHA es'. $fechaActual);
    }

    public function render()
    {
        $usuarios = User::where('tipo', 2)->get();
        $maquinas = Maquina::where('estado', '<>', 0)->get();

        return view('livewire.salida-molino-index', [
            'salidas_molino' => $this->get_data(),
            'list_anio' => $this->get_gestiones(),
            'list_mes' => $this->get_meses(),
            'list_dias' => $this->get_dias(),
            'usuarios' => $usuarios,
            'maquinas' => $maquinas,

            'list_editar_det_sal_mol' => $this->operation=='edit_salida_molino'? $this->get_current_detalle_salida_molino() : []
        ]);
    }


    private function get_data(){
        $salidas_molino = SalidasDeMolino::where('estado', '<>', 0);
        if(!is_null($this->anio) && $this->anio !== "") {
            $salidas_molino->where( DB::raw("DATE_FORMAT(fecha, '%Y')"), $this->anio);
            if(!is_null($this->mes) && $this->mes !== ""){
                $salidas_molino->where( DB::raw("DATE_FORMAT(fecha, '%m')"), $this->mes);
                if(!is_null($this->dia) && $this->dia !== ""){
                    $salidas_molino->where( DB::raw("DATE_FORMAT(fecha, '%d')"), $this->dia);
                }
            }
        }
        $salidas_molino->orderBy('fecha', 'desc')
            ->orderBy('turno')
            ->orderBy('maquina_id');
        return $salidas_molino->paginate(10);
    }

    public $anio = "";
    public $mes = "", $statusMes = false;
    public $dia = "", $statusDia = false;

    public function on_change_anio(){
        if($this->anio == ""){
            $this->mes = $this->dia = "";
            $this->statusMes = $this->statusDia = false;
        } else {
            $this->statusMes = true;
            $this->mes = $this->dia = "";
            $this->statusDia = false;
        }
    }

    public function on_change_mes(){
        if($this->mes == ""){
            $this->dia = "";
            $this->statusDia = false;
        } else {
            $this->statusDia = true;
            $this->dia = "";
        }
    }

    public function get_gestiones(){
        $gestiones = SalidasDeMolino::select(
            DB::raw("DATE_FORMAT(fecha, '%Y') as anio")
        )->distinct()
        ->orderBy('anio')
        ->get();

        return collect($gestiones->map(function($value){
            return $value->anio;
        }))->push( $this->fechaActual->isoFormat('YYYY') )->unique()->sortDesc()->values();
    }

    public function get_meses(){
        if($this->anio !== ""){
            $build = SalidasDeMolino::select(
                DB::raw("DATE_FORMAT(fecha, '%m') as mes")
            )->distinct()
            ->orderBy('mes');

            if(!is_null($this->anio) && $this->anio !== ""){
                $build->where( DB::raw("DATE_FORMAT(fecha, '%Y')"), $this->anio);
            }

            $meses = $build->get();

            return collect($meses->map(function( $value){
                return $value->mes;
            }))->push($this->fechaActual->isoFormat('MM'))->unique()->sort()->values();
        } else {
            return [];
        }
    }

    public function get_dias(){
        if($this->anio !== "" && $this->mes!== ""){
            # $inicio = Carbon::createFromDate($this->fechaActual->isoFormat('YYYY'), $this->fechaActual->isoFormat('MM'), 1);
            $inicio = Carbon::createFromDate($this->anio, $this->mes, 1);
            $fin = $inicio->copy()->endOfMonth();

            $todo = CarbonPeriod::create($inicio, $fin)->toArray();
            $dias = collect($todo)->map(function($fec) {
                return [
                    #'dia' => $fec->day,
                    'dia' => $fec->isoFormat('DD'),
                    'nombre' => $fec->locale('es')->isoFormat('dddd')
                ];
            });
            return $dias;
        } else {
            return [];
        }
    }

    /* ********************** INIT RULES ************************** */
    public $operation = '';

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    protected function rules(){
        if($this->operation=='create_salida_molino'){
            return $this->rulesForCreateSalidaMolino();
        } else if($this->operation=='edit_salida_molino'){
            return $this->rulesForEditSalidaMolino();
        }
        return array_merge(
            $this->rulesForCreateSalidaMolino(),
            $this->rulesForEditSalidaMolino()
        );
    }

    /* ******************************************************************************************* */

    public $codigo;
    public $fecha;
    public $turno;
    public $encargado_id;
    public $maquina_id;
    public $sabor;
    public $observacion;
    public $total_aprox;
    
    public $LISTA_DETALLE_PREPARACION = [];
    public $LISTA_DETALLE_BALDES_DE_PREPARACION = [];
    public $lista_de_baldes = [];
    public $cantidad_baldes = 0;
    public function rulesForCreateSalidaMolino(){
        return [
            'codigo' => 'required|unique:salidas_de_molino,codigo|min:10',
            'fecha' => 'required|date',
            'turno' => 'required|string|min:2',
            'encargado_id' => 'required',
            'maquina_id' => 'required',
            'sabor' => 'required|string',
            'observacion' => 'nullable|string',
            'total_aprox' => 'required|numeric|min:0.1',
            'cantidad_baldes' => 'required|integer|min:1|max:20'
        ];
    }

    public function open_modal_crear_salida_mol(){
        $this->emit('mensaje', 'ya esta abierto hhh');
        $this->close_modal_crear_salida_mol();
        $this->operation = 'create_salida_molino';

        $fechaAct = Carbon::now();
        $dia = $fechaAct->format('d');
        $mes = strtoupper($fechaAct->locale('es')->isoFormat('MMM'));
        $anio = $fechaAct->format('Y');

        $ultimaEntrega = SalidasDeMolino::whereDate('created_at', $fechaAct->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        $numeroEntrega = $ultimaEntrega ? ((int) explode('-', $ultimaEntrega->codigo)[1] + 1) : 1;

        $this->codigo = "EM-{$numeroEntrega}-{$dia}-{$mes}-{$anio}";
        $this->fecha = $fechaAct->isoFormat('YYYY-MM-DD');

        if($fechaAct->hour < 12){
            $this->turno = "mañana";
        } else {
            $this->turno = "tarde";
        }
    }

    public function close_modal_crear_salida_mol(){
        $this->operation = '';
        $this->reset([
            'codigo',
            'fecha',
            'turno',
            'encargado_id',
            'maquina_id',
            'sabor',
            'observacion',
            'total_aprox',
            'cantidad_baldes'
        ]);
        $this->limpiar_balde();
        $this->resetValidation();
    }

    public function save_modal_crear_salida_mol(){
        if($this->operation == 'create_salida_molino'){
            $this->validate();
            try{
                DB::beginTransaction();

                $salida_de_molino = new SalidasDeMolino();
                $salida_de_molino->codigo = $this->codigo;
                $salida_de_molino->fecha = $this->fecha;
                $salida_de_molino->turno = $this->turno;
                $salida_de_molino->encargado_id = $this->encargado_id;
                $salida_de_molino->maquina_id = $this->maquina_id;
                $salida_de_molino->sabor = $this->sabor;
                $salida_de_molino->observacion = (is_null($this->observacion))? '': $this->observacion;
                $salida_de_molino->total_aprox = round($this->total_aprox, 2);
                $salida_de_molino->id_user = Auth::id();
                $salida_de_molino->save();

                foreach($this->lista_de_baldes as $bal_det){
                    $detalle_salida_molino = new DetalleSalidasDeMolino();
                    $detalle_salida_molino->salida_de_molino_id = $salida_de_molino->id;
                    $detalle_salida_molino->detalle_proceso_preparacion_id = $bal_det['id'];
                    $detalle_salida_molino->id_user = Auth::id();
                    $detalle_salida_molino->save();
                }

                /* $producto = new ProductosEnvasados();
                $producto->sabor = $this->sabor;
                $producto->codigo = $this->codigo;
                $producto->fecha = $this->fecha;
                $producto->salida_de_molino_id = $salida_de_molino->id;
                $producto->encargado_id = $this->encargado_id;
                $producto->maquina_id = $this->maquina_id;
                $producto->balde_entrada_de_molino = $this->cantidad_baldes;
                $producto->save(); */

                DB::commit();
                $this->emit('success', 'Se ha creado exitosamente la salida de molino');
                $this->close_modal_crear_salida_mol();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al crear la nueva salida de molino. '. $e->getMessage());
            }
        }
    }

    public function on_change_sabor(){
        $this->emit('mensaje', 'Se actualizo es'. $this->sabor);
        $this->lista_de_baldes = [];
        $this->det_despacho_id = "";
        $this->on_change_det_despacho_id();
        $this->actualizar_total_kg_aprox();
        if(is_null($this->sabor) || $this->sabor==""){
            $this->LISTA_DETALLE_PREPARACION = [];
        } else {
            $this->LISTA_DETALLE_PREPARACION = DetalleSalidasDeMolino::select(
                    'proceso_preparacion.id AS id_proceso_preparacion',
                    'despachos.sabor',
                    'proceso_preparacion.codigo',
                    'proceso_preparacion.fecha',
                    'proceso_preparacion.observacion'
                )
                ->rightJoin('detalle_proceso_preparacion', 'detalle_proceso_preparacion.id', '=', 'detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                ->join('proceso_preparacion', 'proceso_preparacion.id', '=', 'detalle_proceso_preparacion.proceso_preparacion_id')
                ->join('despachos', 'despachos.id', '=', 'proceso_preparacion.despacho_id')
                ->where('despachos.sabor', '=', $this->sabor)
                ->where(function($query){
                    $query->whereNull('detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                        ->orWhere('detalle_salidas_de_molino.estado', '=', 0);
                })
                # sin eliminados
                ->where('detalle_proceso_preparacion.estado', '<>', 0)

                # que la fecha de preparacion sea menor o igual 
                ->where('proceso_preparacion.fecha' , '<=', $this->fecha)
                ->where('detalle_proceso_preparacion.fecha' , '<=', $this->fecha)

                ->groupBy('detalle_proceso_preparacion.proceso_preparacion_id')
                ->get()->toArray();
        }
    }

    public function on_change_det_despacho_id(){
        $this->id_balde_detalle_proceso_preparacion = "";
        if(is_null($this->det_despacho_id) || $this->det_despacho_id==""){
            $this->LISTA_DETALLE_BALDES_DE_PREPARACION = [];
        } else {
            $excluidos = [];
            if(count($this->lista_de_baldes) > 0){
                foreach ($this->lista_de_baldes as $bal) {
                    $excluidos[] = $bal['id'];
                    #$this->emit('mensaje', 'es'. $bal['id']);
                }
            }

            $consulta = DetalleSalidasDeMolino::select(
                    'proceso_preparacion.id AS id_proceso_preparacion',
                    'proceso_preparacion.codigo',
                    'proceso_preparacion.fecha',
                    'proceso_preparacion.observacion',

                    'detalle_proceso_preparacion.id AS id_det_preparacion',
                    'detalle_proceso_preparacion.fecha AS fecha_det_preparacion',
                    'detalle_proceso_preparacion.observacion AS observacion_det_preparacion',
                    'kg_balde',
                    'nro_balde',
                    'detalle_proceso_preparacion.estado'
                )
                ->rightJoin('detalle_proceso_preparacion', 'detalle_proceso_preparacion.id', '=', 'detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                ->join('proceso_preparacion', 'proceso_preparacion.id', '=', 'detalle_proceso_preparacion.proceso_preparacion_id')
                #->join('despachos', 'despachos.id', '=', 'proceso_preparacion.despacho_id')
                ->where('proceso_preparacion.id', '=', $this->det_despacho_id)
                ->where(function($query){
                    $query->whereNull('detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                        ->orWhere('detalle_salidas_de_molino.estado', '=', 0);
                });
                
                # excluir los baldes que esren estado 0
                $consulta->where('detalle_proceso_preparacion.estado', '<>', 0);
                #$consulta->where('proceso_preparacion.estado', '<>', 0);

                # que la fecha de preparacion sea menor o igual 
                $consulta->where('proceso_preparacion.fecha' , '<=', $this->fecha)
                ->where('detalle_proceso_preparacion.fecha' , '<=', $this->fecha);
            
                if(count($this->lista_de_baldes) > 0){
                    $consulta->whereNotIn('detalle_proceso_preparacion.id', $excluidos);
                }
            $consulta->orderBy('detalle_proceso_preparacion.nro_balde');
            
            $this->LISTA_DETALLE_BALDES_DE_PREPARACION = $consulta->get()->toArray();
        }
    }

    public $det_despacho_id;
    public $id_balde_detalle_proceso_preparacion;
    public function agregar_balde(){
        $this->validate([
            'det_despacho_id' => 'required',
            'id_balde_detalle_proceso_preparacion' => 'required'
        ]);

        /* $balde = [
            'detalle_proceso_preparacion_id' => $this->id_balde_detalle_proceso_preparacion,
            ''
        ]; */

        $balde = DetalleProcesoPreparacion::where('id', $this->id_balde_detalle_proceso_preparacion)->first();
        if($balde){
            $this->lista_de_baldes[] = $balde;
            $this->limpiar_balde();
            $this->on_change_det_despacho_id();
            $this->actualizar_total_kg_aprox();
        }
    }

    public function limpiar_balde(){
        $this->reset([
            'det_despacho_id',
            'id_balde_detalle_proceso_preparacion'
        ]);
        $this->resetValidation([
            'det_despacho_id',
            'id_balde_detalle_proceso_preparacion'
        ]);
    }

    public function actualizar_total_kg_aprox(){
        $total_aprox_kg = 0;
        if(count($this->lista_de_baldes) > 0){
            foreach($this->lista_de_baldes as $bald){
                $total_aprox_kg += $bald['kg_balde'];
            }
        }
        $this->total_aprox = $total_aprox_kg;
        $this->cantidad_baldes = count($this->lista_de_baldes);
    }

    public function quitar_balde($id_balde){
        #buscar indice y borrar
        $idx = array_search( $id_balde, array_column($this->lista_de_baldes, 'id') );
        if($idx!==false){
            array_splice($this->lista_de_baldes, $idx, 1);
            $this->on_change_det_despacho_id();
            $this->actualizar_total_kg_aprox();
        }
        $this->emit('mensaje', 'index is'. $idx);
    }

    /* ******************************************************************************************* */

    public $ed_id;
    public $ed_codigo;
    public $ed_fecha;
    public $ed_turno;
    public $ed_encargado_id;
    public $ed_maquina_id;
    public $ed_sabor;
    public $ed_observacion;
    public $ed_total_aprox;
    public $ed_cantidad_baldes;

    public $ed_LISTA_PREPARACION = [];
    public $ed_LISTA_DETALLE_BALDES_DE_PREPARACION = [];
    public function rulesForEditSalidaMolino(){
        return [
            'ed_id' => 'required|exists:salidas_de_molino,id',
            'ed_codigo' => [
                    'required',
                    Rule::unique('salidas_de_molino', 'codigo')->ignore($this->ed_id),
                    'min:10'
                ],
            'ed_fecha' => 'required|date',
            'ed_turno' => 'required|string|min:2',
            'ed_encargado_id' => 'required',
            'ed_maquina_id' => 'required',
            'ed_sabor' => 'required|string',
            'ed_observacion' => 'nullable|string',
            'ed_total_aprox' => 'required|numeric|min:0.1',
            'ed_cantidad_baldes' => 'required|integer|min:1|max:20'
        ];
    }

    public function open_modal_editar_salida_mol($id_sal_molino){
        $this->close_modal_crear_salida_mol();
        $salida_molino = SalidasDeMolino::where('id', $id_sal_molino)->first();
        if($salida_molino){
            $this->operation = 'edit_salida_molino';
            $this->ed_id = $salida_molino->id;
            $this->ed_codigo = $salida_molino->codigo;
            $this->ed_fecha = $salida_molino->fecha;
            $this->ed_turno = $salida_molino->turno;
            $this->ed_encargado_id = $salida_molino->encargado_id;
            $this->ed_maquina_id = $salida_molino->maquina_id;
            $this->ed_sabor = $salida_molino->sabor;
            $this->ed_observacion = $salida_molino->observacion;
            $this->ed_total_aprox = $salida_molino->total_aprox;

            $this->ed_cantidad_baldes = count($salida_molino->detalle_salida_molinos);
            $this->on_update_preparation();
        }
    }

    public function close_modal_editar_salida_mol(){
        $this->operation = '';
        $this->reset([
            'ed_id',
            'ed_codigo',
            'ed_fecha',
            'ed_turno',
            'ed_encargado_id',
            'ed_maquina_id',
            'ed_sabor',
            'ed_observacion',
            'ed_total_aprox',
            'ed_cantidad_baldes'
        ]);
        $this->editar_limpiar_balde();
        $this->resetValidation();
    }

    public function save_modal_editar_salida_mol(){
        if($this->operation == 'edit_salida_molino'){
            $this->validate();
            try{
                DB::beginTransaction();

                $salida_de_molino = SalidasDeMolino::where('id', '=', $this->ed_id)->first();
                $salida_de_molino->codigo = $this->ed_codigo;
                $salida_de_molino->fecha = $this->ed_fecha;
                $salida_de_molino->turno = $this->ed_turno;
                $salida_de_molino->encargado_id = $this->ed_encargado_id;
                $salida_de_molino->maquina_id = $this->ed_maquina_id;
                $salida_de_molino->sabor = $this->ed_sabor;
                $salida_de_molino->observacion = (is_null($this->ed_observacion))? '': $this->ed_observacion;
                #$salida_de_molino->total_aprox = round($this->ed_total_aprox, 2);
                $salida_de_molino->id_user = Auth::id();
                $salida_de_molino->save();

                DB::commit();
                $this->emit('success', 'Se ha actualizado exitosamente la salida de molino');
                $this->close_modal_crear_salida_mol();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al actualizar la salida de molino. '. $e->getMessage());
            }
        }
    }

    private function get_current_detalle_salida_molino(){
        return DetalleSalidasDeMolino::where('estado', '<>', 0)
            ->where('salida_de_molino_id', $this->ed_id)
            ->get();
    }

    private function actuliza_editar_salida_mol(){
        $kg_aprox = 0;
        $lista_det = $this->get_current_detalle_salida_molino();
        foreach($lista_det as $tmp){
            $kg_aprox += $tmp->detalle_proceso_preparacion->kg_balde;
        }
        $total_baldes = count($lista_det);

        $salid_mol = SalidasDeMolino::where('id', $this->ed_id)->first();
        $salid_mol->total_aprox = round($kg_aprox, 2);
        $salid_mol->id_user = Auth::id();
        $salid_mol->save();

        $this->ed_cantidad_baldes = $total_baldes;
        $this->ed_total_aprox = $salid_mol->total_aprox;
    }

    public function eliminar_balde_editar($id){
        try{
            DB::beginTransaction();
            $det_salida_mol = DetalleSalidasDeMolino::where('id', $id)->first();
            $det_salida_mol->estado = 0;
            $det_salida_mol->id_user = Auth::id();
            $det_salida_mol->save();

            $this->editar_limpiar_balde();
            $this->on_update_preparation();
            $this->actuliza_editar_salida_mol();

            DB::commit();
            $this->emit('success', 'Se ha eliminado exitosamente un balde');
        } catch(\Exception $e){
            DB::rollBack();
            $this->emit('error', 'Error al eliminar balde. '. $e->getMessage());
        }
    }

    public function editar_limpiar_balde(){
        $this->reset([
            'edit_despacho_id',
            'edit_detalle_balde_id'
        ]);
        $this->resetValidation([
            'edit_despacho_id',
            'edit_detalle_balde_id'
        ]);
    }

    public $edit_despacho_id;
    public $edit_detalle_balde_id;
    public function agregar_balde_editar(){
        $this->validate([
            'edit_despacho_id' => 'required',
            'edit_detalle_balde_id' => 'required'
        ]);

        try{
            DB::beginTransaction();
            $balde = new DetalleSalidasDeMolino();
            $balde->salida_de_molino_id = $this->ed_id;
            $balde->detalle_proceso_preparacion_id = $this->edit_detalle_balde_id;
            $balde->id_user = Auth::id();
            $balde->save();

            $this->editar_limpiar_balde();
            $this->on_update_preparation();
            $this->actuliza_editar_salida_mol();

            DB::commit();
            $this->emit('success', 'Se ha agregado exitosamente un balde');

        } catch(\Exception $e){
            DB::rollBack();
            $this->emit('error', 'Error al insertar balde. '. $e->getMessage());
        }

        $balde = DetalleProcesoPreparacion::where('id', $this->id_balde_detalle_proceso_preparacion)->first();
        if($balde){
            $this->lista_de_baldes[] = $balde;
            $this->limpiar_balde();
            $this->on_change_det_despacho_id();
            $this->actualizar_total_kg_aprox();
        }
    }

    public function on_update_preparation(){
        $this->emit('mensaje', 'datos actualizados');
        $this->edit_detalle_balde_id = "";
       /*  $this->on_change_det_despacho_id();
        $this->actualizar_total_kg_aprox(); */
        if(is_null($this->ed_sabor) || $this->ed_sabor==""){
            $this->ed_LISTA_PREPARACION = [];
        } else {
            $this->ed_LISTA_PREPARACION = DetalleSalidasDeMolino::select(
                    'proceso_preparacion.id AS id_proceso_preparacion',
                    'despachos.sabor',
                    'proceso_preparacion.codigo',
                    'proceso_preparacion.fecha',
                    'proceso_preparacion.observacion'
                )
                ->rightJoin('detalle_proceso_preparacion', 'detalle_proceso_preparacion.id', '=', 'detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                ->join('proceso_preparacion', 'proceso_preparacion.id', '=', 'detalle_proceso_preparacion.proceso_preparacion_id')
                ->join('despachos', 'despachos.id', '=', 'proceso_preparacion.despacho_id')
                ->where('despachos.sabor', '=', $this->ed_sabor)
                ->where(function($query){
                    $query->whereNull('detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                        ->orWhere('detalle_salidas_de_molino.estado', '=', 0);
                })
                # sin eliminados
                ->where('detalle_proceso_preparacion.estado', '<>', 0)

                # que la fecha de preparacion sea menor o igual 
                ->where('proceso_preparacion.fecha' , '<=', $this->ed_fecha)
                ->where('detalle_proceso_preparacion.fecha' , '<=', $this->ed_fecha)

                ->groupBy('detalle_proceso_preparacion.proceso_preparacion_id')
                ->get()->toArray();
        }
    }

    public function on_change_edit_despacho_id(){
        #$this->id_balde_detalle_proceso_preparacion = "";
        if(is_null($this->edit_despacho_id) || $this->edit_despacho_id==""){
            $this->ed_LISTA_DETALLE_BALDES_DE_PREPARACION = [];
        } else {
            /* DB::statement(
                DB::raw("CREATE TEMPORARY TABLE temp_detalle_salidas_de_molino
                        SELECT * 
                        FROM detalle_salidas_de_molino
                        WHERE estado <> ?"), ['0']
            ); */
            $consulta = DetalleSalidasDeMolino::select(
                    DB::raw("DISTINCT(detalle_salidas_de_molino.detalle_proceso_preparacion_id)"),
                    'proceso_preparacion.id AS id_proceso_preparacion',
                    'proceso_preparacion.codigo',
                    'proceso_preparacion.fecha',
                    'proceso_preparacion.observacion',

                    'detalle_proceso_preparacion.id AS id_det_preparacion',
                    'detalle_proceso_preparacion.fecha AS fecha_det_preparacion',
                    'detalle_proceso_preparacion.observacion AS observacion_det_preparacion',
                    'kg_balde',
                    'nro_balde',
                    'detalle_proceso_preparacion.estado'
                )
                ->rightJoin('detalle_proceso_preparacion', 'detalle_proceso_preparacion.id', '=', 'detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                ->join('proceso_preparacion', 'proceso_preparacion.id', '=', 'detalle_proceso_preparacion.proceso_preparacion_id')
                #->join('despachos', 'despachos.id', '=', 'proceso_preparacion.despacho_id')
                ->where('proceso_preparacion.id', '=', $this->edit_despacho_id)
                
                #->whereNull('detalle_salidas_de_molino.detalle_proceso_preparacion_id');
                #->where('detalle_salidas_de_molino.estado', '<>', 0)
                ->where(function($query){
                    $query->whereNull('detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                        ->orWhere('detalle_salidas_de_molino.estado', '=', 0);
                });
                
                # excluir los baldes que esren estado 0
                $consulta->where('detalle_proceso_preparacion.estado', '<>', 0);
                #$consulta->where('proceso_preparacion.estado', '<>', 0);

                # que la fecha de preparacion sea menor o igual 
                $consulta->where('proceso_preparacion.fecha' , '<=', $this->ed_fecha)
                ->where('detalle_proceso_preparacion.fecha' , '<=', $this->ed_fecha);
            
            $consulta->orderBy('detalle_proceso_preparacion.nro_balde');
            
            $this->ed_LISTA_DETALLE_BALDES_DE_PREPARACION = $consulta->get()->toArray();
        }
    }

    /* ************************************************************** */

}
