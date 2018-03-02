<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovimentRequest;
use App\Http\Requests\UpdateMovimentRequest;
use App\Repositories\MovimentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class MovimentController extends AppBaseController
{
    /** @var  MovimentRepository */
    private $movimentRepository;

    public function __construct(MovimentRepository $movimentRepo)
    {
        $this->movimentRepository = $movimentRepo;
    }

    /**
     * Display a listing of the Moviment.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->movimentRepository->pushCriteria(new RequestCriteria($request));
        $moviments = $this->movimentRepository->all();

        return view('moviments.index')
            ->with('moviments', $moviments);
    }

    /**
     * Show the form for creating a new Moviment.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('moviments_add',Auth::user()->user_type_code)){

            return view('moviments.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('moviments.index'));
        }
    }

    /**
     * Store a newly created Moviment in storage.
     *
     * @param CreateMovimentRequest $request
     *
     * @return Response
     */
    public function store(CreateMovimentRequest $request)
    {
        $input = $request->all();

        $moviment = $this->movimentRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('moviments.index'));
    }

    /**
     * Display the specified Moviment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $moviment = $this->movimentRepository->findWithoutFail($id);

        if (empty($moviment)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('moviments.index'));
        }

        return view('moviments.show')->with('moviment', $moviment);
    }

    /**
     * Show the form for editing the specified Moviment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('moviments_edit',Auth::user()->user_type_code)){

            $moviment = $this->movimentRepository->findWithoutFail($id);

            if (empty($moviment)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('moviments.index'));
            }

            return view('moviments.edit')->with('moviment', $moviment);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('moviments.index'));
        }
    }

    /**
     * Update the specified Moviment in storage.
     *
     * @param  int              $id
     * @param UpdateMovimentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMovimentRequest $request)
    {
        $moviment = $this->movimentRepository->findWithoutFail($id);

        if (empty($moviment)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('moviments.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Moviment ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('moviments_edit', $descricao);


        $moviment = $this->movimentRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('moviments.index'));
    }

    /**
     * Remove the specified Moviment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('moviments_remove',Auth::user()->user_type_code)){
            
            $moviment = $this->movimentRepository->findWithoutFail($id);

            if (empty($moviment)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('moviments.index'));
            }

            $this->movimentRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Moviment ID: '.$id;
            $log = App\Models\Log::wlog('moviments_remove', $descricao);


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
        return Datatables::of(App\Models\Moviment::all())->make(true);
    }
}
