<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePackingTypeRequest;
use App\Http\Requests\UpdatePackingTypeRequest;
use App\Repositories\PackingTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class PackingTypeController extends AppBaseController
{
    /** @var  PackingTypeRepository */
    private $packingTypeRepository;

    public function __construct(PackingTypeRepository $packingTypeRepo)
    {
        $this->packingTypeRepository = $packingTypeRepo;
    }

    /**
     * Display a listing of the PackingType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->packingTypeRepository->pushCriteria(new RequestCriteria($request));
        $packingTypes = $this->packingTypeRepository->all();

        return view('packing_types.index')
            ->with('packingTypes', $packingTypes);
    }

    /**
     * Show the form for creating a new PackingType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('packing_types_add',Auth::user()->user_type_code)){

            return view('packing_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('packingTypes.index'));
        }
    }

    /**
     * Store a newly created PackingType in storage.
     *
     * @param CreatePackingTypeRequest $request
     *
     * @return Response
     */
    public function store(CreatePackingTypeRequest $request)
    {
        $input = $request->all();

        $packingType = $this->packingTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('packingTypes.index'));
    }

    /**
     * Display the specified PackingType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $packingType = $this->packingTypeRepository->findWithoutFail($id);

        if (empty($packingType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('packingTypes.index'));
        }

        return view('packing_types.show')->with('packingType', $packingType);
    }

    /**
     * Show the form for editing the specified PackingType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('packing_types_edit',Auth::user()->user_type_code)){

            $packingType = $this->packingTypeRepository->findWithoutFail($id);

            if (empty($packingType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('packingTypes.index'));
            }

            return view('packing_types.edit')->with('packingType', $packingType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('packingTypes.index'));
        }
    }

    /**
     * Update the specified PackingType in storage.
     *
     * @param  int              $id
     * @param UpdatePackingTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePackingTypeRequest $request)
    {
        $packingType = $this->packingTypeRepository->findWithoutFail($id);

        if (empty($packingType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('packingTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou PackingType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('packing_types_edit', $descricao);


        $packingType = $this->packingTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('packingTypes.index'));
    }

    /**
     * Remove the specified PackingType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('packing_types_remove',Auth::user()->user_type_code)){
            
            $packingType = $this->packingTypeRepository->findWithoutFail($id);

            if (empty($packingType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('packingTypes.index'));
            }

            $this->packingTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu PackingType ID: '.$id;
            $log = App\Models\Log::wlog('packing_types_remove', $descricao);


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
        return Datatables::of(App\Models\PackingType::query())->make(true);
    }
}
