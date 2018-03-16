<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCourierRequest;
use App\Http\Requests\UpdateCourierRequest;
use App\Repositories\CourierRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class CourierController extends AppBaseController
{
    /** @var  CourierRepository */
    private $courierRepository;

    public function __construct(CourierRepository $courierRepo)
    {
        $this->courierRepository = $courierRepo;
    }

    /**
     * Display a listing of the Courier.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->courierRepository->pushCriteria(new RequestCriteria($request));
        $couriers = $this->courierRepository->all();

        return view('couriers.index')
            ->with('couriers', $couriers);
    }

    /**
     * Show the form for creating a new Courier.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('couriers_add',Auth::user()->user_type_code)){

            return view('couriers.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('couriers.index'));
        }
    }

    /**
     * Store a newly created Courier in storage.
     *
     * @param CreateCourierRequest $request
     *
     * @return Response
     */
    public function store(CreateCourierRequest $request)
    {
        $input = $request->all();

        $courier = $this->courierRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('couriers.index'));
    }

    /**
     * Display the specified Courier.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $courier = $this->courierRepository->findWithoutFail($id);

        if (empty($courier)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('couriers.index'));
        }

        return view('couriers.show')->with('courier', $courier);
    }

    /**
     * Show the form for editing the specified Courier.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('couriers_edit',Auth::user()->user_type_code)){

            $courier = $this->courierRepository->findWithoutFail($id);

            if (empty($courier)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('couriers.index'));
            }

            return view('couriers.edit')->with('courier', $courier);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('couriers.index'));
        }
    }

    /**
     * Update the specified Courier in storage.
     *
     * @param  int              $id
     * @param UpdateCourierRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCourierRequest $request)
    {
        $courier = $this->courierRepository->findWithoutFail($id);

        if (empty($courier)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('couriers.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Courier ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('couriers_edit', $descricao);


        $courier = $this->courierRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('couriers.index'));
    }

    /**
     * Remove the specified Courier from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('couriers_remove',Auth::user()->user_type_code)){
            
            $courier = $this->courierRepository->findWithoutFail($id);

            if (empty($courier)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('couriers.index'));
            }

            $this->courierRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Courier ID: '.$id;
            $log = App\Models\Log::wlog('couriers_remove', $descricao);


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
        return Datatables::of(App\Models\Courier::where('company_id', Auth::user()->company_id))->make(true);
    }
}
