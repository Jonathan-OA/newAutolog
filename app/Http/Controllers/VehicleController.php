<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Repositories\VehicleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class VehicleController extends AppBaseController
{
    /** @var  VehicleRepository */
    private $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepo)
    {
        $this->vehicleRepository = $vehicleRepo;
    }

    /**
     * Display a listing of the Vehicle.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->vehicleRepository->pushCriteria(new RequestCriteria($request));
        $vehicles = $this->vehicleRepository->all();

        return view('vehicles.index')
            ->with('vehicles', $vehicles);
    }

    /**
     * Show the form for creating a new Vehicle.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('vehicles_add',Auth::user()->user_type_code)){

            return view('vehicles.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('vehicles.index'));
        }
    }

    /**
     * Store a newly created Vehicle in storage.
     *
     * @param CreateVehicleRequest $request
     *
     * @return Response
     */
    public function store(CreateVehicleRequest $request)
    {
        $input = $request->all();

        $vehicle = $this->vehicleRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('vehicles.index'));
    }

    /**
     * Display the specified Vehicle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $vehicle = $this->vehicleRepository->findWithoutFail($id);

        if (empty($vehicle)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('vehicles.index'));
        }

        return view('vehicles.show')->with('vehicle', $vehicle);
    }

    /**
     * Show the form for editing the specified Vehicle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('vehicles_edit',Auth::user()->user_type_code)){

            $vehicle = $this->vehicleRepository->findWithoutFail($id);

            if (empty($vehicle)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('vehicles.index'));
            }

            return view('vehicles.edit')->with('vehicle', $vehicle);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('vehicles.index'));
        }
    }

    /**
     * Update the specified Vehicle in storage.
     *
     * @param  int              $id
     * @param UpdateVehicleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVehicleRequest $request)
    {
        $vehicle = $this->vehicleRepository->findWithoutFail($id);

        if (empty($vehicle)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('vehicles.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Vehicle ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('vehicles_edit', $descricao);


        $vehicle = $this->vehicleRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('vehicles.index'));
    }

    /**
     * Remove the specified Vehicle from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('vehicles_remove',Auth::user()->user_type_code)){
            
            $vehicle = $this->vehicleRepository->findWithoutFail($id);

            if (empty($vehicle)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('vehicles.index'));
            }

            $this->vehicleRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Vehicle ID: '.$id;
            $log = App\Models\Log::wlog('vehicles_remove', $descricao);


            Flash::success(Lang::get('validation.delete_success'));
            return array(0,Lang::get('validation.delete_success'));

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array(1,Lang::get('validation.permission'));
        }    
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return Datatables::of(App\Models\Vehicle::where('company_id', Auth::user()->company_id))->make(true);
    }
}
