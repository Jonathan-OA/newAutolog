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
use DataTables;
use App;
use Lang;
use App\Models;
use Input;

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
        $stocks = $this->stockRepository->findByField('company_id', Auth::user()->company_id);

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
            return view('stocks.entradaManual');
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
        
        //Valida se tem permissão para inserir saldo 
        if(App\Models\User::getPermission('stocks_add',Auth::user()->user_type_code)){
            $input = $request->all();

            //Valida endereço
            $retEnd = App\Models\Location::valLocation($input['location_code'], $input['product_code'], $input['prev_qty']);
            if($retEnd == 0){
                //Sem erros ao validar o endereço
                //Cria o palete caso não exista
                $palcb = $request->pltbarcode;
                if(empty($request->pallet_id) && !empty($palcb)){
                    $retPlt = App\Models\Pallet::createPallet($palcb,$input['location_code']);
                    if($retPlt['erro'] == 0){
                        $input['pallet_id'] = $retPlt['id'];
                    }else{
                        switch($retPlt['erro']){
                            case 1:
                                Flash::error(Lang::get('validation.plt_prefixo'));
                            break;
                            case 2:
                                Flash::error(Lang::get('validation.plt_exists'));
                            break;
                        }
                        return redirect(url('entradaManual'));
                    }
                }
               //Atualiza Saldo
               $stock = App\Models\Stock::updStock($input);
               //Cria tarefa e finaliza
               $task = App\Models\Task::create('664',$input['location_code'],$input['location_code']);
               $task->end();
               //Cria atividade
               $atv = App\Models\Activity::create($task->id,$input['label_id'],$input['pallet_id'],$input['prev_qty'],'Entrada de Saldo');

                //Grava log
               $descricao = 'Ent. Manual -  End:'.$input['location_code'].' Umv: '.$input['label_id'].' - Prd: '.$input['product_code'].' Qde: '.$input['qty'].'('. $input['prev_qty'].')';
               $log = App\Models\Log::wlog('stocks_add', $descricao);
   
               Flash::success(Lang::get('validation.save_success'));
            }else{
                switch($retEnd){
                    case 1:
                        //Endereço Inativo
                        Flash::error(Lang::get('validation.end_inativo'));
                    break;
                    case 2:
                        //Endereço Bloqueado para esse produto
                        Flash::error(Lang::get('validation.end_bloq'));
                    break;
                    case 3:
                        //Capacidade Excedida
                        Flash::error(Lang::get('validation.end_cap'));
                    break;
                }
                return redirect(url('entradaManual'));
            }
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
        }
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
            //Finalidades
            $finalities = App\Models\Finality::getFinalities();
            //Unidades de Medida
            $uoms = App\Models\Uom::getUoms();
            $stock = $this->stockRepository->findWithoutFail($id);

            if (empty($stock)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('stocks.index'));
            }

            return view('stocks.edit')->with('stock', $stock)
                                      ->with('finalities',$finalities)
                                      ->with('uoms',$uoms);
        
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
        $qdeOrg = ($stock->prev_qty*1);
        if (empty($stock)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('stocks.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Saldo ID: '.$id.' - End:'.$requestF['location_code'].' Umv: '.$requestF['label_id'].' - Prd: '.$requestF['product_code'].' Qde: '.$requestF['prev_qty'].'(Ant:'. $qdeOrg.')';
        $log = App\Models\Log::wlog('stocks_edit', $descricao);

        //Se tem palete, atualiza na pallet_items
        if(!empty($stock->pallet_id) && $stock->pallet_id>0){
            //Diminui da quantidade original para retirar o valor correto
            $stock->prev_qty = $requestF['prev_qty'] - $qdeOrg;
            $resPlt = App\Models\Pallet::updPallet($stock->toArray());
        }


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

            //Se tem palete, apaga da pallet_items
            if(!empty($stock->pallet_id) && $stock->pallet_id>0){
                $stock->prev_qty = $stock->prev_qty * -1;
                $resPlt = App\Models\Pallet::updPallet($stock->toArray());
            }

            //Grava log
            $descricao = 'Excluiu Saldo ID: '.$id.' - End:'.$stock->location_code.' Umv: '.$stock->label_id.' - Prd: '.$stock->product_code;
            $log = App\Models\Log::wlog('stocks_remove', $descricao);

            $this->stockRepository->delete($id);

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
        return DataTables::of(App\Models\Stock::where('company_id', Auth::user()->company_id))->make(true);
    }

    
    public function entradaManual()
    {
        $result =  App\Models\Product::valProduct('PRD01');
        if($result){
            print_r($result);
        }else{
            echo 'Produto Inválido';
        }
        
    }
}
