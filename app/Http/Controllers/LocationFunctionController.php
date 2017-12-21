<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationFunctionRequest;
use App\Http\Requests\UpdateLocationFunctionRequest;
use App\Repositories\LocationFunctionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class LocationFunctionController extends AppBaseController
{
    /** @var  LocationFunctionRepository */
    private $locationFunctionRepository;

    public function __construct(LocationFunctionRepository $locationFunctionRepo)
    {
        $this->locationFunctionRepository = $locationFunctionRepo;
    }

    /**
     * Display a listing of the LocationFunction.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->locationFunctionRepository->pushCriteria(new RequestCriteria($request));
        $locationFunctions = $this->locationFunctionRepository->all();

        return view('location_functions.index')
            ->with('locationFunctions', $locationFunctions);
    }

    /**
     * Show the form for creating a new LocationFunction.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('location_functions_add',Auth::user()->user_type_code)){

            return view('location_functions.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('location_functions.index'));
        }
    }

    /**
     * Store a newly created LocationFunction in storage.
     *
     * @param CreateLocationFunctionRequest $request
     *
     * @return Response
     */
    public function store(CreateLocationFunctionRequest $request)
    {
        $input = $request->all();

        $locationFunction = $this->locationFunctionRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('locationFunctions.index'));
    }

    /**
     * Display the specified LocationFunction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $locationFunction = $this->locationFunctionRepository->findWithoutFail($id);

        if (empty($locationFunction)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('locationFunctions.index'));
        }

        return view('location_functions.show')->with('locationFunction', $locationFunction);
    }

    /**
     * Show the form for editing the specified LocationFunction.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('location_functions_edit',Auth::user()->user_type_code)){

            $locationFunction = $this->locationFunctionRepository->findWithoutFail($id);

            if (empty($locationFunction)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('locationFunctions.index'));
            }

            return view('location_functions.edit')->with('locationFunction', $locationFunction);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('location_functions.index'));
        }
    }

    /**
     * Update the specified LocationFunction in storage.
     *
     * @param  int              $id
     * @param UpdateLocationFunctionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLocationFunctionRequest $request)
    {
        $locationFunction = $this->locationFunctionRepository->findWithoutFail($id);

        if (empty($locationFunction)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('locationFunctions.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LocationFunction ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('location_functions_edit', $descricao);


        $locationFunction = $this->locationFunctionRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('locationFunctions.index'));
    }

    /**
     * Remove the specified LocationFunction from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('location_functions_remove',Auth::user()->user_type_code)){
            
            $locationFunction = $this->locationFunctionRepository->findWithoutFail($id);

            if (empty($locationFunction)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('locationFunctions.index'));
            }

            $this->locationFunctionRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LocationFunction ID: '.$id;
            $log = App\Models\Log::wlog('location_functions_remove', $descricao);


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
        return Datatables::of(App\Models\LocationFunction::all())->make(true);
    }
}
