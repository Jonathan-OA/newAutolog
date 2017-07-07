<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSuppliersRequest;
use App\Http\Requests\UpdateSuppliersRequest;
use App\Repositories\SuppliersRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class SuppliersController extends AppBaseController
{
    /** @var  SuppliersRepository */
    private $suppliersRepository;

    public function __construct(SuppliersRepository $suppliersRepo)
    {
        $this->suppliersRepository = $suppliersRepo;
    }

    /**
     * Display a listing of the Suppliers.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->suppliersRepository->pushCriteria(new RequestCriteria($request));
        $suppliers = $this->suppliersRepository->all();

        return view('suppliers.index')
            ->with('suppliers', $suppliers);
    }

    /**
     * Show the form for creating a new Suppliers.
     *
     * @return Response
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created Suppliers in storage.
     *
     * @param CreateSuppliersRequest $request
     *
     * @return Response
     */
    public function store(CreateSuppliersRequest $request)
    {
        $input = $request->all();

        $suppliers = $this->suppliersRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('suppliers.index'));
    }

    /**
     * Display the specified Suppliers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $suppliers = $this->suppliersRepository->findWithoutFail($id);

        if (empty($suppliers)) {
            Flash::error('Suppliers not found');

            return redirect(route('suppliers.index'));
        }

        return view('suppliers.show')->with('suppliers', $suppliers);
    }

    /**
     * Show the form for editing the specified Suppliers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $suppliers = $this->suppliersRepository->findWithoutFail($id);

        if (empty($suppliers)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('suppliers.index'));
        }

        return view('suppliers.edit')->with('suppliers', $suppliers);
    }

    /**
     * Update the specified Suppliers in storage.
     *
     * @param  int              $id
     * @param UpdateSuppliersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSuppliersRequest $request)
    {
        $suppliers = $this->suppliersRepository->findWithoutFail($id);

        if (empty($suppliers)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('suppliers.index'));
        }

        $suppliers = $this->suppliersRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('suppliers.index'));
    }

    /**
     * Remove the specified Suppliers from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $suppliers = $this->suppliersRepository->findWithoutFail($id);

        if (empty($suppliers)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('suppliers.index'));
        }

        $this->suppliersRepository->delete($id);

        Flash::success(Lang::get('validation.delete_success'));

        return redirect(route('suppliers.index'));
    }

    /**
     * Get data from model 
     *
     */
    public function getData()
    {
        return Datatables::of(App\Models\Suppliers::query())->make(true);
    }
}
