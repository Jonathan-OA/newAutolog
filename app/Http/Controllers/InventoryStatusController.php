<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInventoryStatusRequest;
use App\Http\Requests\UpdateInventoryStatusRequest;
use App\Repositories\InventoryStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class InventoryStatusController extends AppBaseController
{
    /** @var  InventoryStatusRepository */
    private $inventoryStatusRepository;

    public function __construct(InventoryStatusRepository $inventoryStatusRepo)
    {
        $this->inventoryStatusRepository = $inventoryStatusRepo;
    }

    /**
     * Display a listing of the InventoryStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->inventoryStatusRepository->pushCriteria(new RequestCriteria($request));
        $inventoryStatus = $this->inventoryStatusRepository->all();

        return view('inventory_status.index')
            ->with('inventoryStatus', $inventoryStatus);
    }

    /**
     * Show the form for creating a new InventoryStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('inventory_status_add',Auth::user()->user_type_code)){

            return view('inventory_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('inventory_status.index'));
        }
    }

    /**
     * Store a newly created InventoryStatus in storage.
     *
     * @param CreateInventoryStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateInventoryStatusRequest $request)
    {
        $input = $request->all();

        $inventoryStatus = $this->inventoryStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('inventoryStatus.index'));
    }

    /**
     * Display the specified InventoryStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $inventoryStatus = $this->inventoryStatusRepository->findWithoutFail($id);

        if (empty($inventoryStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('inventoryStatus.index'));
        }

        return view('inventory_status.show')->with('inventoryStatus', $inventoryStatus);
    }

    /**
     * Show the form for editing the specified InventoryStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('inventory_status_edit',Auth::user()->user_type_code)){

            $inventoryStatus = $this->inventoryStatusRepository->findWithoutFail($id);

            if (empty($inventoryStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('inventoryStatus.index'));
            }

            return view('inventory_status.edit')->with('inventoryStatus', $inventoryStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('inventory_status.index'));
        }
    }

    /**
     * Update the specified InventoryStatus in storage.
     *
     * @param  int              $id
     * @param UpdateInventoryStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInventoryStatusRequest $request)
    {
        $inventoryStatus = $this->inventoryStatusRepository->findWithoutFail($id);

        if (empty($inventoryStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('inventoryStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou InventoryStatus ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('inventory_status_edit', $descricao);


        $inventoryStatus = $this->inventoryStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('inventoryStatus.index'));
    }

    /**
     * Remove the specified InventoryStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('inventory_status_remove',Auth::user()->user_type_code)){
            
            $inventoryStatus = $this->inventoryStatusRepository->findWithoutFail($id);

            if (empty($inventoryStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('inventoryStatus.index'));
            }

            $this->inventoryStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu InventoryStatus ID: '.$id;
            $log = App\Models\Log::wlog('inventory_status_remove', $descricao);


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
        return Datatables::of(App\Models\InventoryStatus::all())->make(true);
    }
}
