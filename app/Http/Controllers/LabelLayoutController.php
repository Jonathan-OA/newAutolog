<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLabelLayoutRequest;
use App\Http\Requests\UpdateLabelLayoutRequest;
use App\Repositories\LabelLayoutRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class LabelLayoutController extends AppBaseController
{
    /** @var  LabelLayoutRepository */
    private $labelLayoutRepository;

    public function __construct(LabelLayoutRepository $labelLayoutRepo)
    {
        $this->labelLayoutRepository = $labelLayoutRepo;
    }

    /**
     * Display a listing of the LabelLayout.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->labelLayoutRepository->pushCriteria(new RequestCriteria($request));
        $labelLayouts = $this->labelLayoutRepository->all();

        return view('print.label_layouts.index')
            ->with('labelLayouts', $labelLayouts);
    }

    /**
     * Show the form for creating a new LabelLayout.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_layouts_add',Auth::user()->user_type_code)){

            return view('print.label_layouts.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('label_layouts.index'));
        }
    }

    /**
     * Store a newly created LabelLayout in storage.
     *
     * @param CreateLabelLayoutRequest $request
     *
     * @return Response
     */
    public function store(CreateLabelLayoutRequest $request)
    {
        $input = $request->all();

        $labelLayout = $this->labelLayoutRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('labelLayouts.index'));
    }

    /**
     * Display the specified LabelLayout.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $labelLayout = $this->labelLayoutRepository->findWithoutFail($id);

        if (empty($labelLayout)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelLayouts.index'));
        }

        return view('print.label_layouts.show')->with('labelLayout', $labelLayout);
    }

    /**
     * Show the form for editing the specified LabelLayout.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_layouts_edit',Auth::user()->user_type_code)){

            $labelLayout = $this->labelLayoutRepository->findWithoutFail($id);

            if (empty($labelLayout)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelLayouts.index'));
            }

            return view('print.label_layouts.edit')->with('labelLayout', $labelLayout);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('label_layouts.index'));
        }
    }

    /**
     * Update the specified LabelLayout in storage.
     *
     * @param  int              $id
     * @param UpdateLabelLayoutRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLabelLayoutRequest $request)
    {
        $labelLayout = $this->labelLayoutRepository->findWithoutFail($id);

        if (empty($labelLayout)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('labelLayouts.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Layout de Etiqueta ID: '.$id.' - '.$requestF['code'].' Imp: '.$requestF['printer_type_code'];
        $log = App\Models\Log::wlog('label_layouts_edit', $descricao);


        $labelLayout = $this->labelLayoutRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('labelLayouts.index'));
    }

    /**
     * Remove the specified LabelLayout from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('label_layouts_remove',Auth::user()->user_type_code)){
            
            $labelLayout = $this->labelLayoutRepository->findWithoutFail($id);

            if (empty($labelLayout)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('labelLayouts.index'));
            }

            $this->labelLayoutRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu LabelLayout ID: '.$id;
            $log = App\Models\Log::wlog('label_layouts_remove', $descricao);


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
        return Datatables::of(App\Models\LabelLayout::where('company_id', Auth::user()->company_id))->make(true);
    }
}