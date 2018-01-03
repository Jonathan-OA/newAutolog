<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDepositTypeRequest;
use App\Http\Requests\UpdateDepositTypeRequest;
use App\Repositories\DepositTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class DepositTypeController extends AppBaseController
{
    /** @var  DepositTypeRepository */
    private $depositTypeRepository;

    public function __construct(DepositTypeRepository $depositTypeRepo)
    {
        $this->depositTypeRepository = $depositTypeRepo;
    }

    /**
     * Display a listing of the DepositType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->depositTypeRepository->pushCriteria(new RequestCriteria($request));
        $depositTypes = $this->depositTypeRepository->all();

        return view('locations.deposit_types.index')
            ->with('depositTypes', $depositTypes);
    }

    /**
     * Show the form for creating a new DepositType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('deposit_types_add',Auth::user()->user_type_code)){

            return view('locations.deposit_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('deposit_types.index'));
        }
    }

    /**
     * Store a newly created DepositType in storage.
     *
     * @param CreateDepositTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateDepositTypeRequest $request)
    {
        $input = $request->all();

        $depositType = $this->depositTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('depositTypes.index'));
    }

    /**
     * Display the specified DepositType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $depositType = $this->depositTypeRepository->findWithoutFail($id);

        if (empty($depositType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('depositTypes.index'));
        }

        return view('locations.deposit_types.show')->with('depositType', $depositType);
    }

    /**
     * Show the form for editing the specified DepositType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('deposit_types_edit',Auth::user()->user_type_code)){

            $depositType = $this->depositTypeRepository->findWithoutFail($id);

            if (empty($depositType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('depositTypes.index'));
            }

            return view('locations.deposit_types.edit')->with('depositType', $depositType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('deposit_types.index'));
        }
    }

    /**
     * Update the specified DepositType in storage.
     *
     * @param  int              $id
     * @param UpdateDepositTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepositTypeRequest $request)
    {
        $depositType = $this->depositTypeRepository->findWithoutFail($id);

        if (empty($depositType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('depositTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou DepositType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('deposit_types_edit', $descricao);


        $depositType = $this->depositTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('depositTypes.index'));
    }

    /**
     * Remove the specified DepositType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('deposit_types_remove',Auth::user()->user_type_code)){
            
            $depositType = $this->depositTypeRepository->findWithoutFail($id);

            if (empty($depositType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('depositTypes.index'));
            }

            $this->depositTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu DepositType ID: '.$id;
            $log = App\Models\Log::wlog('deposit_types_remove', $descricao);


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
        return Datatables::of(App\Models\DepositType::all())->make(true);
    }
}
