<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Maquina;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MaquinaIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'eliminar_maquina'
    ];
    public function render()
    {
        return view('livewire.maquina-index', [
            'maquinas' => $this->get_data()
        ]);
    }

    private function get_data(){
        $maquinas = Maquina::/* where('estado', '<>', 0)-> */paginate(1);
        return $maquinas;
    }

    /* ********************** INIT RULES ************************** */
    public $operation = '';

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    protected function rules(){
        if($this->operation=='create_machine'){
            return $this->rulesForCreateMachine();
        } else if($this->operation=='edit_machine'){
            return $this->rulesForEditMachine();
        }
        return array_merge(
            $this->rulesForCreateMachine(),
            $this->rulesForEditMachine()
        );
    }

    public $nombre;
    public $descripcion;
    public $id_maquina;

    /* ******************************************************************************************* */

    public function close_modal_create_edit_machine(){
        $this->operation = '';
        $this->reset([
            'nombre',
            'descripcion',
            'id_maquina'
        ]);
        $this->resetValidation();
    }

    public function rulesForCreateMachine(){
        return [
            'nombre' => 'required|string|unique:maquinas,nombre|min:5|max:100',
            'descripcion' => 'nullable|string|max:255',
        ];
    }

    public function open_modal_crear_maquina(){
        $this->close_modal_create_edit_machine();
        $this->operation = 'create_machine';
    }

    public function save_maquina(){
        if($this->operation == 'create_machine'){
            $this->validate();
            try{
                $maquina = new Maquina();
                $maquina->nombre = $this->nombre;
                $maquina->descripcion = is_null($this->descripcion)? '': $this->descripcion;
                $maquina->id_user = Auth::id();
                $maquina->save();

                $this->emit('success', 'Se ha registrado exitosamente una nueva máquina');
                $this->close_modal_create_edit_machine();
            } catch(\Exception $e){
                $this->emit('error', 'Error al crear la máquina. '. $e->getMessage());
            }
        }
    }

    /* *********************************************************** */

    public function rulesForEditMachine(){
        #$max_kg = ($this->adm_proceso_preparacion)? $this->adm_proceso_preparacion->disponible_kg: 0;
        return [
            'id_maquina' => 'required|exists:maquinas,id',
            'nombre' => [
                'required',
                'string',
                Rule::unique('maquinas', 'nombre')->ignore($this->id_maquina),
                'min:5',
                'max:100'
            ],
            'descripcion' => 'nullable|string|max:255'    
        ];
    }

    public function open_modal_editar_maquina($id){
        $this->close_modal_create_edit_machine();
        $maquina = Maquina::where('id', $id)->first();
        if($maquina){
            $this->id_maquina = $maquina->id;
            $this->nombre = $maquina->nombre;
            $this->descripcion = $maquina->descripcion;
            $this->operation = 'edit_machine';
        }
    }

    public function update_maquina(){
        if($this->operation == 'edit_machine'){
            $this->validate();
            try{
                $maquina = Maquina::where('id', $this->id_maquina)->first();
                $maquina->nombre = $this->nombre;
                $maquina->descripcion = is_null($this->descripcion)? '': $this->descripcion;
                $maquina->id_user = Auth::id();
                $maquina->save();

                $this->emit('success', 'Se ha actualizado exitosamente una nueva máquina');
                $this->close_modal_create_edit_machine();
            } catch(\Exception $e){
                $this->emit('error', 'Error al actualizar la máquina. '. $e->getMessage());
            }
        }
    }

    /* ********************** END RULES ************************** */

    public function eliminar_maquina($id){
        $maquina = Maquina::where('id', $id)->first();
        if($maquina){
            $maquina->estado = 0;
            $maquina->save();
            $this->emit('success', 'Se ha eliminado exitosamente una máquina');
        }
    }

    public function restaurar_maquina($id){
        $maquina = Maquina::where('id', $id)->first();
        if($maquina){
            $maquina->estado = 1;
            $maquina->save();
            $this->emit('success', 'Se ha restaurado exitosamente una máquina');
        }
    }
}
