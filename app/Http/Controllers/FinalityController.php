<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFinalityRequest;
use App\Http\Requests\UpdateFinalityRequest;
use App\Repositories\FinalityRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class FinalityController extends AppBaseController
{
    /** @var  FinalityRepository */
    private $finalityRepository;

    public function __construct(FinalityRepository $finalityRepo)
    {
        $this->finalityRepository = $finalityRepo;
    }

    /**
     * Display a listing of the Finality.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->finalityRepository->pushCriteria(new RequestCriteria($request));
        $finalities = $this->finalityRepository->all();

        return view('finalities.index')
            ->with('finalities', $finalities);
    }

    /**
     * Show the form for creating a new Finality.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('finalities_add',Auth::user()->user_type_code)){

            return view('finalities.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('finalities.index'));
        }
    }

    /**
     * Store a newly created Finality in storage.
     *
     * @param CreateFinalityRequest $request
     *
     * @return Response
     */
    public function store(CreateFinalityRequest $request)
    {
        $input = $request->all();

        $finality = $this->finalityRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('finalities.index'));
    }

    /**
     * Display the specified Finality.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $finality = $this->finalityRepository->findWithoutFail($id);

        if (empty($finality)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('finalities.index'));
        }

        return view('finalities.show')->with('finality', $finality);
    }

    /**
     * Show the form for editing the specified Finality.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('finalities_edit',Auth::user()->user_type_code)){

            $finality = $this->finalityRepository->findWithoutFail($id);

            if (empty($finality)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('finalities.index'));
            }

            return view('finalities.edit')->with('finality', $finality);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('finalities.index'));
        }
    }

    /**
     * Update the specified Finality in storage.
     *
     * @param  int              $id
     * @param UpdateFinalityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFinalityRequest $request)
    {
        $finality = $this->finalityRepository->findWithoutFail($id);

        if (empty($finality)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('finalities.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Finality ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('finalities_edit', $descricao);


        $finality = $this->finalityRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('finalities.index'));
    }

    /**
     * Remove the specified Finality from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('finalities_remove',Auth::user()->user_type_code)){
            
            $finality = $this->finalityRepository->findWithoutFail($id);

            if (empty($finality)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('finalities.index'));
            }

            $this->finalityRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Finality ID: '.$id;
            $log = App\Models\Log::wlog('finalities_remove', $descricao);


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
        return Datatables::of(App\Models\Finality::all())->make(true);
    }
}
