<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Proceso;
use App\Models\Produccion;

class ProduccionesIndex extends Component
{
    private $LISTA_DE_SABORES = [
        "CAJA BICO STEVIA",
        "CAJA BICO CHAMAIRO",
        "CAJA BICO MENTA 3 EN 1",
        "CAJA BICO MENTA",
        "CAJA BICO CAFÉ 3 EN 1",
        "CAJA BICO CAFÉ",
        "CAJA BICO LIMÓN",
        "CAJA BICO STEVIA BLANCA",
        "CAJA EUCALIPTO",
        "CAJA MARACUYÁ",
        "CHICLE",
        "BANANA",
        "FRUTILLA",
        "CEDRÓN",
        "CHIRIMOYA",
        "DURAZNO",
        "POMELO",
        "FUSIÓN DE FRUTAS",
        "MANGO",
    ];

    public $ID_PROCESO;
    // se inicializa una sola vez,
    public function mount($id_proceso){
        $this->emit('mensaje', 'INICIALIZADO FULLLL');
        $this->ID_PROCESO = $id_proceso;
        $this->LISTA_DE_SABORES = include(app_path(). '/dataCustom/sabores.php');
    }

    public function render()
    {
        $liv_proceso = Proceso::where('id', $this->ID_PROCESO)->first();

        $liv_producciones = [];
        $liv_sabores_dispononibles = [];
        if($liv_proceso){
            $liv_producciones = Produccion::where('proceso_id', $liv_proceso->id)->get();
            $liv_sabores_dispononibles = array_replace([], $this->LISTA_DE_SABORES);
            if(count($liv_producciones) > 0){
                foreach($liv_producciones as $prod){
                    try {
                        unset($liv_sabores_dispononibles[$prod->sabor]);
                    }catch(\Exception $e){
                        # si hay error no se hace nada
                    }
                }
            }
        }


        return view('livewire.producciones-index', [
            'liv_proceso' => $liv_proceso,
            'liv_producciones' => $liv_producciones,
            'liv_sabores_dispononibles' => $liv_sabores_dispononibles
        ]);
    }

    /* ******************* modales ********************* */
    public function abrir_modal_salida_molino(){
        #$this->emit('showModalAddMolino');
        $this->emit('mensaje', 'funcion al 100%');
    }
    /* ******************* fin ************************* */

}
