<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLabelStatusRequest;
use App\Http\Requests\UpdateLabelStatusRequest;
use App\Repositories\LabelStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LabelStatusController extends AppBaseController
{
    /** @var  LabelStatusRepository */
    private $labelStatusRepository;

    public function __construct(LabelStatusRepository $labelStatusRepo)
    {
        $this->labelStatusRepository = $labelStatusRepo;
    }

    /**
     * Display a listing of the LabelStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->labelStatusRepository->pushCriteria(new RequestCriteria($request));
        $labelStatus = $this->labelStatusRepository->all();

        return view('label_status.index')
            ->with('labelStatus', $labelStatus);
    }

    /**
     * Show the form for creating a new LabelStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_status_add',Auth::user()->user_type_code)){

            return view('label_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('label_status.index'));
        }
    }

    /**
     * Store a newly created LabelStatus in storage.
     *
     * @param CreateLabelStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateLabelStatusRequest $request)
    {
        $input = $request->all();

        $labelStatus = $this->labelStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('labelStatus.index'));
    }

    /**
     * Display the specified LabelStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $labelStatus = $this->labelStatusRepository->findWithoutFail($id);

        if (empty($labelStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelStatus.index'));
        }

        return view('label_status.show')->with('labelStatus', $labelStatus);
    }

    /**
     * Show the form for editing the specified LabelStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_status_edit',Auth::user()->user_type_code)){

            $labelStatus = $this->labelStatusRepository->findWithoutFail($id);

            if (empty($labelStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelStatus.index'));
            }

            return view('label_status.edit')->with('labelStatus', $labelStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('label_status.index'));
        }
    }

    /**
     * Update the specified LabelStatus in storage.
     *
     * @param  int              $id
     * @param UpdateLabelStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLabelStatusRequest $request)
    {
        $labelStatus = $this->labelStatusRepository->findWithoutFail($id);

        if (empty($labelStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LabelStatus ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('label_status_edit', $descricao);


        $labelStatus = $this->labelStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('labelStatus.index'));
    }

    /**
     * Remove the specified LabelStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_status_remove',Auth::user()->user_type_code)){
            
            $labelStatus = $this->labelStatusRepository->findWithoutFail($id);

            if (empty($labelStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelStatus.index'));
            }

            $this->labelStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LabelStatus ID: '.$id;
            $log = App\Models\Log::wlog('label_status_remove', $descricao);


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
        return Datatables::of(App\Models\LabelStatus::all())->make(true);
    }
}
