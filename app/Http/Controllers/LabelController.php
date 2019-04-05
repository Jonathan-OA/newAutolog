<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use App\Repositories\LabelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LabelController extends AppBaseController
{
    /** @var  LabelRepository */
    private $labelRepository;

    public function __construct(LabelRepository $labelRepo)
    {
        $this->labelRepository = $labelRepo;
    }

    /**
     * Display a listing of the Label.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->labelRepository->pushCriteria(new RequestCriteria($request));
        $labels = $this->labelRepository->findByField('company_id', Auth::user()->company_id);

        return view('labels.index')
            ->with('labels', $labels);
    }

    /**
     * Show the form for creating a new Label.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('labels_add',Auth::user()->user_type_code)){

            //Pega os status de etiqueta
            $status = App\Models\LabelStatus::getLabelStatus();
            return view('labels.create')->with('statusl',$status);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('labels.index'));
        }
    }

    /**
     * Store a newly created Label in storage.
     *
     * @param CreateLabelRequest $request
     *
     * @return Response
     */
    public function store(CreateLabelRequest $request)
    {
        $input = $request->all();

        $label = $this->labelRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('labels.index'));
    }

    /**
     * Display the specified Label.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $label = $this->labelRepository->findWithoutFail($id);

        if (empty($label)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labels.index'));
        }

        return view('labels.show')->with('label', $label);
    }

    /**
     * Show the form for editing the specified Label.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('labels_edit',Auth::user()->user_type_code)){

            $label = $this->labelRepository->findWithoutFail($id);

            //Pega os status de etiqueta
            $status = App\Models\LabelStatus::getLabelStatus();

            if (empty($label)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labels.index'));
            }

            return view('labels.edit')->with('label', $label)
                                      ->with('statusl', $status);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('labels.index'));
        }
    }

    /**
     * Update the specified Label in storage.
     *
     * @param  int              $id
     * @param UpdateLabelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLabelRequest $request)
    {
        $label = $this->labelRepository->findWithoutFail($id);

        if (empty($label)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labels.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Etiqueta ID: '.$id.' - Barcode: '.$requestF['barcode'].' - Fat: '.$requestF['prim_qty'].' - Sts: '.$requestF['label_status_id'];
        $log = App\Models\Log::wlog('labels_edit', $descricao);


        $label = $this->labelRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('labels.index'));
    }

    /**
     * Remove the specified Label from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('labels_remove',Auth::user()->user_type_code)){
            
            $label = $this->labelRepository->findWithoutFail($id);

            if (empty($label)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labels.index'));
            }

            $this->labelRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Label ID: '.$id;
            $log = App\Models\Log::wlog('labels_remove', $descricao);


            Flash::success(Lang::get('validation.delete_success'));
            return array(0,Lang::get('validation.delete_success'));

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array(1,Lang::get('validation.permission'));
        }    
    }

    /**
     * Tela de Rastreabilidade da Etiqueta
     *
     * @param  int $id
     *
     * @return Response
     */
    public function traceability($label_id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('labels_traceability',Auth::user()->user_type_code)){

            $activities = App\Models\Label::getTraceability($label_id);
            //print_r($activities);exit;
            if (empty($activities)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labels.index'));
            }

            return view('labels.traceability')->with('activities',  $activities);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('labels.index'));
        }
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return DataTables::of(App\Models\Label::where('company_id', Auth::user()->company_id))->make(true);
    }
}
