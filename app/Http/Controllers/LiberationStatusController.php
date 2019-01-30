<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLiberationStatusRequest;
use App\Http\Requests\UpdateLiberationStatusRequest;
use App\Repositories\LiberationStatusRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LiberationStatusController extends AppBaseController
{
    /** @var  LiberationStatusRepository */
    private $liberationStatusRepository;

    public function __construct(LiberationStatusRepository $liberationStatusRepo)
    {
        $this->liberationStatusRepository = $liberationStatusRepo;
    }

    /**
     * Display a listing of the LiberationStatus.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->liberationStatusRepository->pushCriteria(new RequestCriteria($request));
        $liberationStatus = $this->liberationStatusRepository->all();

        return view('liberation_status.index')
            ->with('liberationStatus', $liberationStatus);
    }

    /**
     * Show the form for creating a new LiberationStatus.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_status_add',Auth::user()->user_type_code)){

            return view('liberation_status.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('liberation_status.index'));
        }
    }

    /**
     * Store a newly created LiberationStatus in storage.
     *
     * @param CreateLiberationStatusRequest $request
     *
     * @return Response
     */
    public function store(CreateLiberationStatusRequest $request)
    {
        $input = $request->all();

        $liberationStatus = $this->liberationStatusRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('liberationStatus.index'));
    }

    /**
     * Display the specified LiberationStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $liberationStatus = $this->liberationStatusRepository->findWithoutFail($id);

        if (empty($liberationStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('liberationStatus.index'));
        }

        return view('liberation_status.show')->with('liberationStatus', $liberationStatus);
    }

    /**
     * Show the form for editing the specified LiberationStatus.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_status_edit',Auth::user()->user_type_code)){

            $liberationStatus = $this->liberationStatusRepository->findWithoutFail($id);

            if (empty($liberationStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('liberationStatus.index'));
            }

            return view('liberation_status.edit')->with('liberationStatus', $liberationStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('liberation_status.index'));
        }
    }

    /**
     * Update the specified LiberationStatus in storage.
     *
     * @param  int              $id
     * @param UpdateLiberationStatusRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLiberationStatusRequest $request)
    {
        $liberationStatus = $this->liberationStatusRepository->findWithoutFail($id);

        if (empty($liberationStatus)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('liberationStatus.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou LiberationStatus ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('liberation_status_edit', $descricao);


        $liberationStatus = $this->liberationStatusRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('liberationStatus.index'));
    }

    /**
     * Remove the specified LiberationStatus from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('liberation_status_remove',Auth::user()->user_type_code)){
            
            $liberationStatus = $this->liberationStatusRepository->findWithoutFail($id);

            if (empty($liberationStatus)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('liberationStatus.index'));
            }

            $this->liberationStatusRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LiberationStatus ID: '.$id;
            $log = App\Models\Log::wlog('liberation_status_remove', $descricao);


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
        return Datatables::of(App\Models\LiberationStatus::all())->make(true);
    }
}
