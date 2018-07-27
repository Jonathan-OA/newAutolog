<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGridRequest;
use App\Http\Requests\UpdateGridRequest;
use App\Repositories\GridRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class GridController extends AppBaseController
{
    /** @var  GridRepository */
    private $gridRepository;

    public function __construct(GridRepository $gridRepo)
    {
        $this->gridRepository = $gridRepo;
    }

    /**
     * Display a listing of the Grid.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->gridRepository->pushCriteria(new RequestCriteria($request));
        $grids = $this->gridRepository->all();

        return view('grids.index')
            ->with('grids', $grids);
    }

    /**
     * Show the form for creating a new Grid.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('grids_add',Auth::user()->user_type_code)){

            return view('grids.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('grids.index'));
        }
    }

    /**
     * Store a newly created Grid in storage.
     *
     * @param CreateGridRequest $request
     *
     * @return Response
     */
    public function store(CreateGridRequest $request)
    {
        $input = $request->all();

        $grid = $this->gridRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('grids.index'));
    }

    /**
     * Display the specified Grid.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $grid = $this->gridRepository->findWithoutFail($id);

        if (empty($grid)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('grids.index'));
        }

        return view('grids.show')->with('grid', $grid);
    }

    /**
     * Show the form for editing the specified Grid.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('grids_edit',Auth::user()->user_type_code)){

            $grid = $this->gridRepository->findWithoutFail($id);

            if (empty($grid)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('grids.index'));
            }

            return view('grids.edit')->with('grid', $grid);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('grids.index'));
        }
    }

    /**
     * Update the specified Grid in storage.
     *
     * @param  int              $id
     * @param UpdateGridRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGridRequest $request)
    {
        $grid = $this->gridRepository->findWithoutFail($id);

        if (empty($grid)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('grids.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Grid ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('grids_edit', $descricao);


        $grid = $this->gridRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('grids.index'));
    }

    /**
     * Remove the specified Grid from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('grids_remove',Auth::user()->user_type_code)){
            
            $grid = $this->gridRepository->findWithoutFail($id);

            if (empty($grid)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('grids.index'));
            }

            $this->gridRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Grid ID: '.$id;
            $log = App\Models\Log::wlog('grids_remove', $descricao);


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
        return Datatables::of(App\Models\Grid::where('company_id', Auth::user()->company_id))->make(true);
    }
}
