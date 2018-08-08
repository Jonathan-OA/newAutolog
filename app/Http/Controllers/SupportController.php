<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSupportRequest;
use App\Http\Requests\UpdateSupportRequest;
use App\Repositories\SupportRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class SupportController extends AppBaseController
{
    /** @var  SupportRepository */
    private $supportRepository;

    public function __construct(SupportRepository $supportRepo)
    {
        $this->supportRepository = $supportRepo;
    }

    /**
     * Display a listing of the Support.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->supportRepository->pushCriteria(new RequestCriteria($request));
        $supports = $this->supportRepository->all();

        return view('supports.index')
            ->with('supports', $supports);
    }

    /**
     * Show the form for creating a new Support.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('supports_add',Auth::user()->user_type_code)){

            return view('supports.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('supports.index'));
        }
    }

    /**
     * Store a newly created Support in storage.
     *
     * @param CreateSupportRequest $request
     *
     * @return Response
     */
    public function store(CreateSupportRequest $request)
    {
        $input = $request->all();

        $support = $this->supportRepository->create($input);

        Flash::success(Lang::get('validation.support_success'));

        //Retorna para a index do modulo em questão
        $retorno = substr($input['url'], 0, strpos($input['url'],'.'));
        
        return redirect(route($retorno.'.index'));
    }

    /**
     * Display the specified Support.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $support = $this->supportRepository->findWithoutFail($id);

        if (empty($support)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('supports.index'));
        }

        return view('supports.show')->with('support', $support);
    }

    /**
     * Show the form for editing the specified Support.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('supports_edit',Auth::user()->user_type_code)){

            $support = $this->supportRepository->findWithoutFail($id);

            if (empty($support)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('supports.index'));
            }

            return view('supports.edit')->with('support', $support);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('supports.index'));
        }
    }

    /**
     * Update the specified Support in storage.
     *
     * @param  int              $id
     * @param UpdateSupportRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSupportRequest $request)
    {
        $support = $this->supportRepository->findWithoutFail($id);

        if (empty($support)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('supports.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Support ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('supports_edit', $descricao);


        $support = $this->supportRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('supports.index'));
    }

    /**
     * Remove the specified Support from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('supports_remove',Auth::user()->user_type_code)){
            
            $support = $this->supportRepository->findWithoutFail($id);

            if (empty($support)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('supports.index'));
            }

            $this->supportRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Support ID: '.$id;
            $log = App\Models\Log::wlog('supports_remove', $descricao);


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
        return Datatables::of(App\Models\Support::where('company_id', Auth::user()->company_id))->make(true);
    }
}
