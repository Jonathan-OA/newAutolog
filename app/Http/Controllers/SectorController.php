<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSectorRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Repositories\SectorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class SectorController extends AppBaseController
{
    /** @var  SectorRepository */
    private $sectorRepository;

    public function __construct(SectorRepository $sectorRepo)
    {
        $this->sectorRepository = $sectorRepo;
    }

    /**
     * Display a listing of the Sector.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->sectorRepository->pushCriteria(new RequestCriteria($request));
        $sectors = $this->sectorRepository->all();

        return view('locations.sectors.index')
            ->with('sectors', $sectors);
    }

    /**
     * Show the form for creating a new Sector.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('sectors_add',Auth::user()->user_type_code)){
             //Lista de depositos disponiveis
             $deposits = App\Models\Deposit::getDeposits();

            return view('locations.sectors.create')->with('deposits', $deposits);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('sectors.index'));
        }
    }

    /**
     * Store a newly created Sector in storage.
     *
     * @param CreateSectorRequest $request
     *
     * @return Response
     */
    public function store(CreateSectorRequest $request)
    {
        $input = $request->all();

        $sector = $this->sectorRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('sectors.index'));
    }

    /**
     * Display the specified Sector.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('sectors.index'));
        }

        return view('locations.sectors.show')->with('sector', $sector);
    }

    /**
     * Show the form for editing the specified Sector.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('sectors_edit',Auth::user()->user_type_code)){

            $sector = $this->sectorRepository->findWithoutFail($id);
            //Lista de depositos disponiveis
            $deposits = App\Models\Deposit::getDeposits();

            if (empty($sector)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('sectors.index'));
            }

            return view('locations.sectors.edit')->with('sector', $sector)
                                       ->with('deposits', $deposits);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('sectors.index'));
        }
    }

    /**
     * Update the specified Sector in storage.
     *
     * @param  int              $id
     * @param UpdateSectorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSectorRequest $request)
    {
        $sector = $this->sectorRepository->findWithoutFail($id);

        if (empty($sector)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('sectors.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Sector ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('sectors_edit', $descricao);

        //print_r($requestF);exit;
        $sector = $this->sectorRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('sectors.index'));
    }

    /**
     * Remove the specified Sector from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('sectors_remove',Auth::user()->user_type_code)){
            
            $sector = $this->sectorRepository->findWithoutFail($id);

            if (empty($sector)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('sectors.index'));
            }

            $this->sectorRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Sector ID: '.$id;
            $log = App\Models\Log::wlog('sectors_remove', $descricao);


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
        return DataTables::of(App\Models\Sector::where('company_id', Auth::user()->company_id))->make(true);
    }
}
