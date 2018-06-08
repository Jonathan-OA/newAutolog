<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Repositories\SupplierRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class SupplierController extends AppBaseController
{
    /** @var  SupplierRepository */
    private $supplierRepository;

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepository = $supplierRepo;
    }

    /**
     * Display a listing of the Supplier.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->supplierRepository->pushCriteria(new RequestCriteria($request));
        $suppliers = $this->supplierRepository->all();

        return view('partners.suppliers.index')
            ->with('suppliers', $suppliers);
    }

    /**
     * Show the form for creating a new Supplier.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('suppliers_add',Auth::user()->user_type_code)){

            return view('partners.suppliers.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('suppliers.index'));
        }
    }

    /**
     * Store a newly created Supplier in storage.
     *
     * @param CreateSupplierRequest $request
     *
     * @return Response
     */
    public function store(CreateSupplierRequest $request)
    {
        $input = $request->all();

        $supplier = $this->supplierRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('suppliers.index'));
    }

    /**
     * Display the specified Supplier.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $supplier = $this->supplierRepository->findWithoutFail($id);

        if (empty($supplier)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('suppliers.index'));
        }

        return view('partners.suppliers.show')->with('supplier', $supplier);
    }

    /**
     * Show the form for editing the specified Supplier.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('suppliers_edit',Auth::user()->user_type_code)){

            $supplier = $this->supplierRepository->findWithoutFail($id);

            if (empty($supplier)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('suppliers.index'));
            }

            return view('partners.suppliers.edit')->with('supplier', $supplier);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('suppliers.index'));
        }
    }

    /**
     * Update the specified Supplier in storage.
     *
     * @param  int              $id
     * @param UpdateSupplierRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSupplierRequest $request)
    {
        $supplier = $this->supplierRepository->findWithoutFail($id);

        if (empty($supplier)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('suppliers.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Supplier ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('suppliers_edit', $descricao);


        $supplier = $this->supplierRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('suppliers.index'));
    }

    /**
     * Remove the specified Supplier from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('suppliers_remove',Auth::user()->user_type_code)){
            
            $supplier = $this->supplierRepository->findWithoutFail($id);

            if (empty($supplier)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('.suppliers.index'));
            }

            $this->supplierRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Supplier ID: '.$id;
            $log = App\Models\Log::wlog('suppliers_remove', $descricao);


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
        return DataTables::of(App\Models\Supplier::where('company_id', Auth::user()->company_id))->make(true);
    }
}
