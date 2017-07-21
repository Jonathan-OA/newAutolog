<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateParametersRequest;
use App\Http\Requests\UpdateParametersRequest;
use App\Repositories\ParametersRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class ParametersController extends AppBaseController
{
    /** @var  ParametersRepository */
    private $parametersRepository;

    public function __construct(ParametersRepository $parametersRepo)
    {
        $this->parametersRepository = $parametersRepo;
    }

    /**
     * Display a listing of the Parameters.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->parametersRepository->pushCriteria(new RequestCriteria($request));
        $parameters = $this->parametersRepository->all();

        return view('parameters.index')
            ->with('parameters', $parameters);
    }

    /**
     * Show the form for creating a new Parameters.
     *
     * @return Response
     */
    public function create()
    {
        return view('parameters.create');
    }

    /**
     * Store a newly created Parameters in storage.
     *
     * @param CreateParametersRequest $request
     *
     * @return Response
     */
    public function store(CreateParametersRequest $request)
    {
        $input = $request->all();

        $parameters = $this->parametersRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('parameters.index'));
    }

    /**
     * Display the specified Parameters.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            Flash::error('Parameters not found');

            return redirect(route('parameters.index'));
        }

        return view('parameters.show')->with('parameters', $parameters);
    }

    /**
     * Show the form for editing the specified Parameters.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('parameters.index'));
        }

        return view('parameters.edit')->with('parameters', $parameters);
    }

    /**
     * Update the specified Parameters in storage.
     *
     * @param  int              $id
     * @param UpdateParametersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParametersRequest $request)
    {
        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('parameters.index'));
        }

        $parameters = $this->parametersRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('parameters.index'));
    }

    /**
     * Remove the specified Parameters from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $parameters = $this->parametersRepository->findWithoutFail($id);

        if (empty($parameters)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('parameters.index'));
        }

        $this->parametersRepository->delete($id);

        Flash::success(Lang::get('validation.delete_success'));

        return redirect(route('parameters.index'));
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return Datatables::of(App\Models\Parameters::query())->make(true);
    }
}
