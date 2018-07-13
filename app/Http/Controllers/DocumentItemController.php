<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentItemRequest;
use App\Http\Requests\UpdateDocumentItemRequest;
use App\Repositories\DocumentItemRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class DocumentItemController extends AppBaseController
{
    /** @var  DocumentItemRepository */
    private $documentItemRepository;

    public function __construct(DocumentItemRepository $documentItemRepo)
    {
        $this->documentItemRepository = $documentItemRepo;
    }

    /**
     * Display a listing of the DocumentItem.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->documentItemRepository->pushCriteria(new RequestCriteria($request));
        $documentItems = $this->documentItemRepository->all();

        return view('document_items.index')
            ->with('documentItems', $documentItems);
    }

    /**
     * Show the form for creating a new DocumentItem.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_items_add',Auth::user()->user_type_code)){

            return view('document_items.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_items.index'));
        }
    }

    /**
     * Store a newly created DocumentItem in storage.
     *
     * @param CreateDocumentItemRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentItemRequest $request)
    {
        $input = $request->all();

        $documentItem = $this->documentItemRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('documentItems.index'));
    }

    /**
     * Display the specified DocumentItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentItem = $this->documentItemRepository->findWithoutFail($id);

        if (empty($documentItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentItems.index'));
        }

        return view('document_items.show')->with('documentItem', $documentItem);
    }

    /**
     * Show the form for editing the specified DocumentItem.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_items_edit',Auth::user()->user_type_code)){

            $documentItem = $this->documentItemRepository->findWithoutFail($id);

            if (empty($documentItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentItems.index'));
            }

            return view('document_items.edit')->with('documentItem', $documentItem);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_items.index'));
        }
    }

    /**
     * Update the specified DocumentItem in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentItemRequest $request)
    {
        $documentItem = $this->documentItemRepository->findWithoutFail($id);

        if (empty($documentItem)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentItems.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou DocumentItem ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('document_items_edit', $descricao);


        $documentItem = $this->documentItemRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('documentItems.index'));
    }

    /**
     * Remove the specified DocumentItem from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_items_remove',Auth::user()->user_type_code)){
            
            $documentItem = $this->documentItemRepository->findWithoutFail($id);

            if (empty($documentItem)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentItems.index'));
            }

            $this->documentItemRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu DocumentItem ID: '.$id;
            $log = App\Models\Log::wlog('document_items_remove', $descricao);


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
        return Datatables::of(App\Models\DocumentItem::where('company_id', Auth::user()->company_id))->make(true);
    }
}
