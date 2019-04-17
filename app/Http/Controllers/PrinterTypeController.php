<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePrinterTypeRequest;
use App\Http\Requests\UpdatePrinterTypeRequest;
use App\Repositories\PrinterTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class PrinterTypeController extends AppBaseController
{
    /** @var  PrinterTypeRepository */
    private $printerTypeRepository;

    public function __construct(PrinterTypeRepository $printerTypeRepo)
    {
        $this->printerTypeRepository = $printerTypeRepo;
    }

    /**
     * Display a listing of the PrinterType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->printerTypeRepository->pushCriteria(new RequestCriteria($request));
        $printerTypes = $this->printerTypeRepository->all();

        return view('printer_types.index')
            ->with('printerTypes', $printerTypes);
    }

    /**
     * Show the form for creating a new PrinterType.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('printer_types_add',Auth::user()->user_type_code)){

            return view('printer_types.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('printer_types.index'));
        }
    }

    /**
     * Store a newly created PrinterType in storage.
     *
     * @param CreatePrinterTypeRequest $request
     *
     * @return Response
     */
    public function store(CreatePrinterTypeRequest $request)
    {
        $input = $request->all();

        $printerType = $this->printerTypeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('printerTypes.index'));
    }

    /**
     * Display the specified PrinterType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $printerType = $this->printerTypeRepository->findWithoutFail($id);

        if (empty($printerType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('printerTypes.index'));
        }

        return view('printer_types.show')->with('printerType', $printerType);
    }

    /**
     * Show the form for editing the specified PrinterType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('printer_types_edit',Auth::user()->user_type_code)){

            $printerType = $this->printerTypeRepository->findWithoutFail($id);

            if (empty($printerType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('printerTypes.index'));
            }

            return view('printer_types.edit')->with('printerType', $printerType);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('printer_types.index'));
        }
    }

    /**
     * Update the specified PrinterType in storage.
     *
     * @param  int              $id
     * @param UpdatePrinterTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePrinterTypeRequest $request)
    {
        $printerType = $this->printerTypeRepository->findWithoutFail($id);

        if (empty($printerType)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('printerTypes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou PrinterType ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('printer_types_edit', $descricao);


        $printerType = $this->printerTypeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('printerTypes.index'));
    }

    /**
     * Remove the specified PrinterType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('printer_types_remove',Auth::user()->user_type_code)){
            
            $printerType = $this->printerTypeRepository->findWithoutFail($id);

            if (empty($printerType)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('printerTypes.index'));
            }

            $this->printerTypeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu PrinterType ID: '.$id;
            $log = App\Models\Log::wlog('printer_types_remove', $descricao);


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
        return Datatables::of(App\Models\PrinterType::all())->make(true);
    }
}