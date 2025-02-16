<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\ProductosEnvasados;
use App\Models\SalidasDeMolino;
use App\Models\Maquina;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ProductoEnvasadoIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'eliminar_producto_envasado',
        'quitar_salida_molino'
    ];

    public $LISTA_DE_SABORES = [];
    public function mount(){
        $this->fechaActual = Carbon::now();#->isoFormat('YYYY-MM-DD');
        $this->anio = $this->fechaActual->isoFormat('YYYY');
        $this->mes = $this->fechaActual->isoFormat('MM');
        $this->dia = $this->fechaActual->isoFormat('DD');

        $this->statusMes = $this->statusDia = true;

        $this->LISTA_DE_SABORES = include(app_path(). '/dataCustom/sabores.php');
    }

    public function render()
    {
        #$this->actualiza_fecha();
        $maquinas = Maquina::where('estado', '<>', 0)->get();
        $usuarios = User::where('tipo', 2)->get();
        return view('livewire.producto-envasado-index', [
            'productos_envasados' => $this->get_data(),
            'list_anio' => $this->get_gestiones(),
            'list_mes' => $this->get_meses(),
            'list_dias' => $this->get_dias(),
            'baldes_anteriores' => $this->get_baldes_anteriores(),
            'salidas_molinos' => $this->get_disponibles_salidas_de_molino(),
            'current_salidas_molinos' => $this->get_current_balde_salidas_molinos(),
            'maquinas' => $maquinas,
            'usuarios' => $usuarios
        ]);
    }

    private function actualiza_fecha(){
        $this->fechaActual = Carbon::now();#->isoFormat('YYYY-MM-DD');
        $this->anio = $this->fechaActual->isoFormat('YYYY');
        $this->mes = $this->fechaActual->isoFormat('MM');
        $this->dia = $this->fechaActual->isoFormat('DD');
    }

    private function get_data(){
        $productos_envasados = ProductosEnvasados::where('estado', '<>', 0);
        if(!is_null($this->anio) && $this->anio !== "") {
            $productos_envasados->where( DB::raw("DATE_FORMAT(fecha, '%Y')"), $this->anio);
            if(!is_null($this->mes) && $this->mes !== ""){
                $productos_envasados->where( DB::raw("DATE_FORMAT(fecha, '%m')"), $this->mes);
                if(!is_null($this->dia) && $this->dia !== ""){
                    $productos_envasados->where( DB::raw("DATE_FORMAT(fecha, '%d')"), $this->dia);
                }
            }
        }
        $productos_envasados->orderBy('fecha', 'DESC');
        return $productos_envasados->paginate(10);
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
        $gestionActual = $this->fechaActual->isoFormat('YYYY');
        $gestiones = ProductosEnvasados::select(
            DB::raw("DATE_FORMAT(fecha, '%Y') as anio")
        )
        ->union(
            DB::table(DB::raw("(SELECT '{$gestionActual}' as anio) as temporal"))
        )
        ->distinct()
        ->orderBy('anio')
        ->get();

        return $gestiones;
    }

    public function get_meses(){
        if($this->anio !== ""){
            $mesTemporal = $this->fechaActual->isoFormat('MM');
            $meses = ProductosEnvasados::select(
                DB::raw("DATE_FORMAT(fecha, '%m') as mes")
            )
            ->union(
                DB::table(DB::raw("(SELECT '{$mesTemporal}' as mes) as temporal"))
            )
            ->distinct()
            ->orderBy('mes');

            if(!is_null($this->anio) && $this->anio !== ""){
                $meses->where( DB::raw("DATE_FORMAT(fecha, '%Y')"), $this->anio);
            }
        return $meses->get();
        } else {
            return [];
        }
    }

    public function get_dias(){
        #$inicio = Carbon::createFromDate($this->fechaActual->isoFormat('YYYY'), $this->fechaActual->isoFormat('MM'), 1);
        if($this->anio !== "" && $this->mes!== ""){
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
        } else{
            return [];
        }
    }

    /* ********************** INIT RULES ************************** */
    public $operation = '';

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    protected function rules(){
        if($this->operation=='create_producto'){
            return $this->rulesForCreate();
        }
        if($this->operation=='edit_baldes'){
            return $this->rulesForEditBalde();
        } else if($this->operation=='edit_cajas'){
            return $this->rulesForEditCaja();
        }
        return array_merge(
            $this->rulesForCreate(),
            $this->rulesForEditBalde(),
            $this->rulesForEditCaja()
        );
    }

    /* ************************************************************ */
    public $codigo;
    public $fecha;
    public $maquina_id;
    public $nombre;
    public $sabor;
    public $observaciones;

    public function rulesForCreate(){
        return [
            'codigo' => 'required',
            'fecha' => 'required|date',
            'maquina_id' => 'required|exists:maquinas,id',
            'nombre' => 'nullable|exists:users,id',
            'sabor' => 'required|string',
            'observaciones' => 'nullable|string|max:255'
        ];
    }

    public function open_modal_crear_producto(){
        $this->close_modal_crear_producto();
        $this->operation = 'create_producto';
        $fechaAct = Carbon::now();
        $ultimaEntrega = ProductosEnvasados::whereDate('created_at', $fechaAct->toDateString())
            ->orderBy('id', 'desc')
            ->first();
        $numeroEntrega = $ultimaEntrega ? ((int) explode('-', $ultimaEntrega->codigo)[1] + 1) : 1;

        $this->codigo = "PROD-{$numeroEntrega}-{$fechaAct->locale('es')->isoFormat('DD-MMM-Y')}";
        $this->fecha = $fechaAct->isoFormat('YYYY-MM-DD');
    }

    public function close_modal_crear_producto(){
        $this->operation = '';
        $this->reset([
            'codigo',
            'fecha',
            'maquina_id',
            'nombre',
            'sabor',
            'observaciones'
        ]);
        $this->resetValidation();
    }

    public function save_modal_crear_producto(){
        if($this->operation == 'create_producto'){
            $this->validate();
            try {
                DB::beginTransaction();
                $prod_env = new ProductosEnvasados();
                $prod_env->codigo = $this->codigo;
                $prod_env->fecha = $this->fecha;
                $prod_env->sabor = $this->sabor;
                $prod_env->maquina_id = $this->maquina_id;
                $prod_env->encargado_id =$this->nombre;
                $prod_env->observacion = $this->observaciones;
                $prod_env->save();

                DB::commit();
                $this->emit('success', 'Se ha creado exitosamente el regsitro del producto envasado');
                $this->close_modal_crear_producto();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al crear la nuevo producot envasado. '. $e->getMessage());
            }
        }
    }

    public function rellenar_sugerido(){
        if($this->maquina_id!=='' && $this->fecha!==''){
            $salid_mol = SalidasDeMolino::where('fecha', $this->fecha)
                ->where('maquina_id', $this->maquina_id)->first();
            if($salid_mol){
                $this->sabor = $salid_mol->sabor;
                $this->nombre = $salid_mol->encargado_id;
            }
        }
    }


    /* ************************************************************ */

    public $producto_envasado_balde = null;
    public $balde_id;
    public $balde_saldo_anterior;
    public $balde_cambio_de_maquina;
    public $balde_entrada_de_molino;
    public $balde_sobro_del_dia;
    public $balde_observacion;
    public function rulesForEditBalde(){
        $balde_ant = 0;
        if(!is_null($this->balde_saldo_anterior) && $this->balde_saldo_anterior !==""){
            $balde_act = ProductosEnvasados::where('id', $this->balde_saldo_anterior)->first();
            if($balde_act){
                $balde_ant = $balde_act->balde_sobro_del_dia;
            }
        }
        $balde_max = round( floatval($balde_ant + $this->balde_entrada_de_molino), 2);
        return [
            'balde_id' => 'required|exists:productos_envasados,id',
            'balde_saldo_anterior' => 'nullable|exists:productos_envasados,id',
            'balde_cambio_de_maquina' => 'nullable',
            'balde_entrada_de_molino' => 'required|min:.1',
            'balde_sobro_del_dia' => 'nullable|numeric|min:0|max:' . $balde_max,
            'balde_observacion' => 'nullable|string|max:255'
        ];
    }

    public function open_modal_editar_baldes($id_prod){
        $this->close_modal_editar_balde();
        $this->producto_envasado_balde = ProductosEnvasados::where('id', $id_prod)->first();
        if($this->producto_envasado_balde){
            $this->balde_id = $this->producto_envasado_balde->id;
            $this->balde_saldo_anterior = $this->producto_envasado_balde->balde_saldo_anterior;
            $this->balde_cambio_de_maquina = null; #falta
            $total_entrada = 0;
            foreach($this->producto_envasado_balde->salidas_de_molino as $mols){
                $total_entrada += count($mols->detalle_salida_molinos);
            }
            $this->balde_entrada_de_molino = $total_entrada;
            $this->balde_sobro_del_dia = $this->producto_envasado_balde->balde_sobro_del_dia;
            $this->balde_observacion = $this->producto_envasado_balde->observacion;
        }
        $this->operation = 'edit_baldes';
    }

    public function close_modal_editar_balde(){
        $this->operation = '';
        $this->reset([
            'balde_id',
            'balde_saldo_anterior',
            'balde_cambio_de_maquina',
            'balde_entrada_de_molino',
            'balde_sobro_del_dia',
            'balde_observacion'
        ]);
        $this->producto_envasado_balde = null;
        $this->resetValidation();
        $this->limpiar_salida_molino();
    }

    public function save_modal_editar_balde(){
        if($this->operation == 'edit_baldes'){
            $this->validate();
            try{
                DB::beginTransaction();
                $producto_envasado = ProductosEnvasados::where('id', $this->balde_id)->first();
                $producto_envasado->balde_saldo_anterior = (is_null($this->balde_saldo_anterior) || $this->balde_saldo_anterior=="")? null: $this->balde_saldo_anterior;
                $producto_envasado->balde_sobro_del_dia = (!is_null($this->balde_sobro_del_dia) && $this->balde_sobro_del_dia!=="" )? round(floatval($this->balde_sobro_del_dia), 2): null;
                $producto_envasado->observacion = $this->balde_observacion;
                $producto_envasado->save();
                DB::commit();
                $this->emit('success', 'Se ha actualizado exitosamente datos del balde.');
                $this->close_modal_editar_balde();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al actualizar datos del balde. '. $e->getMessage());
            }
        }
    }

    private function get_baldes_anteriores(){
        if($this->operation == 'edit_baldes' && $this->producto_envasado_balde){
            # retorna los baldes anteriores a la fecha del actual
            $this->emit('mensaje', 'setas en correcto 22');
            return ProductosEnvasados::select(
                    'tabla_saldo.id',
                    'tabla_saldo.fecha',
                    'tabla_saldo.balde_sobro_del_dia',
                    'maquinas.nombre'
                )
                ->rightJoin('productos_envasados as tabla_saldo', 'productos_envasados.balde_saldo_anterior', '=', 'tabla_saldo.id')
                ->join('maquinas', 'tabla_saldo.maquina_id', '=', 'maquinas.id')
                ->where('tabla_saldo.estado', 2)
                ->where('tabla_saldo.fecha', '<', $this->producto_envasado_balde->fecha)
                ->where('tabla_saldo.sabor', $this->producto_envasado_balde->sabor)
                ->whereNotNull('tabla_saldo.balde_sobro_del_dia')
                ->where(function($query){
                    $query->whereNull('productos_envasados.balde_saldo_anterior')
                    ->orWhere('tabla_saldo.id', $this->producto_envasado_balde->balde_saldo_anterior);
                })
                #->whereNull('productos_envasados.balde_saldo_anterior')
                #->orWhere('tabla_saldo.id', $this->producto_envasado_balde->id)
                ->get();
            # funciona pero repite
            /* return ProductosEnvasados::where('estado', 2)
                ->where('fecha', '<', $this->producto_envasado_balde->fecha)
                ->where('sabor', $this->producto_envasado_balde->sabor)
                ->whereNotNull('balde_sobro_del_dia')
                #->whereNull('balde_saldo_anterior')
                ->get(); */
        } else {
            return [];
        }
    }

    private function get_disponibles_salidas_de_molino(){
        if($this->operation == 'edit_baldes' && $this->producto_envasado_balde){
            return SalidasDeMolino::select(
                'salidas_de_molino.id',
                'salidas_de_molino.codigo',
                'salidas_de_molino.fecha',
                'salidas_de_molino.turno',
                'salidas_de_molino.producto_envasado_id',
                'salidas_de_molino.observacion',
                DB::raw("(
                    SELECT COUNT(*)
                    FROM detalle_salidas_de_molino det_salida
                    JOIN detalle_proceso_preparacion det_proceso ON(det_proceso.id = det_salida.detalle_proceso_preparacion_id)
                    WHERE salidas_de_molino.id = det_salida.salida_de_molino_id
                        AND det_salida.estado <> 0
                        AND det_proceso.estado <> 0
                ) AS cantidad"),
                DB::raw("(
                    SELECT SUM(det_proceso.kg_balde)
                    FROM detalle_salidas_de_molino det_salida
                    JOIN detalle_proceso_preparacion det_proceso ON(det_proceso.id = det_salida.detalle_proceso_preparacion_id)
                    WHERE salidas_de_molino.id = det_salida.salida_de_molino_id
                        AND det_salida.estado <> 0
                        AND det_proceso.estado <> 0
                ) AS kgs")
            )
            ->leftJoin('productos_envasados', 'productos_envasados.id', '=', 'salidas_de_molino.producto_envasado_id')
            ->where('salidas_de_molino.estado', '<>', 0)
            ->where('salidas_de_molino.fecha', '<=', $this->producto_envasado_balde->fecha)
            ->where('salidas_de_molino.sabor', $this->producto_envasado_balde->sabor)
            ->where('salidas_de_molino.maquina_id', $this->producto_envasado_balde->maquina_id)
            ->whereNull('salidas_de_molino.producto_envasado_id')
            /* ->whereNotNull('tabla_saldo.balde_sobro_del_dia')
            ->where(function($query){
                $query->whereNull('salidas_de_molino.producto_envasado_id');
                ->orWhere('salidas_de_molino.id', $this->producto_envasado_balde->balde_saldo_anterior);
            }) */
           ->orderBy('salidas_de_molino.fecha', 'DESC')
            ->get();
        } else {
            return [];
        }
    }

    private function get_current_balde_salidas_molinos(){
        if($this->operation == 'edit_baldes' && $this->producto_envasado_balde){
            return SalidasDeMolino::where('producto_envasado_id', $this->producto_envasado_balde->id)
                ->where('estado', '<>', 0)
                ->orderBy('fecha', 'desc')
                ->get();
        } else {
            return [];
        }
    }

    public $balde_salida_molino_id;
    public function agregar_salida_molino(){
        $this->validate([
            'balde_salida_molino_id' => 'required|exists:salidas_de_molino,id'
        ]);
        try {
            $salida_molino = SalidasDeMolino::where('id', $this->balde_salida_molino_id)->first();
            $salida_molino->producto_envasado_id = $this->producto_envasado_balde->id;
            $salida_molino->id_user = Auth::id();
            $salida_molino->save();
            $this->emit('success', 'Se ha agregado exitosamente una salida de molino');
            $this->limpiar_salida_molino();
            $this->actualiza_entrada_de_molino();
        } catch(\Exception $e){
            $this->emit('error', 'Error al agregar salida de molino. '. $e->getMessage());
        }
    }

    public function quitar_salida_molino($id){
        try {
            $salida_molino = SalidasDeMolino::where('id', $id)->first();
            $salida_molino->producto_envasado_id = null;
            $salida_molino->id_user = Auth::id();
            $salida_molino->save();
            $this->emit('success', 'Se ha quitado exitosamente la salida de molino');
            $this->limpiar_salida_molino();
            $this->actualiza_entrada_de_molino();
        } catch(\Exception $e){
            $this->emit('error', 'Error al quitar salida de molino. '. $e->getMessage());
        }
    }

    public function limpiar_salida_molino(){
        $this->reset([
            'balde_salida_molino_id'
        ]);
        $this->resetValidation([
            'balde_salida_molino_id'
        ]);
    }

    private function actualiza_entrada_de_molino(){
        if($this->producto_envasado_balde){
            $prod_curr = ProductosEnvasados::where('id', $this->producto_envasado_balde->id)->first();
            if($prod_curr){
                $total = 0;
                foreach($prod_curr->salidas_de_molino as $sal_mol){
                    $total += count($sal_mol->detalle_salida_molinos);
                }
                $this->balde_entrada_de_molino = $total;
            }
        }
    }

    /* *********************** ********* ************************** */
    public $producto_envasado_caja = null;
    public $caja_id;
    public $caja_cajas;
    public $caja_bolsas;
    public $caja_observacion;
    public function rulesForEditCaja(){
        # calcular las cajas y bolsas
        return [
            'caja_id' => 'required|exists:productos_envasados,id',
            'caja_cajas' => 'nullable|integer|min:0',
            'caja_bolsas' => 'nullable|integer|min:0',
            'caja_observacion' => 'nullable|string|max:255'
        ];
    }

    public function open_modal_editar_caja($id_prod){
        $this->close_modal_editar_caja();
        $this->producto_envasado_caja = ProductosEnvasados::where('id', $id_prod)->first();
        if($this->producto_envasado_caja){
            $this->caja_id = $this->producto_envasado_caja->id;
            $this->caja_cajas = $this->producto_envasado_caja->caja_cajas;
            $this->caja_bolsas = $this->producto_envasado_caja->caja_bolsas;
            $this->caja_observacion = $this->producto_envasado_caja->observacion;
        }
        $this->operation = 'edit_cajas';
    }

    public function close_modal_editar_caja(){
        $this->operation = '';
        $this->reset([
            'caja_id',
            'caja_cajas',
            'caja_bolsas',
            'caja_observacion'
        ]);
        $this->producto_envasado_caja = null;
        $this->resetValidation();
    }

    public function save_modal_editar_caja(){
        if($this->operation == 'edit_cajas'){
            $this->validate();
            try{
                DB::beginTransaction();
                $producto_envasado = ProductosEnvasados::where('id', $this->caja_id)->first();
                $producto_envasado->caja_cajas = (is_null($this->caja_cajas) || $this->caja_cajas=="" || $this->caja_cajas == 0)? null: $this->caja_cajas;
                $producto_envasado->caja_bolsas = (!is_null($this->caja_bolsas) && $this->caja_bolsas!=="" && $this->caja_bolsas!==0 )? $this->caja_bolsas: null;
                $producto_envasado->observacion = $this->caja_observacion;
                $producto_envasado->save();
                DB::commit();
                $this->emit('success', 'Se ha actualizado exitosamente datos de caja.');
                $this->close_modal_editar_balde();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al actualizar datos de caja. '. $e->getMessage());
            }
        }
    }

    /* *********************** END RULES ************************** */

    public function confirmar_producto_envasado($id){
        if($this->operation == ""){
            try{
                DB::beginTransaction();
                $producto_envasado = ProductosEnvasados::where('id', $id)->first();
                $producto_envasado->estado = 2;
                $producto_envasado->save();
                DB::commit();
                $this->emit('success', 'Se ha confimado el producto envasado exitosamente.');
                #$this->close_modal_editar_balde();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al confirmar. '. $e->getMessage());
            }
        }
    }

    public function cambiar_estado($id){
        if($this->operation == ""){
            try{
                DB::beginTransaction();
                $producto_envasado = ProductosEnvasados::where('id', $id)->first();
                $producto_envasado->estado = $producto_envasado->estado==1? 2: 1;
                $producto_envasado->save();
                DB::commit();
                $this->emit('success', 'Se ha cambiado el estado del producto envasado exitosamente.');
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al cambiar estado. '. $e->getMessage());
            }
        }
    }
}
