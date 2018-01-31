<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConfigRequest;
use App\Http\Requests\UpdateConfigRequest;
use App\Repositories\ConfigRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Datatables;
use App;
use Lang;

class ConfigController extends AppBaseController
{
    /** @var  ConfigRepository */
    private $configRepository;

    public function __construct(ConfigRepository $configRepo)
    {
        $this->configRepository = $configRepo;
    }

    /**
     * Display a listing of the Config.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->configRepository->pushCriteria(new RequestCriteria($request));
        $configs = $this->configRepository->all();

        return view('configs.index')
            ->with('configs', $configs);
    }

    /**
     * Show the form for creating a new Config.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('configs_add',Auth::user()->user_type_code)){

            return view('configs.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('configs.index'));
        }
    }

    /**
     * Store a newly created Config in storage.
     *
     * @param CreateConfigRequest $request
     *
     * @return Response
     */
    public function store(CreateConfigRequest $request)
    {
        $input = $request->all();

        $config = $this->configRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('configs.index'));
    }

    /**
     * Display the specified Config.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $config = $this->configRepository->findWithoutFail($id);

        if (empty($config)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('configs.index'));
        }

        return view('configs.show')->with('config', $config);
    }

    /**
     * Show the form for editing the specified Config.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('configs_edit',Auth::user()->user_type_code)){
           
            $config = $this->configRepository->findWithoutFail($id);
           
            if (empty($config)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('configs.index'));
            }

            return view('configs.edit')->with('config', $config);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('configs.index'));
        }
    }

    /**
     * Update the specified Config in storage.
     *
     * @param  int              $id
     * @param UpdateConfigRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateConfigRequest $request)
    {
        $config = $this->configRepository->findWithoutFail($id);

        if (empty($config)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('configs.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Config ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('configs_edit', $descricao);


        $config = $this->configRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('configs.index'));
    }

    /**
     * Remove the specified Config from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('configs_remove',Auth::user()->user_type_code)){
            
            $config = $this->configRepository->findWithoutFail($id);

            if (empty($config)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('configs.index'));
            }

            $this->configRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Config ID: '.$id;
            $log = App\Models\Log::wlog('configs_remove', $descricao);


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
        return Datatables::of(App\Models\Config::all())->make(true);
    }
}
