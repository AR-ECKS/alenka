<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\ProductosEnvasados;
use App\Models\SalidasDeMolino;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ProductoEnvasadoIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'eliminar_producto_envasado'
    ];

    public function mount(){
        $this->fechaActual = Carbon::now();#->isoFormat('YYYY-MM-DD');
        $this->anio = $this->fechaActual->isoFormat('YYYY');
        $this->mes = $this->fechaActual->isoFormat('MM');
        $this->dia = $this->fechaActual->isoFormat('DD');

        $this->statusMes = $this->statusDia = true;
    }

    public function render()
    {
        #$this->actualiza_fecha();
        return view('livewire.producto-envasado-index', [
            'productos_envasados' => $this->get_data(),
            'list_anio' => $this->get_gestiones(),
            'list_mes' => $this->get_meses(),
            'list_dias' => $this->get_dias(),
            'baldes_anteriores' => $this->get_baldes_anteriores()
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
        #$productos_envasados;
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
        if($this->operation=='edit_baldes'){
            return $this->rulesForEditBalde();
        } else if($this->operation=='edit_cajas'){
            return $this->rulesForEditCaja();
        }
        return array_merge(
            $this->rulesForEditBalde(),
            $this->rulesForEditCaja()
        );
    }

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
            $this->balde_entrada_de_molino = $this->producto_envasado_balde->balde_entrada_de_molino;
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
                #->whereNull('productos_envasados.balde_saldo_anterior')
                #->orWhere('tabla_saldo.id', $this->producto_envasado_balde->id)
                ->get();
            # funciona pero repite
            return ProductosEnvasados::where('estado', 2)
                ->where('fecha', '<', $this->producto_envasado_balde->fecha)
                ->where('sabor', $this->producto_envasado_balde->sabor)
                ->whereNotNull('balde_sobro_del_dia')
                #->whereNull('balde_saldo_anterior')
                ->get();
        } else {
            return [];
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
                $this->close_modal_editar_balde();
            } catch(\Exception $e){
                DB::rollBack();
                $this->emit('error', 'Error al confirmar. '. $e->getMessage());
            }
        }
    }
}
