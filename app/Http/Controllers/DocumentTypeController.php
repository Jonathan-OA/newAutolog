<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentTypeRequest;
use App\Http\Requests\UpdateDocumentTypeRequest;
use App\Repositories\DocumentTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class DocumentTypeController extends AppBaseController
{
    /** @var  DocumentTypeRepository */
    private $documentTypeRepository;

    public function __construct(DocumentTypeRepository $documentTypeRepo)
    {
        $this->documentTypeRepository = $documentTypeRepo;
    }

    /**
     * Display a listing of the DocumentType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->documentTypeRepository->pushCriteria(new RequestCriteria($request));
        $documentTypes = $this->documentTypeRepository->all();

        return view('document_types.index')
            ->with('documentTypes', $documentTypes);
    }

    /**
     * Show the form for creating a new DocumentType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_types_add',Auth::user()->user_type_code)){
              //Pega todos os movimentos
            $moviments = App\Models\Moviment::getMoviments();    
            return view('document_types.create')->with('moviments',$moviments);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_types.index'));
        }
    }

    /**
     * Store a newly created DocumentType in storage.
     *
     * @param CreateDocumentTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateDocumentTypeRequest $request)
    {
        $input = $request->all();

        $documentType = $this->documentTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('documentTypes.index'));
    }

    /**
     * Display the specified DocumentType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $documentType = $this->documentTypeRepository->findWithoutFail($id);

        if (empty($documentType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentTypes.index'));
        }

        return view('document_types.show')->with('documentType', $documentType);
    }

    /**
     * Show the form for editing the specified DocumentType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_types_edit',Auth::user()->user_type_code)){

            $documentType = $this->documentTypeRepository->findWithoutFail($id);

            if (empty($documentType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentTypes.index'));
            }
            //Pega todos os movimentos
            $moviments = App\Models\Moviment::getMoviments();   
            return view('document_types.edit')->with('documentType', $documentType)
                                              ->with('moviments', $moviments);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('document_types.index'));
        }
    }

    /**
     * Update the specified DocumentType in storage.
     *
     * @param  int              $id
     * @param UpdateDocumentTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDocumentTypeRequest $request)
    {
        $documentType = $this->documentTypeRepository->findWithoutFail($id);

        if (empty($documentType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('documentTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou DocumentType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('document_types_edit', $descricao);


        $documentType = $this->documentTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('documentTypes.index'));
    }

    /**
     * Remove the specified DocumentType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('document_types_remove',Auth::user()->user_type_code)){
            
            $documentType = $this->documentTypeRepository->findWithoutFail($id);

            if (empty($documentType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('documentTypes.index'));
            }

            $this->documentTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu DocumentType ID: '.$id;
            $log = App\Models\Log::wlog('document_types_remove', $descricao);


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
        return Datatables::of(App\Models\DocumentType::all())->make(true);
    }
}