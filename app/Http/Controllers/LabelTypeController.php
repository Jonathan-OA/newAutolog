<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLabelTypeRequest;
use App\Http\Requests\UpdateLabelTypeRequest;
use App\Repositories\LabelTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LabelTypeController extends AppBaseController
{
    /** @var  LabelTypeRepository */
    private $labelTypeRepository;

    public function __construct(LabelTypeRepository $labelTypeRepo)
    {
        $this->labelTypeRepository = $labelTypeRepo;
    }

    /**
     * Display a listing of the LabelType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->labelTypeRepository->pushCriteria(new RequestCriteria($request));
        $labelTypes = $this->labelTypeRepository->all();

        return view('print.label_types.index')
            ->with('labelTypes', $labelTypes);
    }

    /**
     * Show the form for creating a new LabelType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_types_add',Auth::user()->user_type_code)){

            return view('print.label_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('labelTypes.index'));
        }
    }

    /**
     * Store a newly created LabelType in storage.
     *
     * @param CreateLabelTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateLabelTypeRequest $request)
    {
        $input = $request->all();

        $labelType = $this->labelTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('labelTypes.index'));
    }

    /**
     * Display the specified LabelType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $labelType = $this->labelTypeRepository->findWithoutFail($id);

        if (empty($labelType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelTypes.index'));
        }

        return view('print.label_types.show')->with('labelType', $labelType);
    }

    /**
     * Show the form for editing the specified LabelType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_types_edit',Auth::user()->user_type_code)){

            $labelType = $this->labelTypeRepository->findWithoutFail($id);

            if (empty($labelType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelTypes.index'));
            }

            return view('print.label_types.edit')->with('labelType', $labelType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('labelTypes.index'));
        }
    }

    /**
     * Update the specified LabelType in storage.
     *
     * @param  int              $id
     * @param UpdateLabelTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLabelTypeRequest $request)
    {
        $labelType = $this->labelTypeRepository->findWithoutFail($id);

        if (empty($labelType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LabelType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('label_types_edit', $descricao);


        $labelType = $this->labelTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('labelTypes.index'));
    }

    /**
     * Remove the specified LabelType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_types_remove',Auth::user()->user_type_code)){
            
            $labelType = $this->labelTypeRepository->findWithoutFail($id);

            if (empty($labelType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelTypes.index'));
            }

            $this->labelTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LabelType ID: '.$id;
            $log = App\Models\Log::wlog('label_types_remove', $descricao);


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
        return Datatables::of(App\Models\LabelType::where('company_id', Auth::user()->company_id))->make(true);
    }
}
