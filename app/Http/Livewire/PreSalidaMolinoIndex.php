<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Proceso;
use App\Models\PreSalidaMolinos;
use App\Models\User;
use App\Models\Despacho;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PreSalidaMolinoIndex extends Component
{
    public $ID_PROCESO;
    public $LISTA_DE_SABORES = [];
    public $LISTA_TURNOS = [];
    public $PROCESO_ACTUAL;
    // se inicializa una sola vez,
    public function mount($id_proceso){
        $this->emit('mensaje', 'INICIALIZADO FULLLL');
        $this->ID_PROCESO = $id_proceso;
        $this->LISTA_DE_SABORES = include(app_path(). '/dataCustom/sabores.php');
        $this->LISTA_TURNOS = include(app_path(). '/dataCustom/turnos.php');
    }
    public function render()
    {
        $liv_proceso = Proceso::where('id', $this->ID_PROCESO)->first();

        $liv_pre_salidas_molino = [];
        if($liv_proceso){
            $this->PROCESO_ACTUAL = $liv_proceso;
            $liv_pre_salidas_molino = PreSalidaMolinos::where('proceso_id', $liv_proceso->id)
                ->where('estado', 1)
                ->get();
            /* foreach($liv_pre_salidas_molino as $salida){

            } */
        }

        $usuarios = User::where('tipo', 2)->get();


        return view('livewire.pre-salida-molino-index', [
            'liv_proceso' => $liv_proceso,
            'liv_pre_salidas_molino' => $liv_pre_salidas_molino,
            'usuarios' => $usuarios
            //'liv_sabores_dispononibles' => $liv_sabores_dispononibles
        ]);
    }

    /* ********************** INIT RULES ************************** */
    public $operation = '';

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    protected function rules(){
        if($this->operation=='create_salida_molino'){
            return $this->rulesForCreateSalidaMolino();
        }
        return array_merge(
            $this->rulesForCreateSalidaMolino()
        );
    }

    public $c_codigo;
    public $c_fecha;
    public $c_turno;
    public $c_id_encargado;
    public $c_proceso_id;
    public $c_observacion;
    public $c_baldes;
    public $c_cantidad;
    public function rulesForCreateSalidaMolino(){
        return [
            'c_codigo' => 'required|unique:pre_salida_molino,codigo|min:10',
            'c_fecha' => 'required|date',
            'c_turno' => 'required|string|min:2',
            'c_id_encargado' => 'required',
            'c_proceso_id' => 'required',
            'c_observacion' => 'nullable|string',
            'c_baldes' => 'required|numeric|min:0.1',
            'c_cantidad' => 'required|numeric|min:0.1',
        ];
    }

    public function open_modal_crear_salida_mol(){
        $this->emit('mensaje', 'ya esta abierto hhh');
        $this->close_modal_crear_salida_mol();
        $this->operation = 'create_salida_molino';

        $fechaActual = \Carbon\Carbon::now();
        $dia = $fechaActual->format('d');
        $mes = strtoupper($fechaActual->format('M'));
        $anio = $fechaActual->format('Y');

        $ultimaEntrega = PreSalidaMolinos::whereDate('created_at', $fechaActual->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        $numeroEntrega = $ultimaEntrega ? ((int) explode('-', $ultimaEntrega->codigo)[1] + 1) : 1;

        $this->c_codigo = "EM-{$numeroEntrega}-{$dia}-{$mes}-{$anio}";
        $this->c_fecha = $fechaActual->isoFormat('YYYY-MM-DD');
        $this->c_proceso_id = $this->PROCESO_ACTUAL->id;

    }

    public function close_modal_crear_salida_mol(){
        $this->operation = '';
        $this->reset([
            'c_codigo',
            'c_fecha',
            'c_turno',
            'c_id_encargado',
            'c_proceso_id',
            'c_observacion',
            'c_baldes',
            'c_cantidad',
        ]);
        $this->resetValidation();
    }

    public function save_modal_crear_salida_mol(){
        if($this->operation == 'create_salida_molino'){
            $this->emit('mensaje', 'LISTO PARA VALIDAR');
            $this->validate();
            $this->emit('mensaje', 'SE TERMINO DE VALIDAR');
            try{
                DB::beginTransaction();
                // guardar
                $guardar = new PreSalidaMolinos();
                $guardar->codigo = $this->c_codigo;
                $guardar->fecha = $this->c_fecha;
                $guardar->turno = $this->c_turno;
                $guardar->id_encargado = $this->c_id_encargado;
                $guardar->proceso_id = $this->c_proceso_id;
                $guardar->observacion = $this->c_observacion;
                $guardar->baldes = $this->c_baldes;
                $guardar->cantidad = $this->c_cantidad;
                $guardar->estado = 1;
                $guardar->id_user = Auth::id();
                $guardar->save();

                $proceso = Proceso::find($this->c_proceso_id);
                // Restar la cantidad total de baldes y kilos utilizados
                $proceso->total_baldes -= $this->c_baldes;
                $proceso->total_cantidad -= $this->c_cantidad;
                $proceso->save();

                DB::commit();
                $this->emit('success', 'Se ha creado exitosamente la salida de molino');
                $this->close_modal_crear_salida_mol();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al crear la salida de molino. ', $e->getMessage());
            }
        }
    }

    public function updatedCBaldes(){
        if(is_numeric($this->c_baldes) && $this->PROCESO_ACTUAL){
            $this->resetValidation('c_baldes');
            if($this->c_baldes <= $this->PROCESO_ACTUAL->total_baldes){
                $this->c_baldes = round($this->c_baldes, 1);
                $this->resetValidation('c_cantidad');
                $this->c_cantidad = ($this->PROCESO_ACTUAL->total / $this->PROCESO_ACTUAL->baldes) * $this->c_baldes;
            } else {
                $this->addError('c_baldes', 'La cantidad de baldes debe ser menor que '. $this->PROCESO_ACTUAL->total_baldes .' baldes');
            }
        }
    }

    public function updatedCCantidad(){
        if(is_numeric($this->c_cantidad) && $this->PROCESO_ACTUAL){
            $this->resetValidation('c_cantidad');
            if($this->c_cantidad <= $this->PROCESO_ACTUAL->total_cantidad){
                $this->c_cantidad = round($this->c_cantidad, 1);
                $this->resetValidation('c_baldes');
                $this->c_baldes = ($this->PROCESO_ACTUAL->baldes / $this->PROCESO_ACTUAL->total ) * $this->c_cantidad;
            } else {
                $this->addError('c_cantidad', 'La cantidad de kg debe ser menor que '. $this->PROCESO_ACTUAL->total_cantidad .' kg.');
            }
        }
    }
    /* *********************************************************** */

    /* ********************** END RULES ************************** */

    public function eliminar_salida_mol($id){
        try{
            DB::beginTransaction();
            $salida_mol = PreSalidaMolinos::where('id', $id)->first();
            $salida_mol->estado = 0;
            $salida_mol->id_user = Auth::id();
            $salida_mol->save();

            $proceso = Proceso::find($salida_mol->proceso_id);
            // Aumentar la cantidad total de baldes y kilos utilizados
            $proceso->total_baldes += $salida_mol->baldes;
            $proceso->total_cantidad += $salida_mol->cantidad;
            $proceso->save();

            DB::commit();
            $this->emit('success', 'Se ha eliminado la salida de molino exitosamente');
        } catch(\Exception $e){
            DB::rollBack();
            $this->emit('error', 'Error al intentar eliminar la salida de molino. ', $e->getMessage());
        }
    }
}
