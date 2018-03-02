<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePalletItemRequest;
use App\Http\Requests\UpdatePalletItemRequest;
use App\Repositories\PalletItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;
use App\Models\PalletItem;
use App\Models\Pallet;
use App\Models\Uom;

class PalletItemController extends AppBaseController
{
    /** @var  PalletItemRepository */
    private $palletItemRepository;

    public function __construct(PalletItemRepository $palletItemRepo)
    {
        $this->palletItemRepository = $palletItemRepo;
    }

    /**
     * Display a listing of the PalletItem.
     *
     * @param Request $request
     * @return Response
     */
    public function index($pallet_id)
    {
        
        $palletItems = $this->palletItemRepository->findWhere(array('pallet_id' => $pallet_id,
                                                                    'company_id' => Auth::user()->company_id));
        $palletBarcode = Pallet::find($pallet_id);   
        
        return view('pallet_items.index')
                ->with('palletItems', $palletItems)
                ->with('palletId', $pallet_id)
                ->with('palletBarcode', $palletBarcode->barcode);
    }

    /**
     * Show the form for creating a new PalletItem.
     *
     * @return Response
     */
    public function create($pallet_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallet_items_add',Auth::user()->user_type_code)){
            $palletBarcode = Pallet::find($pallet_id);   
            $uoms = Uom::getUoms();
            return view('pallet_items.create')
                    ->with('palletBarcode', $palletBarcode->barcode)
                    ->with('uom_cads', $uoms)
                    ->with('palletId', $pallet_id);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(action('PalletItemController@index',[$pallet_id]));
        }
    }

    /**
     * Store a newly created PalletItem in storage.
     *
     * @param CreatePalletItemRequest $request
     *
     * @return Response
     */
    public function store(CreatePalletItemRequest $request)
    {
        $input = $request->all();

        $palletItem = $this->palletItemRepository->create($input);

        //Id para retornar para a pagina do palete correto
        $pallet_id = $input['pallet_id'];

        Flash::success(Lang::get('validation.save_success'));

        return redirect(action('PalletItemController@index',[$pallet_id]));
    }

    /**
     * Display the specified PalletItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $palletItem = $this->palletItemRepository->findWithoutFail($id);

        if (empty($palletItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('palletItems.index'));
        }

        return view('pallet_items.show')->with('palletItem', $palletItem);
    }

    /**
     * Show the form for editing the specified PalletItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallet_items_edit',Auth::user()->user_type_code)){

            $palletItem = $this->palletItemRepository->findWithoutFail($id);
            $pallet_id = $palletItem['original']['pallet_id'];
            $palletBarcode = Pallet::find($pallet_id);   
            $uoms = Uom::getUoms();

            if (empty($palletItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('palletItems.index'));
            }

            return view('pallet_items.edit')
                    ->with('palletItem', $palletItem)
                    ->with('palletBarcode', $palletBarcode->barcode)
                    ->with('palletId', $pallet_id)
                    ->with('uom_cads', $uoms);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('pallet_items.index'));
        }
    }

    /**
     * Update the specified PalletItem in storage.
     *
     * @param  int              $id
     * @param UpdatePalletItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePalletItemRequest $request)
    {
        $palletItem = $this->palletItemRepository->findWithoutFail($id);

        if (empty($palletItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('palletItems.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou PalletItem ID: '.$id.' - Palete: '.$requestF['pallet_id'].' Etiqueta '.$requestF['label_id'];
        $log = App\Models\Log::wlog('pallet_items_edit', $descricao);


        $palletItem = $this->palletItemRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));
       
        return redirect(action('PalletItemController@index',[$requestF['pallet_id']]));
    }

    /**
     * Remove the specified PalletItem from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('pallet_items_remove',Auth::user()->user_type_code)){
            
            $palletItem = $this->palletItemRepository->findWithoutFail($id);

            if (empty($palletItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('palletItems.index'));
            }

            //$this->palletItemRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu PalletItem ID: '.$id;
            $log = App\Models\Log::wlog('pallet_items_remove', $descricao);


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
    public function getData($pallet_id)
    {
        return DataTables::of(App\Models\PalletItem::where('company_id', Auth::user()->company_id)
                                                   ->where('pallet_id', $pallet_id))
                                                   ->make(true);
    }
}
