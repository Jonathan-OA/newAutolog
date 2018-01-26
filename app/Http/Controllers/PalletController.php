<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePalletRequest;
use App\Http\Requests\UpdatePalletRequest;
use App\Repositories\PalletRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class PalletController extends AppBaseController
{
    /** @var  PalletRepository */
    private $palletRepository;

    public function __construct(PalletRepository $palletRepo)
    {
        $this->palletRepository = $palletRepo;
    }

    /**
     * Display a listing of the Pallet.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->palletRepository->pushCriteria(new RequestCriteria($request));
        $pallets = $this->palletRepository->all();

        return view('pallets.index')
            ->with('pallets', $pallets);
    }

    /**
     * Show the form for creating a new Pallet.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallets_add',Auth::user()->user_type_code)){
            $packingTypes = App\Models\PackingType::getPackingTypes();

            return view('pallets.create')->with('packing_types',$packingTypes);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('pallets.index'));
        }
    }

    /**
     * Store a newly created Pallet in storage.
     *
     * @param CreatePalletRequest $request
     *
     * @return Response
     */
    public function store(CreatePalletRequest $request)
    {
        $input = $request->all();

        $pallet = $this->palletRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('pallets.index'));
    }

    /**
     * Display the specified Pallet.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pallet = $this->palletRepository->findWithoutFail($id);

        if (empty($pallet)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('pallets.index'));
        }

        return view('pallets.show')->with('pallet', $pallet);
    }

    /**
     * Show the form for editing the specified Pallet.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallets_edit',Auth::user()->user_type_code)){

            $pallet = $this->palletRepository->findWithoutFail($id);

            if (empty($pallet)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('pallets.index'));
            }

            return view('pallets.edit')->with('pallet', $pallet);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('pallets.index'));
        }
    }

    /**
     * Update the specified Pallet in storage.
     *
     * @param  int              $id
     * @param UpdatePalletRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePalletRequest $request)
    {
        $pallet = $this->palletRepository->findWithoutFail($id);

        if (empty($pallet)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('pallets.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Pallet ID: '.$id.' - '.$requestF['barcode'];
        $log = App\Models\Log::wlog('pallets_edit', $descricao);


        $pallet = $this->palletRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('pallets.index'));
    }

    /**
     * Remove the specified Pallet from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallets_remove',Auth::user()->user_type_code)){
            
            $pallet = $this->palletRepository->findWithoutFail($id);

            if (empty($pallet)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('pallets.index'));
            }

            $this->palletRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Pallet ID: '.$id;
            $log = App\Models\Log::wlog('pallets_remove', $descricao);


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
        return Datatables::of(App\Models\Pallet::where('company_id', Auth::user()->company_id))->make(true);
    }
}
