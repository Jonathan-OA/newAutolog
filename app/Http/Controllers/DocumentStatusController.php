<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentStatusRequest;
use App\Http\Requests\UpdateDocumentStatusRequest;
use App\Repositories\DocumentStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class DocumentStatusController extends AppBaseController
{
    /** @var  DocumentStatusRepository */
    private $documentStatusRepository;

    public function __construct(DocumentStatusRepository $documentStatusRepo)
    {
        $this->documentStatusRepository = $documentStatusRepo;
    }

    /**
     * Display a listing of the DocumentStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->documentStatusRepository->pushCriteria(new RequestCriteria($request));
        $documentStatus = $this->documentStatusRepository->all();

        return view('document_status.index')
            ->with('documentStatus', $documentStatus);
    }

    /**
     * Show the form for creating a new DocumentStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_status_add',Auth::user()->user_type_code)){

            return view('document_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_status.index'));
        }
    }

    /**
     * Store a newly created DocumentStatus in storage.
     *
     * @param CreateDocumentStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentStatusRequest $request)
    {
        $input = $request->all();

        $documentStatus = $this->documentStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('documentStatus.index'));
    }

    /**
     * Display the specified DocumentStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentStatus = $this->documentStatusRepository->findWithoutFail($id);

        if (empty($documentStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentStatus.index'));
        }

        return view('document_status.show')->with('documentStatus', $documentStatus);
    }

    /**
     * Show the form for editing the specified DocumentStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_status_edit',Auth::user()->user_type_code)){

            $documentStatus = $this->documentStatusRepository->findWithoutFail($id);

            if (empty($documentStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentStatus.index'));
            }

            return view('document_status.edit')->with('documentStatus', $documentStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_status.index'));
        }
    }

    /**
     * Update the specified DocumentStatus in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentStatusRequest $request)
    {
        $documentStatus = $this->documentStatusRepository->findWithoutFail($id);

        if (empty($documentStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou DocumentStatus ID: '.$id.' - '.$requestF['description'];
        $log = App\Models\Log::wlog('document_status_edit', $descricao);


        $documentStatus = $this->documentStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('documentStatus.index'));
    }

    /**
     * Remove the specified DocumentStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_status_remove',Auth::user()->user_type_code)){
            
            $documentStatus = $this->documentStatusRepository->findWithoutFail($id);

            if (empty($documentStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentStatus.index'));
            }

            $this->documentStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu DocumentStatus ID: '.$id;
            $log = App\Models\Log::wlog('document_status_remove', $descricao);


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
        return Datatables::of(App\Models\DocumentStatus::all())->make(true);
    }
}
