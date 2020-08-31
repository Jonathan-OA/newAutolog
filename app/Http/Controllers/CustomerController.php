<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Repositories\CustomerRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class CustomerController extends AppBaseController
{
    /** @var  CustomerRepository */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepository = $customerRepo;
    }

    /**
     * Display a listing of the Customer.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->customerRepository->pushCriteria(new RequestCriteria($request));
        //$customers = $this->customerRepository->all();
        //Load dos itens é feito por datatable no index.blade.php

        return view('partners.customers.index');
    }

    /**
     * Show the form for creating a new Customer.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('customers_add',Auth::user()->user_type_code)){

            return view('partners.customers.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('customers.index'));
        }
    }

    /**
     * Store a newly created Customer in storage.
     *
     * @param CreateCustomerRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $input = $request->all();

        //Se o prefixo não for informado, quebra o nome e gera um automaticamente com as primeiras letras
        if(empty($input['prefix_code'])){
            $name = explode(" ",$input['name']);
            foreach($name as $key => $part){
                $ctr = ($key == 0) ? 2 : 1 ;
                $input['prefix_code'] .= strtoupper(substr($part,0,$ctr));
            }

            if(count($name) <= 1) $input['prefix_code'] .= strtoupper(substr($input['name'],-2));
        }

        $customer = $this->customerRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('customers.index'));
    }

    /**
     * Display the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('customers.index'));
        }

        return view('partners.customers.show')->with('customer', $customer);
    }

    /**
     * Show the form for editing the specified Customer.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('customers_edit',Auth::user()->user_type_code)){

            $customer = $this->customerRepository->findWithoutFail($id);

            if (empty($customer)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('customers.index'));
            }

            return view('partners.customers.edit')->with('customer', $customer);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('customers.index'));
        }
    }

    /**
     * Update the specified Customer in storage.
     *
     * @param  int              $id
     * @param UpdateCustomerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomerRequest $request)
    {
        $customer = $this->customerRepository->findWithoutFail($id);

        if (empty($customer)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('customers.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Customer ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('customers_edit', $descricao);

        //Se o prefixo não for informado, quebra o nome e gera um automaticamente com as primeiras letras
        if(empty($requestF['prefix_code'])){
            $name = explode(" ",$requestF['name']);
            foreach($name as $key => $part){
                $ctr = ($key == 0) ? 2 : 1 ;
                $requestF['prefix_code'] .= strtoupper(substr($part,0,$ctr));
            }

            if(count($name) <= 1) $requestF['prefix_code'] .= strtoupper(substr($requestF['name'],-2));
        }

        $customer = $this->customerRepository->update($requestF, $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('customers.index'));
    }

    /**
     * Remove the specified Customer from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('customers_remove',Auth::user()->user_type_code)){
            
            $customer = $this->customerRepository->findWithoutFail($id);

            if (empty($customer)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('customers.index'));
            }

            $this->customerRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Customer ID: '.$id;
            $log = App\Models\Log::wlog('customers_remove', $descricao);


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
        return DataTables::of(App\Models\Customer::where('company_id', Auth::user()->company_id))->make(true);
    }
}
