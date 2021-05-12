<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLogRequest;
use App\Http\Requests\UpdateLogRequest;
use App\Repositories\LogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LogController extends AppBaseController
{
    /** @var  LogRepository */
    private $logRepository;

    public function __construct(LogRepository $logRepo)
    {
        $this->logRepository = $logRepo;
    }

    /**
     * Display a listing of the Log.
     *
     * @param Request $request
     * @return Response
     */
    public function index($operation = '', Request $request)
    {
        $this->logRepository->pushCriteria(new RequestCriteria($request));
        //$logs = $this->logRepository->all();

        return view('logs.index')
            ->with('operation', $operation);
    }

    /**
     * Show the form for creating a new Log.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('logs_add',Auth::user()->user_type_code)){

            return view('logs.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('logs.index'));
        }
    }

    /**
     * Store a newly created Log in storage.
     *
     * @param CreateLogRequest $request
     *
     * @return Response
     */
    public function store(CreateLogRequest $request)
    {
        $input = $request->all();

        $log = $this->logRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('logs.index'));
    }

    /**
     * Display the specified Log.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $log = $this->logRepository->findWithoutFail($id);

        if (empty($log)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('logs.index'));
        }

        return view('logs.show')->with('log', $log);
    }

    /**
     * Show the form for editing the specified Log.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('logs_edit',Auth::user()->user_type_code)){

            $log = $this->logRepository->findWithoutFail($id);

            if (empty($log)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('logs.index'));
            }

            return view('logs.edit')->with('log', $log);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('logs.index'));
        }
    }

    /**
     * Update the specified Log in storage.
     *
     * @param  int              $id
     * @param UpdateLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLogRequest $request)
    {
        $log = $this->logRepository->findWithoutFail($id);

        if (empty($log)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('logs.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Log ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('logs_edit', $descricao);


        $log = $this->logRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('logs.index'));
    }

    /**
     * Remove the specified Log from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('logs_remove',Auth::user()->user_type_code)){
            
            $log = $this->logRepository->findWithoutFail($id);

            if (empty($log)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('logs.index'));
            }

            $this->logRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Log ID: '.$id;
            $log = App\Models\Log::wlog('logs_remove', $descricao);


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
        return Datatables::of(App\Models\Log::select('description', 'logs.created_at', 'operation_code','users.code')
                                            ->join('users', 'users.id', '=', 'logs.user_id')
                                            ->where('logs.company_id', Auth::user()->company_id)
                                            )->make(true);
    }
}
