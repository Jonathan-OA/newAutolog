<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParameterRequest;
use App\Http\Requests\UpdateParameterRequest;
use App\Repositories\ParameterRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class ParameterController extends AppBaseController
{
    /** @var  ParameterRepository */
    private $parameterRepository;

    public function __construct(ParameterRepository $parameterRepo)
    {
        $this->parameterRepository = $parameterRepo;
    }

    /**
     * Display a listing of the Parameter.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->parameterRepository->pushCriteria(new RequestCriteria($request));
        $parameters = $this->parameterRepository->all();

        return view('parameters.index')
            ->with('parameters', $parameters);
    }

    /**
     * Show the form for creating a new Parameter.
     *
     * @return Response
     */
    public function create()
    {
        //Lista de modulos disponíveis para inserção do parâmetro
        $modules = App\Models\Module::getModules();
        //Lista de operações disponíveis para inserção do parâmetro
        $operations = App\Models\Operation::getOperations();
        
        return view('parameters.create')->with('modules', $modules)
                                        ->with('operations',$operations);
    }

    /**
     * Store a newly created Parameter in storage.
     *
     * @param CreateParameterRequest $request
     *
     * @return Response
     */
    public function store(CreateParameterRequest $request)
    {
        $input = $request->all();

        $parameter = $this->parameterRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('parameters.index'));
    }

    /**
     * Display the specified Parameter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $parameter = $this->parameterRepository->findWithoutFail($id);

        if (empty($parameter)) {
            Flash::error('Parameter not found');

            return redirect(route('parameters.index'));
        }

        return view('parameters.show')->with('parameter', $parameter);
    }

    /**
     * Show the form for editing the specified Parameter.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $parameter = $this->parameterRepository->findWithoutFail($id);

        if (empty($parameter)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('parameters.index'));
        }

        //Lista de modulos disponíveis para inserção do parâmetro
        $modules = App\Models\Module::getModules();
        //Lista de operações disponíveis para inserção do parâmetro
        $operations = App\Models\Operation::getOperations();


        return view('parameters.edit')->with('parameter', $parameter)
                                      ->with('modules', $modules)
                                      ->with('operations', $operations);
    }

    /**
     * Update the specified Parameter in storage.
     *
     * @param  int              $id
     * @param UpdateParameterRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParameterRequest $request)
    {
        $parameter = $this->parameterRepository->findWithoutFail($id);

        if (empty($parameter)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('parameters.index'));
        }

        $parameter = $this->parameterRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('parameters.index'));
    }

    /**
     * Remove the specified Parameter from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $parameter = $this->parameterRepository->findWithoutFail($id);

        if (empty($parameter)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('parameters.index'));
        }

        $this->parameterRepository->delete($id);

        Flash::success(Lang::get('validation.delete_success'));

        return redirect(route('parameters.index'));
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return DataTables::of(App\Models\Parameter::where('company_id', Auth::user()->company_id))->make(true);
    }
}
