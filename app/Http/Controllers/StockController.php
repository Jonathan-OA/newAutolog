<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Repositories\StockRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;
use App\Models;

class StockController extends AppBaseController
{
    /** @var  StockRepository */
    private $stockRepository;

    public function __construct(StockRepository $stockRepo)
    {
        $this->stockRepository = $stockRepo;
    }

    /**
     * Display a listing of the Stock.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->stockRepository->pushCriteria(new RequestCriteria($request));
        $stocks = $this->stockRepository->all();

        return view('stocks.index')
            ->with('stocks', $stocks);
    }

    /**
     * Show the form for creating a new Stock.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('stocks_add',Auth::user()->user_type_code)){
            $finalities = App\Models\Finality::getFinalities();
            return view('stocks.create')->with('finalities', $finalities);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('stocks.index'));
        }
    }

    /**
     * Store a newly created Stock in storage.
     *
     * @param CreateStockRequest $request
     *
     * @return Response
     */
    public function store(CreateStockRequest $request)
    {
        $input = $request->all();

        $stock = $this->stockRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('stocks.index'));
    }

    /**
     * Display the specified Stock.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $stock = $this->stockRepository->findWithoutFail($id);

        if (empty($stock)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('stocks.index'));
        }

        return view('stocks.show')->with('stock', $stock);
    }

    /**
     * Show the form for editing the specified Stock.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('stocks_edit',Auth::user()->user_type_code)){

            $finalities = App\Models\Finality::getFinalities();

            $stock = $this->stockRepository->findWithoutFail($id);

            if (empty($stock)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('stocks.index'));
            }

            return view('stocks.edit')->with('stock', $stock)
                                      ->with('finalities',$finalities);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('stocks.index'));
        }
    }

    /**
     * Update the specified Stock in storage.
     *
     * @param  int              $id
     * @param UpdateStockRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStockRequest $request)
    {
        $stock = $this->stockRepository->findWithoutFail($id);

        if (empty($stock)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('stocks.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Stock ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('stocks_edit', $descricao);


        $stock = $this->stockRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('stocks.index'));
    }

    /**
     * Remove the specified Stock from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('stocks_remove',Auth::user()->user_type_code)){
            
            $stock = $this->stockRepository->findWithoutFail($id);

            if (empty($stock)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('stocks.index'));
            }

            $this->stockRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Stock ID: '.$id;
            $log = App\Models\Log::wlog('stocks_remove', $descricao);


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
        return Datatables::of(App\Models\Stock::where('company_id', Auth::user()->company_id))->make(true);
    }
}
