<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVolumeRequest;
use App\Http\Requests\UpdateVolumeRequest;
use App\Repositories\VolumeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class VolumeController extends AppBaseController
{
    /** @var  VolumeRepository */
    private $volumeRepository;

    public function __construct(VolumeRepository $volumeRepo)
    {
        $this->volumeRepository = $volumeRepo;
    }

    /**
     * Display a listing of the Volume.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->volumeRepository->pushCriteria(new RequestCriteria($request));
        $volumes = $this->volumeRepository->findByField('company_id', Auth::user()->company_id);

        return view('volumes.index')
            ->with('volumes', $volumes);
    }

    /**
     * Show the form for creating a new Volume.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volumes_add',Auth::user()->user_type_code)){

             //Pega todas as embalagens
             $packingTypes = App\Models\PackingType::getPackingTypes();

             //Pega todos os status de volume
             $volumeStatus = App\Models\VolumeStatus::getVolumesStatus();

            return view('volumes.create')->with('packingTypes',$packingTypes)                
                                         ->with('volumeStatus',$volumeStatus);

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('volumes.index'));
        }
    }

    /**
     * Store a newly created Volume in storage.
     *
     * @param CreateVolumeRequest $request
     *
     * @return Response
     */
    public function store(CreateVolumeRequest $request)
    {
        $input = $request->all();

        $volume = $this->volumeRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('volumes.index'));
    }

    /**
     * Display the specified Volume.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $volume = $this->volumeRepository->findWithoutFail($id);

        if (empty($volume)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('volumes.index'));
        }

        return view('volumes.show')->with('volume', $volume);
    }

    /**
     * Show the form for editing the specified Volume.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volumes_edit',Auth::user()->user_type_code)){

            $volume = $this->volumeRepository->findWithoutFail($id);
            
             //Pega todas as embalagens
             $packingTypes = App\Models\PackingType::getPackingTypes();

             //Pega todos os status de volume
             $volumeStatus = App\Models\VolumeStatus::getVolumesStatus();

            if (empty($volume)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('volumes.index'));
            }

            return view('volumes.edit')->with('volume', $volume)
                                       ->with('packingTypes', $packingTypes)
                                       ->with('volumeStatus', $volumeStatus);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('volumes.index'));
        }
    }

    /**
     * Update the specified Volume in storage.
     *
     * @param  int              $id
     * @param UpdateVolumeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVolumeRequest $request)
    {
        $volume = $this->volumeRepository->findWithoutFail($id);

        if (empty($volume)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('volumes.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Volume ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('volumes_edit', $descricao);


        $volume = $this->volumeRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('volumes.index'));
    }

    /**
     * Remove the specified Volume from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('volumes_remove',Auth::user()->user_type_code)){
            
            $volume = $this->volumeRepository->findWithoutFail($id);

            if (empty($volume)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('volumes.index'));
            }

            $this->volumeRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Volume ID: '.$id;
            $log = App\Models\Log::wlog('volumes_remove', $descricao);


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
        return Datatables::of(App\Models\Volume::where('company_id', Auth::user()->company_id))->make(true);
    }
}
