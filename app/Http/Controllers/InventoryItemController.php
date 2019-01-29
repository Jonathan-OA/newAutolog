<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Repositories\InventoryItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class InventoryItemController extends AppBaseController
{
    /** @var  InventoryItemRepository */
    private $inventoryItemRepository;

    public function __construct(InventoryItemRepository $inventoryItemRepo)
    {
        $this->inventoryItemRepository = $inventoryItemRepo;
    }

    /**
     * Display a listing of the InventoryItem.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->inventoryItemRepository->pushCriteria(new RequestCriteria($request));
        $inventoryItems = $this->inventoryItemRepository->findByField('company_id', Auth::user()->company_id);

        return view('inventory_items.index')
            ->with('inventoryItems', $inventoryItems);
    }

    /**
     * Show the form for creating a new InventoryItem.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('inventory_items_add',Auth::user()->user_type_code)){

            return view('inventory_items.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('inventory_items.index'));
        }
    }

    /**
     * Store a newly created InventoryItem in storage.
     *
     * @param CreateInventoryItemRequest $request
     *
     * @return Response
     */
    public function store(CreateInventoryItemRequest $request)
    {
        $input = $request->all();

        $inventoryItem = $this->inventoryItemRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('inventoryItems.index'));
    }

    /**
     * Display the specified InventoryItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $inventoryItem = $this->inventoryItemRepository->findWithoutFail($id);

        if (empty($inventoryItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('inventoryItems.index'));
        }

        return view('inventory_items.show')->with('inventoryItem', $inventoryItem);
    }

    /**
     * Show the form for editing the specified InventoryItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('inventory_items_edit',Auth::user()->user_type_code)){

            $inventoryItem = $this->inventoryItemRepository->findWithoutFail($id);

            if (empty($inventoryItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('inventoryItems.index'));
            }

            return view('inventory_items.edit')->with('inventoryItem', $inventoryItem);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('inventory_items.index'));
        }
    }

    /**
     * Update the specified InventoryItem in storage.
     *
     * @param  int              $id
     * @param UpdateInventoryItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInventoryItemRequest $request)
    {
        $inventoryItem = $this->inventoryItemRepository->findWithoutFail($id);

        if (empty($inventoryItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('inventoryItems.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou InventoryItem ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('inventory_items_edit', $descricao);


        $inventoryItem = $this->inventoryItemRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('inventoryItems.index'));
    }

    /**
     * Remove the specified InventoryItem from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('inventory_items_remove',Auth::user()->user_type_code)){
            
            $inventoryItem = $this->inventoryItemRepository->findWithoutFail($id);

            if (empty($inventoryItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('inventoryItems.index'));
            }

            $this->inventoryItemRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu InventoryItem ID: '.$id;
            $log = App\Models\Log::wlog('inventory_items_remove', $descricao);


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
        return Datatables::of(App\Models\InventoryItem::where('company_id', Auth::user()->company_id))->make(true);
    }
}
