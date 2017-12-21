<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStockTypeRequest;
use App\Http\Requests\UpdateStockTypeRequest;
use App\Repositories\StockTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class StockTypeController extends AppBaseController
{
    /** @var  StockTypeRepository */
    private $stockTypeRepository;

    public function __construct(StockTypeRepository $stockTypeRepo)
    {
        $this->stockTypeRepository = $stockTypeRepo;
    }

    /**
     * Display a listing of the StockType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->stockTypeRepository->pushCriteria(new RequestCriteria($request));
        $stockTypes = $this->stockTypeRepository->all();

        return view('stock_types.index')
            ->with('stockTypes', $stockTypes);
    }

    /**
     * Show the form for creating a new StockType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('stock_types_add',Auth::user()->user_type_code)){

            return view('stock_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('stock_types.index'));
        }
    }

    /**
     * Store a newly created StockType in storage.
     *
     * @param CreateStockTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateStockTypeRequest $request)
    {
        $input = $request->all();

        $stockType = $this->stockTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('stockTypes.index'));
    }

    /**
     * Display the specified StockType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $stockType = $this->stockTypeRepository->findWithoutFail($id);

        if (empty($stockType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('stockTypes.index'));
        }

        return view('stock_types.show')->with('stockType', $stockType);
    }

    /**
     * Show the form for editing the specified StockType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('stock_types_edit',Auth::user()->user_type_code)){

            $stockType = $this->stockTypeRepository->findWithoutFail($id);

            if (empty($stockType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('stockTypes.index'));
            }

            return view('stock_types.edit')->with('stockType', $stockType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('stock_types.index'));
        }
    }

    /**
     * Update the specified StockType in storage.
     *
     * @param  int              $id
     * @param UpdateStockTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStockTypeRequest $request)
    {
        $stockType = $this->stockTypeRepository->findWithoutFail($id);

        if (empty($stockType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('stockTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou StockType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('stock_types_edit', $descricao);


        $stockType = $this->stockTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('stockTypes.index'));
    }

    /**
     * Remove the specified StockType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('stock_types_remove',Auth::user()->user_type_code)){
            
            $stockType = $this->stockTypeRepository->findWithoutFail($id);

            if (empty($stockType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('stockTypes.index'));
            }

            $this->stockTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu StockType ID: '.$id;
            $log = App\Models\Log::wlog('stock_types_remove', $descricao);


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
        return Datatables::of(App\Models\StockType::all())->make(true);
    }
}
