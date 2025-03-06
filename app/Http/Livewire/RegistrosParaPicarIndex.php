<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\RegistroParaPicar;
use App\Models\DetalleRegistroParaPicar;
use App\Models\ProductosEnvasados;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RegistrosParaPicarIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'eliminar_registro_para_picar',
        'eliminar_detalle_registr_para_picar'
    ];

    public $LISTA_DE_SABORES = [];
    public function mount(){
        $this->LISTA_DE_SABORES = include(app_path(). '/dataCustom/sabores.php');
    }

    public function render()
    {
        return view('livewire.registros-para-picar-index', [
            'registros_para_picar' => $this->get_data(),
            'usuarios' => $this->get_data_users(),
            'registros_detalles_para_picar' => $this->get_data_para_picar_adm(),
            'lista_disponibles_productos_envasados' => $this->get_data_disponible_prod_envasados()
        ]);
    }

    private function get_data(){
        $registros = RegistroParaPicar::where('estado', '<>', 0)
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(5);
        return $registros;
    }

    private function get_data_users(){
        $usuarios = User::where('estado', '<>', 0)->get();
        return $usuarios;
    }

    /* ********************** INIT RULES ************************** */
    public $operation = '';

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    protected function rules(){
        if($this->operation=='create_registro_picar'){
            return $this->rulesForCreatePicar();
        } else if($this->operation=='edit_registro_picar'){
            return $this->rulesForEditPicar();
        } else if($this->operation=='adm_para_picar'){
            return $this->rulesForAdmParaPicar();
        } else if($this->operation=='adm_para_picar_create'){
            return $this->rulesForCreateDetalleRegistroParaPicar();
        } elseif($this->operation=='adm_para_picar_edit'){
            return $this->rulesForEditDetalleRegistroParaPicar();
        }
        return array_merge(
            $this->rulesForCreatePicar(),
            $this->rulesForEditPicar(),
            $this->rulesForAdmParaPicar(),
            $this->rulesForCreateDetalleRegistroParaPicar(),
            $this->rulesForEditDetalleRegistroParaPicar()
        );
    }

    /* ************************************************************ */
    public $codigo;
    public $sabor;
    public $observacion;
    public $encargado_id;
    public $fecha_inicio;
    public $fecha_fin;  

    public function rulesForCreatePicar(){
        return [
            'codigo' => 'required|unique:registro_para_picar,codigo|min:10',
            'sabor' => 'required|string',
            'observacion' => 'nullable|string|max:255',
            'encargado_id' => 'required|exists:users,id',
            'fecha_inicio' => 'required|date|after_or_equal:2000-01-01',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:'. now()->parse($this->fecha_inicio)->addDays(6)->format('Y-m-d')
        ];
    }

    public function open_modal_create_picar(){
        $this->close_modal_create_picar();
        $this->operation = 'create_registro_picar';
        $fechaAct = Carbon::now();
        $ultimaEntrega = RegistroParaPicar::whereDate('created_at', $fechaAct->toDateString())
            ->orderBy('id', 'desc')
            ->first();
        $numeroEntrega = $ultimaEntrega ? ((int) explode('-', $ultimaEntrega->codigo)[1] + 1) : 1;

        $this->codigo = "PIC-{$numeroEntrega}-{$fechaAct->locale('es')->isoFormat('DD-MMM-Y')}";
        $this->encargado_id = Auth::id();

        // Configurar Carbon para que el lunes sea el primer día de la semana
        Carbon::setWeekStartsAt(Carbon::MONDAY); # primer día Lunes
        Carbon::setWeekEndsAt(Carbon::SUNDAY); # ultimo dia, Domingo
        $this->fecha_inicio = $fechaAct->copy()->startOfWeek()->isoFormat('YYYY-MM-DD'); # obtener el dia lunes $fechaAct->isoFormat('YYYY-MM-DD');
        $this->fecha_fin = $fechaAct->copy()->startOfWeek()->addDays(5)->isoFormat('YYYY-MM-DD'); # obtener el día sabado
    }

    public function save_modal_create_picar(){
        if($this->operation == 'create_registro_picar'){
            $this->validate();
            try{
                DB::beginTransaction();
                $para_picar = new RegistroParaPicar();
                $para_picar->codigo = $this->codigo;
                $para_picar->sabor = $this->sabor;
                $para_picar->observacion = $this->observacion;
                $para_picar->encargado_id = $this->encargado_id;
                $para_picar->user_id = Auth::id();
                $para_picar->fecha_inicio = $this->fecha_inicio;
                $para_picar->fecha_fin = $this->fecha_fin;
                $para_picar->save();

                DB::commit();
                $this->emit('success', 'Se ha creado exitosamente un nuevo registro para picar.');
                $this->close_modal_create_picar();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al intentar crear registro para picar. '. $e->getMessage());
            }
        }
    }

    public function close_modal_create_picar(){
        $this->operation = '';
        $this->reset([
            'codigo',
            'sabor',
            'observacion',
            'encargado_id',
            'fecha_inicio',
            'fecha_fin'
        ]);
        $this->resetValidation();
    }

    public function updatedFechaInicio(){
        # se ejcuta cuando no haya errores en fecha inicio
        $fecha = Carbon::parse($this->fecha_inicio);

        // Configurar Carbon para que el lunes sea el primer día de la semana
        Carbon::setWeekStartsAt(Carbon::MONDAY); # primer día Lunes
        Carbon::setWeekEndsAt(Carbon::SUNDAY); # ultimo dia, Domingo

        $this->fecha_fin = $fecha->copy()->startOfWeek()->addDays(5)->isoFormat('YYYY-MM-DD'); # obtener el día sabado
    }

    /* *********************************************************** */
    public $edit_registro_para_picar_id;
    public $edit_codigo;
    public $edit_sabor;
    public $edit_observacion;
    public $edit_encargado_id;
    public $edit_fecha_inicio;
    public $edit_fecha_fin;

    public $edit_registro_para_picar;

    public function rulesForEditPicar(){
        return [
            'edit_registro_para_picar_id' => 'required|exists:registro_para_picar,id',
            'edit_codigo' => [
                'required',
                Rule::unique('registro_para_picar', 'codigo')->ignore($this->edit_registro_para_picar_id),
                'min:10'
            ],
            'edit_sabor' => 'required|string',
            'edit_observacion' => 'nullable|string|max:255',
            'edit_encargado_id' => 'required|exists:users,id',
            'edit_fecha_inicio' => 'required|date|after_or_equal:2000-01-01',
            'edit_fecha_fin' => 'required|date|after_or_equal:fecha_inicio|before_or_equal:'. now()->parse($this->fecha_inicio)->addDays(6)->format('Y-m-d')
        ];
    }

    public function open_modal_edit_picar($id){
        $this->close_modal_edit_picar();
        $this->edit_registro_para_picar = RegistroParaPicar::where('id', $id)->first();
        if($this->edit_registro_para_picar){
            $this->edit_registro_para_picar_id = $this->edit_registro_para_picar->id;
            $this->edit_codigo = $this->edit_registro_para_picar->codigo;
            $this->edit_sabor = $this->edit_registro_para_picar->sabor;
            $this->edit_observacion = $this->edit_registro_para_picar->observacion;
            $this->edit_encargado_id = $this->edit_registro_para_picar->encargado_id;
            $this->edit_fecha_inicio = $this->edit_registro_para_picar->fecha_inicio;
            $this->edit_fecha_fin = $this->edit_registro_para_picar->fecha_fin;
            $this->operation = 'edit_registro_picar';
        }
    }

    public function close_modal_edit_picar(){
        $this->operation = '';
        $this->reset([
            'edit_registro_para_picar_id',
            'edit_codigo',
            'edit_sabor',
            'edit_observacion',
            'edit_encargado_id',
            'edit_fecha_inicio',
            'edit_fecha_fin'
        ]);
        $this->edit_registro_para_picar = null;
        $this->resetValidation();
    }

    public function save_modal_edit_picar(){
        if($this->operation == 'edit_registro_picar'){
            $this->validate();
            try{
                DB::beginTransaction();
                $para_picar = RegistroParaPicar::where('id', $this->edit_registro_para_picar_id)->first();
                $para_picar->codigo = $this->edit_codigo;
                $para_picar->sabor = $this->edit_sabor;
                $para_picar->observacion = $this->edit_observacion;
                $para_picar->encargado_id = $this->edit_encargado_id;
                $para_picar->user_id = Auth::id();
                $para_picar->fecha_inicio = $this->edit_fecha_inicio;
                $para_picar->fecha_fin = $this->edit_fecha_fin;
                $para_picar->save();

                DB::commit();
                $this->emit('success', 'Se ha actualizado exitosamente un nuevo registro para picar.');
                $this->close_modal_create_picar();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al intentar axtualizar registro para picar. '. $e->getMessage());
            }
        }
    }

    /* *********************************************************** */

    public $para_picar_adm = null;
    public $para_picar_adm_id;

    public function rulesForAdmParaPicar(){
        return [
            'para_picar_adm_id' => 'required|exists:registro_para_picar,id',
        ];
    }

    public function open_modal_para_picar_adm($id){
        $this->close_modal_para_picar_adm();
        $this->para_picar_adm = RegistroParaPicar::where('id', $id)->first();
        if($this->para_picar_adm){
            $this->operation = 'adm_para_picar';
            $this->para_picar_adm_id = $this->para_picar_adm->id;
        }
    }

    public function close_modal_para_picar_adm(){
        $this->operation = '';
        $this->reset([
            'para_picar_adm_id'
        ]);
        $this->resetValidation();
    }

    private function get_data_para_picar_adm(){
        if($this->operation == 'adm_para_picar' && $this->para_picar_adm_id){
            return DetalleRegistroParaPicar::where('detalle_registro_para_picar.registro_para_picar_id', $this->para_picar_adm_id)
                ->where('estado', '<>', 0)->get();
        } else {
            return [];
        }
    }

    public function eliminar_detalle_registr_para_picar($id){
        $det_registro_para_picar = DetalleRegistroParaPicar::where('id', $id)->first();
        if($this->operation == "adm_para_picar" && $det_registro_para_picar){
            $det_registro_para_picar->estado = 0;
            $det_registro_para_picar->save();
            $this->emit('success', 'Se ha eliminado exitosamente el detalle registro para picar');
        }
    }

    /* *********************************************************** */
    public $detalle_reg_prod_envasado_id;
    public $detalle_reg_observacion;
    public $detalle_reg_show_prod_env;

    public function rulesForCreateDetalleRegistroParaPicar(){
        return [
            'para_picar_adm_id' => 'required|exists:registro_para_picar,id',
            'detalle_reg_prod_envasado_id' => 'required|exists:productos_envasados,id',
            'detalle_reg_observacion' => 'nullable|string|max:255',
        ];
    }

    public function open_modal_create_detalle_para_picar(){
        $this->close_modal_create_detalle_para_picar();
        $this->operation = 'adm_para_picar_create';
    }

    public function close_modal_create_detalle_para_picar(){
        $this->operation = 'adm_para_picar';
        $this->reset([
            'detalle_reg_prod_envasado_id',
            'detalle_reg_observacion'
        ]);
        $this->resetValidation();
        $this->detalle_reg_show_prod_env = null;
    }

    public function save_modal_create_detalle_para_picar(){
        if($this->operation == 'adm_para_picar_create'){
            $this->validate();
            try{
                DB::beginTransaction();
                $detalle_para_picar = new DetalleRegistroParaPicar();
                $detalle_para_picar->producto_envasado_id = $this->detalle_reg_prod_envasado_id;
                $detalle_para_picar->registro_para_picar_id = $this->para_picar_adm_id;
                $detalle_para_picar->observacion = $this->detalle_reg_observacion;
                $detalle_para_picar->user_id = Auth::id();
                $detalle_para_picar->save();

                DB::commit();
                $this->emit('success', 'Se ha creado exitosamente un nuevo detalle de registro para picar.');
                $this->close_modal_create_detalle_para_picar();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al intentar crear detalle de registro para picar. '. $e->getMessage());
            }
        }
    }

    public function updatedDetalleRegProdEnvasadoId(){
        $this->detalle_reg_show_prod_env = ProductosEnvasados::where('id', $this->detalle_reg_prod_envasado_id)
            ->where('estado', '<>', 0)->first();
    }
    private function get_data_disponible_prod_envasados(){
        if($this->para_picar_adm && ($this->operation=='adm_para_picar_create' || $this->operation=='adm_para_picar_edit') ){
            $primero = DetalleRegistroParaPicar::select('productos_envasados.id', 'detalle_registro_para_picar.id AS id_detalle')
                ->join('productos_envasados', 'productos_envasados.id', '=', 'detalle_registro_para_picar.producto_envasado_id')
                ->join('registro_para_picar', 'registro_para_picar.id', '=', 'detalle_registro_para_picar.registro_para_picar_id')
                ->where('productos_envasados.sabor', $this->para_picar_adm->sabor)
                ->where('productos_envasados.fecha', '>=', $this->para_picar_adm->fecha_inicio)
                ->where('productos_envasados.fecha', '<=', $this->para_picar_adm->fecha_fin)
                ->where('productos_envasados.para_picar', 1)
                ->where(function($query){
                    $query->where('detalle_registro_para_picar.estado', '<>', 0)
                    ->where('productos_envasados.estado', '<>', 0)
                    ->where('registro_para_picar.estado', '<>', 0);
                })
                ->get();
            $lista = [];
            foreach($primero as $det){
                if($this->operation=='adm_para_picar_edit'){
                    if($this->edit_detalle_reg_id !== $det->id_detalle){
                        $lista[] = $det->id;
                    }
                } else {
                    $lista[] = $det->id;
                }
            }
            $this->emit('mensaje', 'es'. json_encode($this->para_picar_adm));

            $segundo = ProductosEnvasados::where('estado', '<>', 0)
                ->where('sabor', $this->para_picar_adm->sabor)
                ->where('fecha', '>=', $this->para_picar_adm->fecha_inicio)
                ->where('fecha', '<=', $this->para_picar_adm->fecha_fin)
                ->where('para_picar', 1);
            #if(count($lista) > 0){
                $segundo->whereNotIn('id', $lista);
            #}
            
            return $segundo->get();
        } else {
            return [];
        }
    }

    /* *********************************************************** */
    public $edit_detalle_reg_id;
    public $edit_detalle_reg_prod_envasado_id;
    public $edit_detalle_reg_observacion;

    public $edit_detalle_reg_show_prod_env;
    public $edit_detalle_registro_producto;

    public function rulesForEditDetalleRegistroParaPicar(){
        return [
            'edit_detalle_reg_id' => 'required|exists:detalle_registro_para_picar,id',
            'para_picar_adm_id' => 'required|exists:registro_para_picar,id',
            'edit_detalle_reg_prod_envasado_id' => 'required|exists:productos_envasados,id',
            'edit_detalle_reg_observacion' => 'nullable|string|max:255',
        ];
    }

    public function open_modal_edit_detalle_para_picar($id){
        $this->close_modal_edit_detalle_para_picar();
        $this->edit_detalle_registro_producto = DetalleRegistroParaPicar::where('id', $id)->first();
        if($this->edit_detalle_registro_producto){
            $this->edit_detalle_reg_id = $this->edit_detalle_registro_producto->id;
            $this->edit_detalle_reg_prod_envasado_id = $this->edit_detalle_registro_producto->producto_envasado_id;
            $this->edit_detalle_reg_observacion = $this->edit_detalle_registro_producto->observacion;
            $this->operation = 'adm_para_picar_edit';
            $this->updatedEditDetalleRegProdEnvasadoId();
        }
    }

    public function close_modal_edit_detalle_para_picar(){
        $this->operation = 'adm_para_picar';
        $this->reset([
            'edit_detalle_reg_id',
            'edit_detalle_reg_prod_envasado_id',
            'edit_detalle_reg_observacion'
        ]);
        $this->resetValidation();
        $this->edit_detalle_reg_show_prod_env = null;
        $this->edit_detalle_registro_producto = null;
    }

    public function save_modal_edit_detalle_para_picar(){
        if($this->operation == 'adm_para_picar_edit'){
            $this->validate();
            try{
                DB::beginTransaction();
                $detalle_para_picar = DetalleRegistroParaPicar::where('id', $this->edit_detalle_reg_id)->first();
                $detalle_para_picar->producto_envasado_id = $this->edit_detalle_reg_prod_envasado_id;
                $detalle_para_picar->registro_para_picar_id = $this->para_picar_adm_id;
                $detalle_para_picar->observacion = $this->edit_detalle_reg_observacion;
                $detalle_para_picar->user_id = Auth::id();
                $detalle_para_picar->save();

                DB::commit();
                $this->emit('success', 'Se ha actualizado exitosamente el detalle de registro para picar.');
                $this->close_modal_create_detalle_para_picar();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al intentar actualizado detalle de registro para picar. '. $e->getMessage());
            }
        }
    }

    public function updatedEditDetalleRegProdEnvasadoId(){
        $this->edit_detalle_reg_show_prod_env = ProductosEnvasados::where('id', $this->edit_detalle_reg_prod_envasado_id)
            ->where('estado', '<>', 0)->first();
    }

    /* ********************** END RULES ************************** */

    public function eliminar_registro_para_picar($id){
        $registro_para_picar = RegistroParaPicar::where('id', $id)->first();
        if($registro_para_picar){
            $registro_para_picar->estado = 0;
            $registro_para_picar->save();
            $this->emit('success', 'Se ha eliminado exitosamente el registro para picar');
        }
    }

}
