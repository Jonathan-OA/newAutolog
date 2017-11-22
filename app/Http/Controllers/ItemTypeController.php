<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemTypeRequest;
use App\Http\Requests\UpdateItemTypeRequest;
use App\Repositories\ItemTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class ItemTypeController extends AppBaseController
{
    /** @var  ItemTypeRepository */
    private $itemTypeRepository;

    public function __construct(ItemTypeRepository $itemTypeRepo)
    {
        $this->itemTypeRepository = $itemTypeRepo;
    }

    /**
     * Display a listing of the ItemType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->itemTypeRepository->pushCriteria(new RequestCriteria($request));
        $itemTypes = $this->itemTypeRepository->all();

        return view('item_types.index')
            ->with('itemTypes', $itemTypes);
    }

    /**
     * Show the form for creating a new ItemType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('item_types_add',Auth::user()->user_type_code)){

            return view('item_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('itemTypes.index'));
        }
    }

    /**
     * Store a newly created ItemType in storage.
     *
     * @param CreateItemTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateItemTypeRequest $request)
    {
        $input = $request->all();

        $itemType = $this->itemTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('itemTypes.index'));
    }

    /**
     * Display the specified ItemType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $itemType = $this->itemTypeRepository->findWithoutFail($id);

        if (empty($itemType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('itemTypes.index'));
        }

        return view('item_types.show')->with('itemType', $itemType);
    }

    /**
     * Show the form for editing the specified ItemType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('item_types_edit',Auth::user()->user_type_code)){

            $itemType = $this->itemTypeRepository->findWithoutFail($id);

            if (empty($itemType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('itemTypes.index'));
            }

            return view('item_types.edit')->with('itemType', $itemType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('itemTypes.index'));
        }
    }

    /**
     * Update the specified ItemType in storage.
     *
     * @param  int              $id
     * @param UpdateItemTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemTypeRequest $request)
    {
        $itemType = $this->itemTypeRepository->findWithoutFail($id);

        if (empty($itemType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('itemTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou ItemType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('item_types_edit', $descricao);


        $itemType = $this->itemTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('itemTypes.index'));
    }

    /**
     * Remove the specified ItemType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('item_types_remove',Auth::user()->user_type_code)){
            
            $itemType = $this->itemTypeRepository->findWithoutFail($id);

            if (empty($itemType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('itemTypes.index'));
            }

            $this->itemTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu ItemType ID: '.$id;
            $log = App\Models\Log::wlog('item_types_remove', $descricao);


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
        return Datatables::of(App\Models\ItemType::query())->make(true);
    }
}
