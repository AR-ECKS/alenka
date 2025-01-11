<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\Maquina;
use App\Models\SalidasDeMolino;
use App\Models\DetalleSalidasDeMolino;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class SalidaMolinoIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'eliminar_proceso_preparacion'
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
        $maquinas = Maquina::where('estado', 1)->get();

        return view('livewire.salida-molino-index', [
            'salidas_molino' => $this->get_data(),
            'list_anio' => $this->get_gestiones(),
            'list_mes' => $this->get_meses(),
            'list_dias' => $this->get_dias(),
            'usuarios' => $usuarios,
            'maquinas' => $maquinas
        ]);
    }


    private function get_data(){
        $salidas_molino = SalidasDeMolino::#where('estado', 1)->get();
            paginate(10);
        return $salidas_molino;
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
            DB::raw('YEAR(fecha) as anio')
        )->distinct()
        ->orderBy('anio')
        ->get();

        return collect($gestiones)->push($this->fechaActual->isoFormat('YYYY'))->unique()->sortDesc()->values();
    }

    public function get_meses(){
        $meses = SalidasDeMolino::select(
            DB::raw('MONTH(fecha) as mes')
        )->distinct()
        ->orderBy('mes')
        ->get();

        return collect($meses)->push($this->fechaActual->isoFormat('MM'))->unique()->sort()->values();
    }

    public function get_dias(){
        $inicio = Carbon::createFromDate($this->fechaActual->isoFormat('YYYY'), $this->fechaActual->isoFormat('MM'), 1);
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
    }

    /* ********************** INIT RULES ************************** */
    public $operation = '';

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    protected function rules(){
        if($this->operation=='create_salida_molino'){
            return $this->rulesForCreateSalidaMolino();
        }/*  else if($this->operation=='admin_proccess_preparation'){
            return $this->rulesForAdminProcessPreparation();
        } */
        return array_merge(
            $this->rulesForCreateSalidaMolino()/* ,
            $this->rulesForCreateProcessPreparation() */
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
        ]);
        $this->resetValidation();
    }

    public function save_modal_crear_salida_mol(){
        if($this->operation == 'create_salida_molino'){
            $this->validate();
        }
    }

    public function on_change_sabor(){
        $this->emit('mensaje', 'Se actualizo es'. $this->sabor);
        $this->lista_de_baldes = [];
        $this->det_despacho_id = "";
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
                ->groupBy('detalle_proceso_preparacion.proceso_preparacion_id')
                ->get()->toArray();
        }
    }

    public function on_change_det_despacho_id(){
        $this->id_balde_detalle_proceso_preparacion = "";
        if(is_null($this->det_despacho_id) || $this->det_despacho_id==""){
            $this->LISTA_DETALLE_BALDES_DE_PREPARACION = [];
        } else {
            $this->LISTA_DETALLE_BALDES_DE_PREPARACION = DetalleSalidasDeMolino::select(
                    'proceso_preparacion.id AS id_proceso_preparacion',
                    'proceso_preparacion.codigo',
                    'proceso_preparacion.fecha',
                    'proceso_preparacion.observacion',

                    'detalle_proceso_preparacion.id AS id_det_preparacion',
                    'detalle_proceso_preparacion.fecha AS fecha_det_preparacion',
                    'detalle_proceso_preparacion.observacion AS observacion_det_preparacion',
                    'kg_balde',
                    'nro_balde'
                )
                ->rightJoin('detalle_proceso_preparacion', 'detalle_proceso_preparacion.id', '=', 'detalle_salidas_de_molino.detalle_proceso_preparacion_id')
                ->join('proceso_preparacion', 'proceso_preparacion.id', '=', 'detalle_proceso_preparacion.proceso_preparacion_id')
                #->join('despachos', 'despachos.id', '=', 'proceso_preparacion.despacho_id')
                ->where('proceso_preparacion.id', '=', $this->det_despacho_id)
                ->get()->toArray();
        }
    }

    public $det_despacho_id;
    public $id_balde_detalle_proceso_preparacion;
    public function agregar_balde(){
        
    }
}
