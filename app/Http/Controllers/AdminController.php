<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Repositories\ActivityRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DataTables;
use App;
use App\Models\Company;
use Lang;

class AdminController extends AppBaseController
{

    /**
     * Relatório de Filials Sumarizado
     *
     * @param  int $id
     *
     * @return Response
     */
    public function reportBranch()
    {
        return view('admin.repBranchs');
    }

    //Busca os dados para o relatório de filiais (com filtros por data e sumarizado (sim / não))
    public function reportBranchDatatable($summarize = 0, $from = "0", $to = "0")
    {
        return Datatables::of(App\Models\InventoryItem::getInventorysByBranch($summarize,$from,$to))->make(true);
    }

    /**
     * Relatório de Filials Detalhado
     *
     * @param  int $id
     *
     * @return Response
     */
    public function reportBranchDet($branch)
    {
        $branch = Company::find($branch);
        return view('admin.repBranchsDet')->with("branch", $branch );
    }

    //Busca os dados para o relatório de filiais (com filtros por data e sumarizado (sim / não))
    public function reportBranchDetDatatable($branch, $from = "0", $to = "0")
    {
        return Datatables::of(App\Models\InventoryItem::getInventorys($branch,$from,$to))->make(true);
    }


}
