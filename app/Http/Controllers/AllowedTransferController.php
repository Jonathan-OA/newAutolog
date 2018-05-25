<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAllowedTransferRequest;
use App\Http\Requests\UpdateAllowedTransferRequest;
use App\Repositories\AllowedTransferRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class AllowedTransferController extends AppBaseController
{
    /** @var  AllowedTransferRepository */
    private $allowedTransferRepository;

    public function __construct(AllowedTransferRepository $allowedTransferRepo)
    {
        $this->allowedTransferRepository = $allowedTransferRepo;
    }

    /**
     * Display a listing of the AllowedTransfer.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->allowedTransferRepository->pushCriteria(new RequestCriteria($request));
        $allowedTransfers = $this->allowedTransferRepository->all();

        return view('allowed_transfers.index')
            ->with('allowedTransfers', $allowedTransfers);
    }

    /**
     * Show the form for creating a new AllowedTransfer.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('allowed_transfers_add',Auth::user()->user_type_code)){

            return view('allowed_transfers.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('allowed_transfers.index'));
        }
    }

    /**
     * Store a newly created AllowedTransfer in storage.
     *
     * @param CreateAllowedTransferRequest $request
     *
     * @return Response
     */
    public function store(CreateAllowedTransferRequest $request)
    {
        $input = $request->all();

        $allowedTransfer = $this->allowedTransferRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('allowedTransfers.index'));
    }

    /**
     * Display the specified AllowedTransfer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $allowedTransfer = $this->allowedTransferRepository->findWithoutFail($id);

        if (empty($allowedTransfer)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('allowedTransfers.index'));
        }

        return view('allowed_transfers.show')->with('allowedTransfer', $allowedTransfer);
    }

    /**
     * Show the form for editing the specified AllowedTransfer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('allowed_transfers_edit',Auth::user()->user_type_code)){

            $allowedTransfer = $this->allowedTransferRepository->findWithoutFail($id);

            if (empty($allowedTransfer)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('allowedTransfers.index'));
            }

            return view('allowed_transfers.edit')->with('allowedTransfer', $allowedTransfer);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('allowed_transfers.index'));
        }
    }

    /**
     * Update the specified AllowedTransfer in storage.
     *
     * @param  int              $id
     * @param UpdateAllowedTransferRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAllowedTransferRequest $request)
    {
        $allowedTransfer = $this->allowedTransferRepository->findWithoutFail($id);

        if (empty($allowedTransfer)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('allowedTransfers.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou AllowedTransfer ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('allowed_transfers_edit', $descricao);


        $allowedTransfer = $this->allowedTransferRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('allowedTransfers.index'));
    }

    /**
     * Remove the specified AllowedTransfer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('allowed_transfers_remove',Auth::user()->user_type_code)){
            
            $allowedTransfer = $this->allowedTransferRepository->findWithoutFail($id);

            if (empty($allowedTransfer)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('allowedTransfers.index'));
            }

            $this->allowedTransferRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu AllowedTransfer ID: '.$id;
            $log = App\Models\Log::wlog('allowed_transfers_remove', $descricao);


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
        return Datatables::of(App\Models\AllowedTransfer::where('company_id', Auth::user()->company_id))->make(true);
    }
}
