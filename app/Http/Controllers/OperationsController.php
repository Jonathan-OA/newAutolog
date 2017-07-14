<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOperationsRequest;
use App\Http\Requests\UpdateOperationsRequest;
use App\Repositories\OperationsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class OperationsController extends AppBaseController
{
    /** @var  OperationsRepository */
    private $operationsRepository;

    public function __construct(OperationsRepository $operationsRepo)
    {
        $this->operationsRepository = $operationsRepo;
    }

    /**
     * Display a listing of the Operations.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->operationsRepository->pushCriteria(new RequestCriteria($request));
        $operations = $this->operationsRepository->all();

        return view('operations.index')
            ->with('operations', $operations);
    }

    /**
     * Show the form for creating a new Operations.
     *
     * @return Response
     */
    public function create()
    {   
        //Lista de modulos disponíveis para inserção da operação
        $modules = App\Module::where('module', 'Operações')
                              ->where('enabled', '1')
                              ->whereNotNull('submodule')
                              ->pluck('name','name');
        
        return view('operations.create')->with('modules', $modules);
    }

    /**
     * Store a newly created Operations in storage.
     *
     * @param CreateOperationsRequest $request
     *
     * @return Response
     */
    public function store(CreateOperationsRequest $request)
    {
        $input = $request->all();

        $operations = $this->operationsRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('operations.index'));
    }

    /**
     * Display the specified Operations.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $operations = $this->operationsRepository->findWithoutFail($id);

        if (empty($operations)) {
            Flash::error('Operations not found');

            return redirect(route('operations.index'));
        }

        return view('operations.show')->with('operations', $operations);
    }

    /**
     * Show the form for editing the specified Operations.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $operations = $this->operationsRepository->findWithoutFail($id);
       
        if (empty($operations)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('operations.index'));
        }

        //Lista de modulos disponíveis para inserção da operação
        $modules = App\Module::where('module', 'Operações')
                              ->where('enabled', '1')
                              ->whereNotNull('submodule')
                              ->pluck('name','name');

        return view('operations.edit')->with('operations', $operations)
                                      ->with('modules', $modules);
    }

    /**
     * Update the specified Operations in storage.
     *
     * @param  int              $id
     * @param UpdateOperationsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOperationsRequest $request)
    {
        $operations = $this->operationsRepository->findWithoutFail($id);

        if (empty($operations)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('operations.index'));
        }

        $operations = $this->operationsRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('operations.index'));
    }

    /**
     * Remove the specified Operations from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $operations = $this->operationsRepository->findWithoutFail($id);

        if (empty($operations)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('operations.index'));
        }

        $this->operationsRepository->delete($id);

        Flash::success(Lang::get('validation.delete_success'));

        return redirect(route('operations.index'));
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return Datatables::of(App\Models\Operations::query())->make(true);
    }
}
