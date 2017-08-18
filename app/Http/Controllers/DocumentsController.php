<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StoreDocument;
use Flash;
use Response;

use App;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $tipos = App\DocumentType::getDocTypes('030');
        return view('modulos.producao.addDocument')->with(['tipos' => $tipos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocument $request)
    {
        $cnt = App\Document::where('number',$request->input('number'))
                           ->where('document_status_id', '<>', 9)
                           ->where('document_type_code', $request->input('document_type_code'))
                           ->count();
        $erro = false;
        if($cnt == 0){
            $documento = new App\Document(['company_id' => 1,
                                        'number' => $request->input('number'),
                                        'document_status_id' => 0,
                                        'document_type_code' => $request->input('document_type_code')]);
            if($documento->save()){
                $msg = "Documento inserido com sucesso.";
            }else{
                $msg = "Falha ao inserir documento!";
                $erro = true;
            }
        }else{
            $msg = "Documento já existe!";
            $erro = true;
        }

        flash($msg, 'success');

        return redirect(route('documents.create'));
        //return view('modulos.producao.addDocument')->with(['tipos' => $tipos, 'msg' => $msg, 'erro' => $erro]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::find($id);
        return view('cars.show', array('car' => $car));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
