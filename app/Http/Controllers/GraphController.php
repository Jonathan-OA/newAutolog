<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGraphRequest;
use App\Http\Requests\UpdateGraphRequest;
use App\Repositories\GraphRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class GraphController extends AppBaseController
{
    /** @var  GraphRepository */
    private $graphRepository;

    public function __construct(GraphRepository $graphRepo)
    {
        $this->graphRepository = $graphRepo;
    }

    /**
     * Display a listing of the Graph.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->graphRepository->pushCriteria(new RequestCriteria($request));
        $graphs = $this->graphRepository->all();

        return view('graphs.index')
            ->with('graphs', $graphs);
    }

    /**
     * Show the form for creating a new Graph.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('graphs_add',Auth::user()->user_type_code)){

            return view('graphs.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('graphs.index'));
        }
    }

    /**
     * Store a newly created Graph in storage.
     *
     * @param CreateGraphRequest $request
     *
     * @return Response
     */
    public function store(CreateGraphRequest $request)
    {
        $input = $request->all();

        $graph = $this->graphRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('graphs.index'));
    }

    /**
     * Display the specified Graph.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $graph = $this->graphRepository->findWithoutFail($id);

        if (empty($graph)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('graphs.index'));
        }

        return view('graphs.show')->with('graph', $graph);
    }

    /**
     * Show the form for editing the specified Graph.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('graphs_edit',Auth::user()->user_type_code)){

            $graph = $this->graphRepository->findWithoutFail($id);

            if (empty($graph)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('graphs.index'));
            }

            return view('graphs.edit')->with('graph', $graph);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('graphs.index'));
        }
    }

    /**
     * Update the specified Graph in storage.
     *
     * @param  int              $id
     * @param UpdateGraphRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGraphRequest $request)
    {
        $graph = $this->graphRepository->findWithoutFail($id);

        if (empty($graph)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('graphs.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Graph ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('graphs_edit', $descricao);


        $graph = $this->graphRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('graphs.index'));
    }

    /**
     * Remove the specified Graph from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('graphs_remove',Auth::user()->user_type_code)){
            
            $graph = $this->graphRepository->findWithoutFail($id);

            if (empty($graph)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('graphs.index'));
            }

            $this->graphRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Graph ID: '.$id;
            $log = App\Models\Log::wlog('graphs_remove', $descricao);


            Flash::success(Lang::get('validation.delete_success'));
            return array(0,Lang::get('validation.delete_success'));

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return array(1,Lang::get('validation.permission'));
        }    
    }

    /**
     * Retorna resultados dos gráficos cadastrados
     *
     * @param  int $id
     *
     * @return Response
     */
    public function getDataGraph($id)
    {
        return App\Models\Graph::getDataGraph($id);
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return Datatables::of(App\Models\Graph::where('company_id', Auth::user()->company_id))->make(true);
    }
}
