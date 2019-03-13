<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationTypeRequest;
use App\Http\Requests\UpdateLocationTypeRequest;
use App\Repositories\LocationTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LocationTypeController extends AppBaseController
{
    /** @var  LocationTypeRepository */
    private $locationTypeRepository;

    public function __construct(LocationTypeRepository $locationTypeRepo)
    {
        $this->locationTypeRepository = $locationTypeRepo;
    }

    /**
     * Display a listing of the LocationType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->locationTypeRepository->pushCriteria(new RequestCriteria($request));
        $locationTypes = $this->locationTypeRepository->all();

        return view('locations.location_types.index')
            ->with('locationTypes', $locationTypes);
    }

    /**
     * Show the form for creating a new LocationType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('location_types_add',Auth::user()->user_type_code)){

            return view('locations.location_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('location_types.index'));
        }
    }

    /**
     * Store a newly created LocationType in storage.
     *
     * @param CreateLocationTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationTypeRequest $request)
    {
        $input = $request->all();

        $locationType = $this->locationTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('locationTypes.index'));
    }

    /**
     * Display the specified LocationType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $locationType = $this->locationTypeRepository->findWithoutFail($id);

        if (empty($locationType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('locationTypes.index'));
        }

        return view('locations.location_types.show')->with('locationType', $locationType);
    }

    /**
     * Show the form for editing the specified LocationType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('location_types_edit',Auth::user()->user_type_code)){

            $locationType = $this->locationTypeRepository->findWithoutFail($id);

            if (empty($locationType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('locationTypes.index'));
            }

            return view('locations.location_types.edit')->with('locationType', $locationType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('location_types.index'));
        }
    }

    /**
     * Update the specified LocationType in storage.
     *
     * @param  int              $id
     * @param UpdateLocationTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationTypeRequest $request)
    {
        $locationType = $this->locationTypeRepository->findWithoutFail($id);

        if (empty($locationType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('locationTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LocationType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('location_types_edit', $descricao);


        $locationType = $this->locationTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('locationTypes.index'));
    }

    /**
     * Remove the specified LocationType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('location_types_remove',Auth::user()->user_type_code)){
            
            $locationType = $this->locationTypeRepository->findWithoutFail($id);

            if (empty($locationType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('locationTypes.index'));
            }

            $this->locationTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LocationType ID: '.$id;
            $log = App\Models\Log::wlog('location_types_remove', $descricao);


            Flash::success(Lang::get('validation.delete_success'));
            return array('success',Lang::get('validation.delete_success'));

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array('danger',Lang::get('validation.permission'));
        }    
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return DataTables::of(App\Models\LocationType::all())->make(true);
    }
}
