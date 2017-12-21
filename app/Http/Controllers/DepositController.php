<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepositRequest;
use App\Http\Requests\UpdateDepositRequest;
use App\Repositories\DepositRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class DepositController extends AppBaseController
{
    /** @var  DepositRepository */
    private $depositRepository;

    public function __construct(DepositRepository $depositRepo)
    {
        $this->depositRepository = $depositRepo;
    }

    /**
     * Display a listing of the Deposit.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->depositRepository->pushCriteria(new RequestCriteria($request));
        $deposits = $this->depositRepository->all();

        return view('deposits.index')
            ->with('deposits', $deposits);
    }

    /**
     * Show the form for creating a new Deposit.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('deposits_add',Auth::user()->user_type_code)){
            //Lista de departamentos disponiveis
            $departments = App\Models\Department::getDepartments();
            //Lista tipos de depositos
            $dep_types = App\Models\DepositType::getDepTypes();
            
            return view('deposits.create')->with('departments', $departments)
                                          ->with('dep_types', $dep_types);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('deposits.index'));
        }
    }

    /**
     * Store a newly created Deposit in storage.
     *
     * @param CreateDepositRequest $request
     *
     * @return Response
     */
    public function store(CreateDepositRequest $request)
    {
        $input = $request->all();

        $deposit = $this->depositRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('deposits.index'));
    }

    /**
     * Display the specified Deposit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $deposit = $this->depositRepository->findWithoutFail($id);

        if (empty($deposit)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('deposits.index'));
        }

        return view('deposits.show')->with('deposit', $deposit);
    }

    /**
     * Show the form for editing the specified Deposit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('deposits_edit',Auth::user()->user_type_code)){

            $deposit = $this->depositRepository->findWithoutFail($id);
            //Lista de departamentos disponiveis
            $departments = App\Models\Department::getDepartments();
            //Lista tipos de depositos
            $dep_types = App\Models\DepositType::getDepTypes();

            if (empty($deposit)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('deposits.index'));
            }

            return view('deposits.edit')->with('deposit', $deposit)
                                        ->with('departments', $departments)
                                        ->with('dep_types', $dep_types);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('deposits.index'));
        }
    }

    /**
     * Update the specified Deposit in storage.
     *
     * @param  int              $id
     * @param UpdateDepositRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepositRequest $request)
    {
        $deposit = $this->depositRepository->findWithoutFail($id);

        if (empty($deposit)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('deposits.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Deposit ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('deposits_edit', $descricao);


        $deposit = $this->depositRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('deposits.index'));
    }

    /**
     * Remove the specified Deposit from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('deposits_remove',Auth::user()->user_type_code)){
            
            $deposit = $this->depositRepository->findWithoutFail($id);

            if (empty($deposit)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('deposits.index'));
            }

            $this->depositRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Deposit ID: '.$id;
            $log = App\Models\Log::wlog('deposits_remove', $descricao);


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
        return Datatables::of(App\Models\Deposit::where('company_id', Auth::user()->company_id))->make(true);
    }
}
