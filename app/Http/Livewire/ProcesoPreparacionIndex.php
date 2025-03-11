<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\ProcesoPreparacion;
use App\Models\DetalleProcesoPreparacion;
use App\Models\Despacho;
use App\Models\RegistroParaPicar;
use App\Models\User;
use App\Models\PreSalidaMolinos;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class ProcesoPreparacionIndex extends Component
{
    public $U_1LB_A_KG = .453592;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'eliminar_proceso_preparacion'
    ];

    public function render()
    {
        return view('livewire.proceso-preparacion-index',[
            'procesos_preparacion' => $this->get_data(),
            'despachos' => $this->get_despachos(),
            'aumento_para_picar' => $this->get_registros_para_picar()
        ]);
    }

    private function get_data(){
        $procesos_prep = ProcesoPreparacion::where('estado', '<>', 0)
            ->orderBy('fecha', 'desc')
            ->paginate(5);
        return $procesos_prep;
    }

    private function get_despachos(){
        if($this->operation=='create_proccess_preparation' || $this->operation=='edit_proccess_preparation'){
            #$fechaActual = now()->format('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD
            $consulta = Despacho::select(
                    'despachos.id',
                    'despachos.codigo',
                    'despachos.sabor',
                    'despachos.observacion',
                    'despachos.fecha',
                    'despachos.receptor',
                )
                ->leftJoin('proceso_preparacion', 'proceso_preparacion.despacho_id', '=', 'despachos.id')
                #->where('despachos.estado', '<>', 0)
                ->where('tipo', 1)
                ->whereDate('despachos.created_at', $this->fecha); # fechaActual
                if($this->operation=='edit_proccess_preparation'){
                    $consulta->where(function($query){
                        $query->whereNull('proceso_preparacion.despacho_id')
                            ->orWhere('proceso_preparacion.id', $this->edit_id_proceso_preparacion);
                    });
                } else {
                    $consulta->whereNull('proceso_preparacion.despacho_id');
                }
            return $consulta->get();
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
        if($this->operation=='create_proccess_preparation'){
            return $this->rulesForCreateProcessPreparation();
        } else if($this->operation=='edit_proccess_preparation'){
            return $this->rulesForEditProcessPreparation();
        }else if($this->operation=='admin_proccess_preparation'){
            return $this->rulesForAdminProcessPreparation();
        }
        return array_merge(
            $this->rulesForCreateProcessPreparation(),
            $this->rulesForEditProcessPreparation(),
            $this->rulesForCreateProcessPreparation()
        );
    }

    /* ******************************************************************************************* */

    public $codigo;
    public $fecha;
    public $total_kg;
    public $disponible_kg;
    public $despacho_id;
    public $para_picar_id;
    public $observacion;
    public $despacho_actual;
    public function rulesForCreateProcessPreparation(){
        return [
            'codigo' => 'required|string|unique:proceso_preparacion,codigo|min:10|max:100',
            'fecha' => 'required|date',
            'total_kg' => 'required|numeric|min:0.1',
            'disponible_kg' => 'required|numeric|min:0.1',
            'despacho_id' => 'required',
            'para_picar_id' => 'nullable|exists:registro_para_picar,id',
            'observacion' => 'nullable|string|max:255',
        ];
    }

    public function open_modal_crear_prep_proceso(){
        $this->emit('mensaje', 'ya esta abierto hhh');
        $this->close_modal_crear_prep_proceso();
        $this->operation = 'create_proccess_preparation';

        $fechaActual = Carbon::now();
        $this->codigo = $this->generarCodigoProceso(); #"EM-{$numeroEntrega}-{$dia}-{$mes}-{$anio}";
        $this->fecha = $fechaActual->isoFormat('YYYY-MM-DD');
    }

    public function close_modal_crear_prep_proceso(){
        $this->operation = '';
        $this->reset([
            'edit_id_proceso_preparacion', # PARA EDITAR
            'codigo',
            'fecha',
            'total_kg',
            'disponible_kg',
            'despacho_id',
            'para_picar_id',
            'observacion',
        ]);
        $this->despacho_actual = null;
        $this->resetValidation();
    }

    public function store_modal_crear_prep_proceso($procesar = false){
        if($this->operation == 'create_proccess_preparation'){
            //$this->emit('mensaje', 'LISTO PARA VALIDAR');
            $this->validate();
            //$this->emit('mensaje', 'SE TERMINO DE VALIDAR');
            try {
                DB::beginTransaction();

                // Cambiar el estado del despacho de 1 a 0
                $despacho = Despacho::find($this->despacho_id);
                if ($despacho) {
                    $despacho->estado = 0; // Asumiendo que el campo se llama 'estado'
                    $despacho->save();
                }

                // guardar
                $proceso_preparacion = new ProcesoPreparacion();
                $proceso_preparacion->codigo = $this->codigo;
                $proceso_preparacion->fecha = $this->fecha;
                $proceso_preparacion->despacho_id = $this->despacho_id;
                $proceso_preparacion->recepcion_para_picar_id = (is_null($this->para_picar_id) || $this->para_picar_id=="")? null: $this->para_picar_id;
                $proceso_preparacion->total_kg = $this->total_kg;
                $proceso_preparacion->disponible_kg = $this->disponible_kg;
                $proceso_preparacion->observacion = is_null($this->observacion) ? '' : $this->observacion;
                $proceso_preparacion->id_user = Auth::id();

                $proceso_preparacion->save();

                DB::commit();
                $this->emit('success', 'Se ha creado exitosamente una nueva preparación');
                $this->close_modal_crear_prep_proceso();
                if($procesar){
                    $this->open_modal_admin_prep_proceso($proceso_preparacion->id);
                }
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al crear la nueva preparación. ' . $e->getMessage());
            }

        }
    }

    public function updatedDespachoId(){
        /* $this->despacho_actual = Despacho::where('id', $this->despacho_id)->first();
        $total_aprox = 0;
        if($this->despacho_actual && $this->despacho_actual->detalle_despachos){
            foreach ($this->despacho_actual->detalle_despachos as $value) {
                if($value->materia_prima->unidad_medida == 'kg'){
                    $total_aprox += $value->cantidad_unidad;
                } else if($value->materia_prima->unidad_medida == 'lb'){
                    $total_aprox += ($value->cantidad_unidad * $this->U_1LB_A_KG);
                }
            }
        } 
        if($this->para_picar_id && $this->para_picar_id !== ""){
            $picacion = RegistroParaPicar::where('id', $this->para_picar_id)
                ->where('estado', '<>', 0)
                ->first();
            if($picacion){
                $total_aprox = $picacion->cantidad_kg;
            }
        }
        $this->total_kg = round( floatval($total_aprox), 2);
        $this->disponible_kg = $this->total_kg; */
    }

    public function on_change_despacho(){
        $this->reset(['para_picar_id']);
        $this->resetValidation(['para_picar_id']);

        $this->calcular_total_kg();
    }

    public function calcular_total_kg(){
        if($this->despacho_id && $this->despacho_id !== ""){
            $this->despacho_actual = Despacho::where('id', $this->despacho_id)->first();
            $total_aprox = 0;
            if($this->despacho_actual && $this->despacho_actual->detalle_despachos){
                foreach ($this->despacho_actual->detalle_despachos as $value) {
                    if($value->materia_prima->unidad_medida == 'kg'){
                        $total_aprox += $value->cantidad_unidad;
                    } else if($value->materia_prima->unidad_medida == 'lb'){
                        $total_aprox += ($value->cantidad_unidad * $this->U_1LB_A_KG);
                    }
                }
            } 
            if($this->para_picar_id && $this->para_picar_id !== ""){
                $picacion = RegistroParaPicar::where('id', $this->para_picar_id)
                    ->where('estado', '<>', 0)
                    ->first();
                if($picacion){
                    $total_aprox += $picacion->cantidad_kg;
                }
            }
            $this->total_kg = round( floatval($total_aprox), 2);
            if($this->operation == 'create_proccess_preparation'){
                $this->disponible_kg = $this->total_kg;
            } else if($this->operation == 'edit_proccess_preparation'){
                $buscar = ProcesoPreparacion::where('id', $this->edit_id_proceso_preparacion)->where('estado', '<>', 0)->first();
                if($buscar){
                    # calcular
                    if($this->para_picar_id && $this->para_picar_id !== ""){
                        # sumar
                        $picacion = RegistroParaPicar::where('id', $this->para_picar_id)->where('estado', '<>', 0)->first();
                        if($picacion){
                            $this->disponible_kg = $buscar->registro_para_picar? 
                                $buscar->disponible_kg - $buscar->registro_para_picar->cantidad_kg + $picacion->cantidad_kg:
                                $this->disponible_kg + $picacion->cantidad_kg;
                        }
                    } else {
                        # restar
                        $this->disponible_kg = $buscar->registro_para_picar? 
                            $this->disponible_kg - $buscar->registro_para_picar->cantidad_kg:
                            $buscar->disponible_kg;
                    }
                }
            }
        } else {
            if($this->operation == "create_proccess_preparation"){
                $this->reset([
                    'total_kg',
                    'disponible_kg'
                ]);
                $this->despacho_actual = null;
            } else if($this->operation == "edit_proccess_preparation"){
                $this->reset([
                    'total_kg',
                ]); 
                $this->despacho_actual = null;
            }
        }
    }
    
    private function get_registros_para_picar(){
        if(($this->despacho_actual && ($this->operation=='create_proccess_preparation' || $this->operation=='edit_proccess_preparation') && $this->despacho_id !== "") ){

            $para_picar_no_referenciados = DB::table('registro_para_picar')
                ->leftJoin('proceso_preparacion', function ($join) {
                    $join->on('proceso_preparacion.recepcion_para_picar_id', '=', 'registro_para_picar.id')
                        ->where('proceso_preparacion.estado', '<>', 0);
                })
                #->where('registro_para_picar.estado', '<>', 0)
                ->where('registro_para_picar.sabor', $this->despacho_actual->sabor)
                ->whereDate('registro_para_picar.fecha_fin', '<', $this->fecha)
                
                ->where(function ($query) {
                    $query->whereNull('proceso_preparacion.id')
                        ->orWhere('proceso_preparacion.id', $this->edit_id_proceso_preparacion);
                })
                ->select('registro_para_picar.*')
                ->get();
            $this->emit('mensaje', 'es '. json_encode($para_picar_no_referenciados));

            $lista = [];
            foreach($para_picar_no_referenciados as $tmp){
                $lista[] = $tmp->id;
            }

            $segundo = RegistroParaPicar::where('estado', '<>', 0)
                ->whereIn('id', $lista);

            return $segundo->get();
        }
        return [];
    }

    /* *********************************************************** */

    public $edit_id_proceso_preparacion;
    public function rulesForEditProcessPreparation(){
        return [
            'edit_id_proceso_preparacion' => 'required|exists:proceso_preparacion,id',
            'codigo' => [
                'required',
                'string',
                Rule::unique('proceso_preparacion', 'codigo')->ignore($this->edit_id_proceso_preparacion),
                'min:10',
                'max:100'
            ],
            'fecha' => 'required|date',
            'total_kg' => 'required|numeric|min:0.1',
            'disponible_kg' => 'required|numeric|min:0',
            'despacho_id' => 'required',
            'para_picar_id' => 'nullable|exists:registro_para_picar,id',
            'observacion' => 'nullable|string|max:255',
        ];
    }

    public function open_modal_edit_prep_proceso($id){
        $this->close_modal_crear_prep_proceso();
        $proce_preparacion = ProcesoPreparacion::where('id', $id)->where('estado', '<>', 0)->first();
        if($proce_preparacion){
            $this->edit_id_proceso_preparacion = $proce_preparacion->id;
            $this->codigo = $proce_preparacion->codigo;
            $this->fecha = $proce_preparacion->fecha;
            $this->total_kg = $proce_preparacion->total_kg;
            $this->disponible_kg = $proce_preparacion->disponible_kg;
            $this->despacho_id = $proce_preparacion->despacho_id;
            $this->para_picar_id = $proce_preparacion->recepcion_para_picar_id;
            $this->observacion = $proce_preparacion->observacion;
            $this->operation = "edit_proccess_preparation";
            $this->calcular_total_kg();
        }
    }

    public function store_modal_editar_prep_proceso(){
        if($this->operation=='edit_proccess_preparation'){
            $this->validate();
            try {
                DB::beginTransaction();

                // actualizar
                $proceso_preparacion = ProcesoPreparacion::where('id', $this->edit_id_proceso_preparacion)->first();
                $proceso_preparacion->codigo = $this->codigo;
                $proceso_preparacion->fecha = $this->fecha;
                $proceso_preparacion->despacho_id = $this->despacho_id;
                $proceso_preparacion->recepcion_para_picar_id = (is_null($this->para_picar_id) || $this->para_picar_id=="")? null: $this->para_picar_id;
                $proceso_preparacion->total_kg = $this->total_kg;
                $proceso_preparacion->disponible_kg = $this->disponible_kg;
                $proceso_preparacion->observacion = is_null($this->observacion) ? '' : $this->observacion;
                $proceso_preparacion->id_user = Auth::id();

                $proceso_preparacion->save();

                DB::commit();
                $this->emit('success', 'Se ha actualizado exitosamente la preparación');
                $this->close_modal_crear_prep_proceso();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al intentar actuallizar la preparación. ' . $e->getMessage());
            }
        }
    }

    /* *********************************************************** */

    public $adm_proceso_preparacion;
    public $id_proceso_preparacion;
    public $nro_balde;
    public $kg_balde;
    public $d_fecha;
    public $d_observacion;
    public $detalles_procesos = [];
    public function rulesForAdminProcessPreparation(){
        $max_kg = ($this->adm_proceso_preparacion)? $this->adm_proceso_preparacion->disponible_kg: 0;
        return [
            'id_proceso_preparacion' => 'required|integer',
            'nro_balde' => 'required|integer|min:1',
            'kg_balde' => 'required|numeric|min:.1',
            // 'kg_balde' => 'required|numeric|min:.1'. '|max:'.$max_kg,

            'd_observacion' => 'nullable|max:255',
            'd_fecha' => 'required|date'
        ];
    }

    public $lista_de_nro_baldes = [];

    public function open_modal_admin_prep_proceso($id_proceso_preparacion){
        $this->close_modal_admin_prep_proceso();
        $this->adm_proceso_preparacion = ProcesoPreparacion::where('id', $id_proceso_preparacion)->first();
        if($this->adm_proceso_preparacion){
            $this->id_proceso_preparacion = $this->adm_proceso_preparacion->id;
            $this->operation = 'admin_proccess_preparation';
            $this->restore_detalles_baldes();
            $this->actuaizar_lista_detalle_procesos();
        }
        $this->d_fecha = Carbon::now()->isoFormat('YYYY-MM-DD');
    }

    public function close_modal_admin_prep_proceso(){
        $this->operation = '';
        $this->reset([
            'id_proceso_preparacion',
            'd_fecha'
        ]);
        $this->adm_proceso_preparacion = null;
        $this->detalles_procesos = [];
        $this->resetValidation();
    }

    private function listar_numero_baldes_disponibles(){
        // ATTRIBUTO DE MAXIMOS BALDES
        $max = 30;
        $this->lista_de_nro_baldes = [];
        if($this->adm_proceso_preparacion){
            $detalles = DetalleProcesoPreparacion::where('proceso_preparacion_id', $this->id_proceso_preparacion)
                ->where('estado', 1)->get();
            for($i=1; $i<=$max; $i++){
                array_push($this->lista_de_nro_baldes, $i );
            }
            #$ocupados = [];
            foreach ($detalles as $value) {
                $idx = array_search( $value->nro_balde, $this->lista_de_nro_baldes);
                if($idx!==false){
                    /* $this->lista_de_nro_baldes = */ array_splice($this->lista_de_nro_baldes, $idx, 1);
                }
                #array_push($ocupados, $value->nro_balde );
                //array_diff($this->lista_de_nro_baldes, array($value->nro_balde));
                //$this->emit('mensaje', 'es'. gettype($value->nro_balde). '='. gettype($this->lista_de_nro_baldes[0]));
            }
            /* if(count($ocupados) > 0){
                $this->lista_de_nro_baldes = array_diff($this->lista_de_nro_baldes, $ocupados);
            } */
            #$this->emit('mensaje', 'arr is'. var_dump($this->lista_de_nro_baldes));
            if(count($this->lista_de_nro_baldes) > 0){
                $this->nro_balde = $this->lista_de_nro_baldes[0];
            }
        }
    }

    private function actuaizar_lista_detalle_procesos(){
        if($this->adm_proceso_preparacion){
            $this->detalles_procesos = DetalleProcesoPreparacion::where('proceso_preparacion_id', $this->adm_proceso_preparacion->id)
                ->where('estado', '<>', 0)->get();
        }
    }

    public function restore_detalles_baldes(){
        $this->reset([
            'nro_balde',
            'kg_balde',
            'd_observacion'
        ]);
        $this->d_fecha = Carbon::now()->isoFormat('YYYY-MM-DD');
        $this->resetValidation();
        $this->listar_numero_baldes_disponibles();
    }

    public function save_detalle_proceso_preparacion(){
        if($this->operation == 'admin_proccess_preparation'){
            $this->validate();
            try{
                DB::beginTransaction();
                $detalle_proceso_preparacion = new DetalleProcesoPreparacion();
                $detalle_proceso_preparacion->nro_balde = $this->nro_balde;
                $detalle_proceso_preparacion->kg_balde = round($this->kg_balde, 2);
                $detalle_proceso_preparacion->fecha = $this->d_fecha;
                $detalle_proceso_preparacion->observacion = is_null($this->d_observacion)? '': $this->d_observacion;
                $detalle_proceso_preparacion->proceso_preparacion_id = $this->adm_proceso_preparacion->id;
                $detalle_proceso_preparacion->id_user = Auth::id();
                $detalle_proceso_preparacion->save();

                $proceso_prep = ProcesoPreparacion::where('id', $this->adm_proceso_preparacion->id)->first();
                $proceso_prep->disponible_kg = round( $proceso_prep->disponible_kg - $detalle_proceso_preparacion->kg_balde, 2);
                $proceso_prep->save();

                $this->adm_proceso_preparacion->disponible_kg = $proceso_prep->disponible_kg;
                DB::commit();
                $this->emit('success', 'Se ha creado exitosamente el registro del tacho');
                $this->restore_detalles_baldes();
                $this->actuaizar_lista_detalle_procesos();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al crear la nuevo tacho. '. $e->getMessage());
            }
        }
    }

    public function delete_detalle_proceso_preparacion($id){
        $detalle_proceso_preparacion = DetalleProcesoPreparacion::where('id', $id)->first();
        if($detalle_proceso_preparacion){
            try{
                DB::beginTransaction();
                $detalle_proceso_preparacion->estado = 0;
                $detalle_proceso_preparacion->save();

                $proceso_prep = ProcesoPreparacion::where('id', $this->adm_proceso_preparacion->id)->first();
                $proceso_prep->disponible_kg = round( $proceso_prep->disponible_kg + $detalle_proceso_preparacion->kg_balde, 2);
                $proceso_prep->save();

                $this->adm_proceso_preparacion->disponible_kg = $proceso_prep->disponible_kg;
                DB::commit();
                $this->emit('success', 'Se ha eliminado el tacho exitosamente.');
                $this->restore_detalles_baldes();
                $this->actuaizar_lista_detalle_procesos();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al eliminar tacho. '. $e->getMessage());
            }
        }
    }

    /* ********************** END RULES ************************** */
    public $det_proceso_preparacion = null;

    public function open_modal_show_prep_proceso($id_proceso_preparacion){
        $this->close_modal_admin_prep_proceso();
        $this->det_proceso_preparacion = ProcesoPreparacion::where('id', $id_proceso_preparacion)->first();
        if($this->det_proceso_preparacion){
            $this->operation = 'view_proccess_preparation';
        }
    }

    public function close_modal_show_prep_proceso(){
        $this->operation = '';
        $this->det_proceso_preparacion = null;
    }
    /* *********************************************************** */

    private function generarCodigoProceso()
    {
        $fechaActual = Carbon::now();
        $dia = $fechaActual->format('d');
        $mes = strtoupper($fechaActual->format('M'));
        $anio = $fechaActual->format('Y');

        $ultimoProceso = ProcesoPreparacion::whereDate('created_at', $fechaActual->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimoProceso) {
            $ultimoCodigo = $ultimoProceso->codigo;
            $partes = explode('-', $ultimoCodigo);
            $numeroProceso = (int) $partes[1] + 1;
        } else {
            $numeroProceso = 1;
        }

        return "PR-{$numeroProceso}-{$dia}-{$mes}-{$anio}";
    }

    public function eliminar_proceso_preparacion($id){
        $proceso_prep = ProcesoPreparacion::where('id', $id)->first();
        if($proceso_prep){
            $proceso_prep->estado = 0;
            $proceso_prep->save();
            $this->emit('success', 'Se ha eliminado exitosamente un proceso de preparación');
        }
    }

    public function restaurar_proceso_preparacion($id){
        $proceso_prep = ProcesoPreparacion::where('id', $id)->first();
        if($proceso_prep){
            $proceso_prep->estado = 1;
            $proceso_prep->save();
            $this->emit('success', 'Se ha restaurado exitosamente un proceso de preparación');
        }
    }
}
