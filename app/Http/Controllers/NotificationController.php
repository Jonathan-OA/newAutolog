<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Repositories\NotificationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use Lang;

class NotificationController extends AppBaseController
{
    /** @var  NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepo)
    {
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Display a listing of the Notification.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->notificationRepository->pushCriteria(new RequestCriteria($request));
        $notifications = $this->notificationRepository->all();

        return view('notifications.index')
            ->with('notifications', $notifications);
    }

    /**
     * Show the form for creating a new Notification.
     *
     * @return Response
     */
    public function create()
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('notifications_add',Auth::user()->user_type_code)){

            return view('notifications.create');

        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('notifications.index'));
        }
    }

    /**
     * Store a newly created Notification in storage.
     *
     * @param CreateNotificationRequest $request
     *
     * @return Response
     */
    public function store(CreateNotificationRequest $request)
    {
        $input = $request->all();

        $notification = $this->notificationRepository->create($input);

        Flash::success(Lang::get('validation.save_success'));

        return redirect(route('notifications.index'));
    }

    /**
     * Display the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('notifications.index'));
        }

        return view('notifications.show')->with('notification', $notification);
    }

    /**
     * Show the form for editing the specified Notification.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('notifications_edit',Auth::user()->user_type_code)){

            $notification = $this->notificationRepository->findWithoutFail($id);

            if (empty($notification)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('notifications.index'));
            }

            return view('notifications.edit')->with('notification', $notification);
        
        }else{
            //Sem permissão
            Flash::error(Lang::get('validation.permission'));
            return redirect(route('notifications.index'));
        }
    }

    /**
     * Update the specified Notification in storage.
     *
     * @param  int              $id
     * @param UpdateNotificationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateNotificationRequest $request)
    {
        $notification = $this->notificationRepository->findWithoutFail($id);

        if (empty($notification)) {
            Flash::error(Lang::get('validation.not_found'));

            return redirect(route('notifications.index'));
        }

        //Grava log
        $requestF = $request->all();
        $descricao = 'Alterou Notification ID: '.$id.' - '.$requestF['code'];
        $log = App\Models\Log::wlog('notifications_edit', $descricao);


        $notification = $this->notificationRepository->update($request->all(), $id);

        Flash::success(Lang::get('validation.update_success'));

        return redirect(route('notifications.index'));
    }

    /**
     * Remove the specified Notification from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //Valida se usuário possui permissão para acessar esta opção
        if(App\Models\User::getPermission('notifications_remove',Auth::user()->user_type_code)){
            
            $notification = $this->notificationRepository->findWithoutFail($id);

            if (empty($notification)) {
                Flash::error(Lang::get('validation.not_found'));

                return redirect(route('notifications.index'));
            }

            $this->notificationRepository->delete($id);

             //Grava log
            $descricao = 'Excluiu Notification ID: '.$id;
            $log = App\Models\Log::wlog('notifications_remove', $descricao);


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
        return Datatables::of(App\Models\Notification::where('company_id', Auth::user()->company_id))->make(true);
    }
}