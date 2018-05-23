<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVolumeItemRequest;
use App\Http\Requests\UpdateVolumeItemRequest;
use App\Repositories\VolumeItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class VolumeItemController extends AppBaseController
{
    /** @var  VolumeItemRepository */
    private $volumeItemRepository;

    public function __construct(VolumeItemRepository $volumeItemRepo)
    {
        $this->volumeItemRepository = $volumeItemRepo;
    }

    /**
     * Display a listing of the VolumeItem.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->volumeItemRepository->pushCriteria(new RequestCriteria($request));
        $volumeItems = $this->volumeItemRepository->all();

        return view('volume_items.index')
            ->with('volumeItems', $volumeItems);
    }

    /**
     * Show the form for creating a new VolumeItem.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volume_items_add',Auth::user()->user_type_code)){

            return view('volume_items.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('volume_items.index'));
        }
    }

    /**
     * Store a newly created VolumeItem in storage.
     *
     * @param CreateVolumeItemRequest $request
     *
     * @return Response
     */
    public function store(CreateVolumeItemRequest $request)
    {
        $input = $request->all();

        $volumeItem = $this->volumeItemRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('volumeItems.index'));
    }

    /**
     * Display the specified VolumeItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $volumeItem = $this->volumeItemRepository->findWithoutFail($id);

        if (empty($volumeItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('volumeItems.index'));
        }

        return view('volume_items.show')->with('volumeItem', $volumeItem);
    }

    /**
     * Show the form for editing the specified VolumeItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volume_items_edit',Auth::user()->user_type_code)){

            $volumeItem = $this->volumeItemRepository->findWithoutFail($id);

            if (empty($volumeItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('volumeItems.index'));
            }

            return view('volume_items.edit')->with('volumeItem', $volumeItem);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('volume_items.index'));
        }
    }

    /**
     * Update the specified VolumeItem in storage.
     *
     * @param  int              $id
     * @param UpdateVolumeItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVolumeItemRequest $request)
    {
        $volumeItem = $this->volumeItemRepository->findWithoutFail($id);

        if (empty($volumeItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('volumeItems.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou VolumeItem ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('volume_items_edit', $descricao);


        $volumeItem = $this->volumeItemRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('volumeItems.index'));
    }

    /**
     * Remove the specified VolumeItem from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volume_items_remove',Auth::user()->user_type_code)){
            
            $volumeItem = $this->volumeItemRepository->findWithoutFail($id);

            if (empty($volumeItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('volumeItems.index'));
            }

            $this->volumeItemRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu VolumeItem ID: '.$id;
            $log = App\Models\Log::wlog('volume_items_remove', $descricao);


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
        return Datatables::of(App\Models\VolumeItem::where('company_id', Auth::user()->company_id))->make(true);
    }
}
