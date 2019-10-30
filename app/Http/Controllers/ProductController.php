<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class ProductController extends AppBaseController
{
    /** @var  ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //Load dos itens é feito por datatable no index.blade.php
        return view('products.index');
    }

    /**
     * Show the form for creating a new Product.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('products_add',Auth::user()->user_type_code)){

            $prd_types = App\Models\ProductType::getProductTypes();
            $groups = App\Models\Group::getGroups();
            return view('products.create')->with('prd_types', $prd_types)
                                          ->with('groups',$groups);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('products.index'));
        }
    }

    /**
     * Store a newly created Product in storage.
     *
     * @param CreateProductRequest $request
     *
     * @return Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $input['margin_div'] = (float)$input['margin_div'];
        $input['cost'] = (float)$input['cost'];

        $product = $this->productRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('products.index'));
        }

        return view('products.show')->with('product', $product);
    }

    /**
     * Show the form for editing the specified Product.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('products_edit',Auth::user()->user_type_code)){

            $product = $this->productRepository->findWithoutFail($id);

            if (empty($product)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('products.index'));
            }

            //Tipos de produtos e grupos para o droplist
            $prd_types = App\Models\ProductType::getProductTypes();
            $groups = App\Models\Group::getGroups();
            
            return view('products.edit')->with('product', $product)
                                        ->with('prd_types', $prd_types)
                                        ->with('groups',$groups);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('products.index'));
        }
    }

    /**
     * Update the specified Product in storage.
     *
     * @param  int              $id
     * @param UpdateProductRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductRequest $request)
    {
        
        $product = $this->productRepository->findWithoutFail($id);

        if (empty($product)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('products.index'));
        }

        //Grava log
        $requestF = $request->all();
        $requestF['margin_div'] = (float)$requestF['margin_div'];
        $requestF['cost'] = (float)$requestF['cost'];

        $descricao = 'Alterou Product ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('products_edit', $descricao);


        $product = $this->productRepository->update($requestF, $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('products_remove',Auth::user()->user_type_code)){
            
            $product = $this->productRepository->findWithoutFail($id);

            if (empty($product)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('products.index'));
            }

            $this->productRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Product ID: '.$id;
            $log = App\Models\Log::wlog('products_remove', $descricao);


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
        return DataTables::of(App\Models\Product::where('company_id', Auth::user()->company_id))->make(true);
    }
}
