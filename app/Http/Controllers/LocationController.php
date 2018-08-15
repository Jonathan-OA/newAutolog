<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Repositories\LocationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LocationController extends AppBaseController
{
    /** @var  LocationRepository */
    private $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        $this->locationRepository = $locationRepo;
    }

    /**
     * Display a listing of the Location.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->locationRepository->pushCriteria(new RequestCriteria($request));
        $locations = $this->locationRepository->findByField('company_id', Auth::user()->company_id);

        return view('locations.index')
            ->with('locations', $locations);
    }

    /**
     * Show the form for creating a new Location.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('locations_add',Auth::user()->user_type_code)){
            //Lista de departamentos disponiveis
            $departments = App\Models\Department::getDepartments();
            //Lista de depositos disponiveis
            $deposits = App\Models\Deposit::getDeposits();
            //Lista de setores disponiveis
            $sectors = App\Models\Sector::getSectors();
            //Lista tipos de endereço
            $location_types = App\Models\LocationType::getLocationTypes();
            //Lista funções de endereço
            $location_functions = App\Models\LocationFunction::getLocationFunctions();
            //Lista tipos de estoque (picking, palete, picking por prod.)
            $stock_types = App\Models\StockType::getStockTypes();
            
           
            return view('locations.create')->with('departments',$departments)
                                           ->with('deposits',$deposits)
                                           ->with('sectors',$sectors)
                                           ->with('location_types',$location_types)
                                           ->with('location_functions',$location_functions)
                                           ->with('stock_types',$stock_types);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('locations.index'));
        }
    }

    /**
     * Store a newly created Location in storage.
     *
     * @param CreateLocationRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationRequest $request)
    {
        $input = $request->all();
        
        $input['depth'] = (float)$input['depth'];
        $input['sequence_arm'] = (float)$input['sequence_arm'];
        $input['sequence_sep'] = (float)$input['sequence_sep'];
        $input['sequence_inv'] = (float)$input['sequence_inv'];

        $location = $this->locationRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('locations.index'));
    }

    /**
     * Display the specified Location.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('locations.index'));
        }

        return view('locations.show')->with('location', $location);
    }

    /**
     * Show the form for editing the specified Location.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('locations_edit',Auth::user()->user_type_code)){

            $location = $this->locationRepository->findWithoutFail($id);

            //Lista de departamentos disponiveis
            $departments = App\Models\Department::getDepartments();
            //Lista de depositos disponiveis
            $deposits = App\Models\Deposit::getDeposits();
            //Lista de setores disponiveis
            $sectors = App\Models\Sector::getSectors();
            //Lista tipos de endereço
            $location_types = App\Models\LocationType::getLocationTypes();
            //Lista funções de endereço
            $location_functions = App\Models\LocationFunction::getLocationFunctions();
            //Lista tipos de estoque (picking, palete, picking por prod.)
            $stock_types = App\Models\StockType::getStockTypes();

            if (empty($location)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('locations.index'));
            }

            return view('locations.edit')->with('location', $location)
                                         ->with('departments',$departments)
                                         ->with('deposits',$deposits)
                                         ->with('sectors',$sectors)
                                         ->with('location_types',$location_types)
                                         ->with('location_functions',$location_functions)
                                         ->with('stock_types',$stock_types);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('locations.index'));
        }
    }

    /**
     * Update the specified Location in storage.
     *
     * @param  int              $id
     * @param UpdateLocationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationRequest $request)
    {
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('locations.index'));
        }

        //Grava log
        $requestF = $request->all();

        $requestF['depth'] = (float)$requestF['depth'];
        $requestF['sequence_arm'] = (float)$requestF['sequence_arm'];
        $requestF['sequence_sep'] = (float)$requestF['sequence_arm'];
        $requestF['sequence_inv'] = (float)$requestF['sequence_arm'];

        $descricao = 'Alterou Location ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('locations_edit', $descricao);


        $location = $this->locationRepository->update($requestF, $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('locations.index'));
    }

    /**
     * Remove the specified Location from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('locations_remove',Auth::user()->user_type_code)){
            
            $location = $this->locationRepository->findWithoutFail($id);

            if (empty($location)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('locations.index'));
            }

            $this->locationRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Location ID: '.$id;
            $log = App\Models\Log::wlog('locations_remove', $descricao);


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
        return DataTables::of(App\Models\Location::where('company_id', Auth::user()->company_id))->make(true);
    }
}
