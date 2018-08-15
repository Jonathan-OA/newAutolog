<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLiberationItemRequest;
use App\Http\Requests\UpdateLiberationItemRequest;
use App\Repositories\LiberationItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LiberationItemController extends AppBaseController
{
    /** @var  LiberationItemRepository */
    private $liberationItemRepository;

    public function __construct(LiberationItemRepository $liberationItemRepo)
    {
        $this->liberationItemRepository = $liberationItemRepo;
    }

    /**
     * Display a listing of the LiberationItem.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->liberationItemRepository->pushCriteria(new RequestCriteria($request));
        $liberationItems = $this->liberationItemRepository->findByField('company_id', Auth::user()->company_id);

        return view('liberation_items.index')
            ->with('liberationItems', $liberationItems);
    }

    /**
     * Show the form for creating a new LiberationItem.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_items_add',Auth::user()->user_type_code)){

            return view('liberation_items.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('liberation_items.index'));
        }
    }

    /**
     * Store a newly created LiberationItem in storage.
     *
     * @param CreateLiberationItemRequest $request
     *
     * @return Response
     */
    public function store(CreateLiberationItemRequest $request)
    {
        $input = $request->all();

        $liberationItem = $this->liberationItemRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('liberationItems.index'));
    }

    /**
     * Display the specified LiberationItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $liberationItem = $this->liberationItemRepository->findWithoutFail($id);

        if (empty($liberationItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('liberationItems.index'));
        }

        return view('liberation_items.show')->with('liberationItem', $liberationItem);
    }

    /**
     * Show the form for editing the specified LiberationItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_items_edit',Auth::user()->user_type_code)){

            $liberationItem = $this->liberationItemRepository->findWithoutFail($id);

            if (empty($liberationItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('liberationItems.index'));
            }

            return view('liberation_items.edit')->with('liberationItem', $liberationItem);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('liberation_items.index'));
        }
    }

    /**
     * Update the specified LiberationItem in storage.
     *
     * @param  int              $id
     * @param UpdateLiberationItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLiberationItemRequest $request)
    {
        $liberationItem = $this->liberationItemRepository->findWithoutFail($id);

        if (empty($liberationItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('liberationItems.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LiberationItem ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('liberation_items_edit', $descricao);


        $liberationItem = $this->liberationItemRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('liberationItems.index'));
    }

    /**
     * Remove the specified LiberationItem from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_items_remove',Auth::user()->user_type_code)){
            
            $liberationItem = $this->liberationItemRepository->findWithoutFail($id);

            if (empty($liberationItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('liberationItems.index'));
            }

            $this->liberationItemRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LiberationItem ID: '.$id;
            $log = App\Models\Log::wlog('liberation_items_remove', $descricao);


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
        return Datatables::of(App\Models\LiberationItem::where('company_id', Auth::user()->company_id))->make(true);
    }
}
