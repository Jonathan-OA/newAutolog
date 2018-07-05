<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlockedLocationRequest;
use App\Http\Requests\UpdateBlockedLocationRequest;
use App\Repositories\BlockedLocationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class BlockedLocationController extends AppBaseController
{
    /** @var  BlockedLocationRepository */
    private $blockedLocationRepository;

    public function __construct(BlockedLocationRepository $blockedLocationRepo)
    {
        $this->blockedLocationRepository = $blockedLocationRepo;
    }

    /**
     * Display a listing of the BlockedLocation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->blockedLocationRepository->pushCriteria(new RequestCriteria($request));
        $blockedLocations = $this->blockedLocationRepository->all();

        return view('blocked_locations.index')
            ->with('blockedLocations', $blockedLocations);
    }

    /**
     * Show the form for creating a new BlockedLocation.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_locations_add',Auth::user()->user_type_code)){

            return view('blocked_locations.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_locations.index'));
        }
    }

    /**
     * Store a newly created BlockedLocation in storage.
     *
     * @param CreateBlockedLocationRequest $request
     *
     * @return Response
     */
    public function store(CreateBlockedLocationRequest $request)
    {
        $input = $request->all();

        $blockedLocation = $this->blockedLocationRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('blockedLocations.index'));
    }

    /**
     * Display the specified BlockedLocation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $blockedLocation = $this->blockedLocationRepository->findWithoutFail($id);

        if (empty($blockedLocation)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedLocations.index'));
        }

        return view('blocked_locations.show')->with('blockedLocation', $blockedLocation);
    }

    /**
     * Show the form for editing the specified BlockedLocation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_locations_edit',Auth::user()->user_type_code)){

            $blockedLocation = $this->blockedLocationRepository->findWithoutFail($id);

            if (empty($blockedLocation)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedLocations.index'));
            }

            return view('blocked_locations.edit')->with('blockedLocation', $blockedLocation);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('blocked_locations.index'));
        }
    }

    /**
     * Update the specified BlockedLocation in storage.
     *
     * @param  int              $id
     * @param UpdateBlockedLocationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBlockedLocationRequest $request)
    {
        $blockedLocation = $this->blockedLocationRepository->findWithoutFail($id);

        if (empty($blockedLocation)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('blockedLocations.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou BlockedLocation ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('blocked_locations_edit', $descricao);


        $blockedLocation = $this->blockedLocationRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('blockedLocations.index'));
    }

    /**
     * Remove the specified BlockedLocation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('blocked_locations_remove',Auth::user()->user_type_code)){
            
            $blockedLocation = $this->blockedLocationRepository->findWithoutFail($id);

            if (empty($blockedLocation)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('blockedLocations.index'));
            }

            $this->blockedLocationRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu BlockedLocation ID: '.$id;
            $log = App\Models\Log::wlog('blocked_locations_remove', $descricao);


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
        return Datatables::of(App\Models\BlockedLocation::where('company_id', Auth::user()->company_id))->make(true);
    }
}
