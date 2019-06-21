<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App;

use App\Http\Requests;

class ImportacaoGeralController extends Controller
{
    public function index(){

        ini_set('max_execution_time', 300);
        
        /*//DOCTIPS
        $doctips = DB::connection('sqlsrv')->table('doctip')->get();
        foreach($doctips as $doctip){

            try{
                //INSERE TIPO DE DOCUMENTO
                if(count(App\Models\DocumentType::where('code', $doctip->DOCTIP_CODIGO)->get()) == 0){
                    $newDt = new App\Models\DocumentType();
                    $newDt->code = $doctip->DOCTIP_CODIGO;
                    $newDt->description = $doctip->DOCTIP_DESCRICAO;
                    $newDt->moviment_code = $doctip->DOCTIP_MOVIMENTO;
                    $newDt->save();
                }
            }
            catch(Exception  $e){
                echo 'Erro ao inserir UNIDADE '.$doctip->UOMCAD_CODIGO;
            }
        }

        //UOMS
        $uomcads = DB::connection('sqlsrv')->table('uomcad')->get();
        foreach($uomcads as $uom){

            try{
                //INSERE UNIDADE
                if(count(App\Models\Uom::where('code', $uom->UOMCAD_CODIGO)->get()) == 0){
                    $newUom = new App\Models\Uom();
                    $newUom->code = $uom->UOMCAD_CODIGO;
                    $newUom->description = $uom->UOMCAD_DESCRICAO;
                    $newUom->save();
                }
            }
            catch(Exception  $e){
                echo 'Erro ao inserir UNIDADE '.$uom->UOMCAD_CODIGO;
            }
        }

        //TIPOS
        $prdtips = DB::connection('sqlsrv')->table('prdtip')->get();
        foreach($prdtips as $prdtip){

            try{
                //INSERE Tipo
                if(count(App\Models\ProductType::where('code', $prdtip->PRDTIP_CODIGO)->get()) == 0){
                    $newTip = new App\Models\ProductType();
                    $newTip->code = $prdtip->PRDTIP_CODIGO;
                    $newTip->description = $prdtip->PRDTIP_DESCRICAO;
                    $newTip->save();
                }
            }
            catch(Exception  $e){
                echo 'Erro ao inserir tipo '.$prdtip->PRDTIP_CODIGO;
            }
        }

        //GRUPOS
        $grupos = DB::connection('sqlsrv')->table('grupo')->get();
        foreach($grupos as $grupo){
            try{
                //INSERE Grupo
                if(count(App\Models\Group::where('code', $grupo->GRUPO_CODIGO)->get()) == 0){
                    $newGrp = new App\Models\Group();
                    $newGrp->company_id = Auth::user()->company_id;
                    $newGrp->code = $grupo->GRUPO_CODIGO;
                    $newGrp->description = $grupo->GRUPO_DESCRICAO;
                    $newGrp->product_type_code = $grupo->PRDTIP_CODIGO;
                    $newGrp->save();
                }
            }catch(Exception  $e){
                echo 'Erro ao inserir grupo '.$prdtip->GRUPO_CODIGO;
            }
        }

        
        //PRODUTOS
        $products = DB::connection('sqlsrv')->table('prdcad')->take(2000)->orderBy('PRDCAD_CODIGO', 'desc')->get();
        foreach($products as $product){
            //INSERE PRODUTO
            if(count(App\Models\Product::where('code', $product->PRDCAD_CODIGO)->get()) == 0){
                $newPrd = new App\Models\Product();
                $newPrd->company_id = Auth::user()->company_id;
                $newPrd->code = $product->PRDCAD_CODIGO;
                $newPrd->description = $product->PRDCAD_DESCRICAO;
                $newPrd->status = 1;
                $newPrd->product_type_code = $product->PRDTIP_CODIGO;
                $newPrd->group_code = $product->GRUPO_CODIGO;
                $newPrd->subgroup_code = $product->SUBGRP_CODIGO;
                $newPrd->phase_code = $product->PDFASE_CODIGO;
                $newPrd->save();

                //EMBALAGENS
                $packings = DB::connection('sqlsrv')->table('prdemb')->where('PRDCAD_CODIGO',$product->PRDCAD_CODIGO)->get();
                foreach($packings as $packing){
                    if(count(App\Models\Packing::where('product_code', $product->PRDCAD_CODIGO)
                                               ->where('uom_code', $packing->UOMCAD_CODIGO)->get()) == 0){
                        $newPack = new App\Models\Packing();
                        $newPack->company_id = Auth::user()->company_id;
                        $newPack->level = $packing->PRDEMB_NIVEL;
                        $newPack->product_code = $packing->PRDCAD_CODIGO;
                        $newPack->uom_code = $packing->UOMCAD_CODIGO;
                        $newPack->barcode = (trim($packing->PRDEMB_BARCODE) == '')? $newPack->product_code.$newPack->uom_code : $packing->PRDEMB_BARCODE;
                        $newPack->prev_qty = $packing->PRDEMB_FATORANT;
                        $newPack->prev_level = $packing->PRDEMB_NIVELANT;
                        $newPack->prim_qty = $packing->PRDEMB_FATOR1;
                        $newPack->label_type_code = 'PRODUTO';
                        $newPack->total_weight = $packing->PRDEMB_PESOBRUTO;
                        $newPack->total_net_weight = $packing->PRDEMB_PESOLIQ;
                        $newPack->print_label = (int)$packing->PRDEMB_IMPETQ;
                        $newPack->create_label = (int)$packing->PRDEMB_GERAID;
                        $newPack->conf_batch = (int)$packing->PRDEMB_CONFIRMALOTE;
                        $newPack->conf_weight = (int)$packing->PRDEMB_CONFIRMAPESO;
                        $newPack->conf_serial = (int)$packing->PRDEMB_CONFIRMANSERIE;
                        $newPack->conf_batch_supplier = (int)$packing->PRDEMB_CONFIRMALOTEFORNEC;
                        $newPack->conf_due_date = (int)$packing->PRDEMB_CONFIRMADATAVALID;
                        $newPack->conf_prod_date = (int)$packing->PRDEMB_CONFIRMADATAFABR;
                        $newPack->conf_length = 0;
                        $newPack->conf_width = 0;

                        $newPack->save();                            
                    }
                }
            }
        }

        
        */  
        //CLIENTES
        $clifors = DB::connection('sqlsrv')->table('clifor')->where('CLFTIP_CODIGO','CLIENTE')->get();
        foreach($clifors as $clifor){

            if($clifor->CLFTIP_CODIGO == 'FORNEC'){
                //INSERE FORNECEDOR
                if(count(App\Models\Supplier::where('code', $clifor->CLIFOR_CODIGO)->get()) == 0){
                    $newSupp = new App\Models\Supplier();
                    $newSupp->company_id = Auth::user()->company_id;
                    $newSupp->code = $clifor->CLIFOR_CODIGO;
                    $newSupp->name = $clifor->CLIFOR_RAZAO;
                    $newSupp->trading_name = $clifor->CLIFOR_FANTASIA;
                    $newSupp->cnpj = $clifor->CLIFOR_CNPJ;
                    $newSupp->state_registration = $clifor->CLIFOR_IE;
                    $newSupp->address = $clifor->CLIFOR_ENDERECO;
                    $newSupp->number = $clifor->CLIFOR_ENDNUMERO;
                    $newSupp->neighbourhood = $clifor->CLIFOR_BAIRRO;
                    $newSupp->zip_code = $clifor->CLIFOR_CEP;
                    $newSupp->city = $clifor->CLIFOR_CIDADE;
                    $newSupp->save();
                }

            }ELSE{
                //INSERE CLIENTE
                if(count(App\Models\Customer::where('code', $clifor->CLIFOR_CODIGO)->get()) == 0){
                    $newCust = new App\Models\Customer();
                    $newCust->company_id = Auth::user()->company_id;
                    $newCust->code = $clifor->CLIFOR_CODIGO;
                    $newCust->name = $clifor->CLIFOR_RAZAO;
                    $newCust->trading_name = $clifor->CLIFOR_FANTASIA;
                    $newCust->cnpj = $clifor->CLIFOR_CNPJ;
                    $newCust->state_registration = $clifor->CLIFOR_IE;
                    $newCust->address = $clifor->CLIFOR_ENDERECO;
                    $newCust->number = $clifor->CLIFOR_ENDNUMERO;
                    $newCust->neighbourhood = $clifor->CLIFOR_BAIRRO;
                    $newCust->zip_code = $clifor->CLIFOR_CEP;
                    $newCust->city = $clifor->CLIFOR_CIDADE;
                    $newCust->save();
                }


            }
            
        }      
        

        //Documentos
        $documents = DB::connection('sqlsrv')->table('doccab')->where('doctip_codigo','OP')->orderBy('DOCCAB_SEQ', 'desc')->get();
        //print_r($documents);
        $count = count($documents);
        foreach($documents as $document){
            $verif =  App\Models\Document::where('number', $document->DOCCAB_NUMERO)
                                         ->where('document_type_code',$document->DOCTIP_CODIGO)
                                         ->get()
                                         ->count();
            if($verif == 0){
                //INSERE DOCCAB
                $newDoc = new App\Models\Document();
                $newDoc->company_id = Auth::user()->company_id;
                $newDoc->number = $document->DOCCAB_NUMERO;
                $newDoc->user_id = 1;
                $newDoc->customer_code = $document->CLIFOR_CODIGO;
                $newDoc->emission_date = date('Y-m-d H:i:s');
                $newDoc->invoice = $document->DOCCAB_NF;
                $newDoc->document_type_code = $document->DOCTIP_CODIGO;
                $newDoc->document_status_id = $document->DOCCAB_STATUS;
                $newDoc->save();
            

                //Insere DOCITM
                $itens = DB::connection('sqlsrv')->table('docitm')->where('doccab_seq',$document->DOCCAB_SEQ)->get();
                foreach($itens as $item){
                    $newItem = new App\Models\DocumentItem();
                    $newItem->company_id = Auth::user()->company_id;
                    $newItem->document_id = $newDoc->id;
                    $newItem->product_code = $item->PRDCAD_CODIGO;
                    $newItem->qty = $item->DOCITM_QDE;
                    $newItem->qty_conf = $item->DOCITM_QDECONF;
                    $newItem->batch = $item->DOCITM_LOTE;
                    $newItem->batch = $item->DOCITM_LOTE;
                    $newItem->uom_code = $item->UOMCAD_CODIGO;
                    $newItem->document_status_id = $item->DOCITM_STATUS;
                    $newItem->save();
                }
            }
             echo $count.' Documentos Importados';
        }

        
    }
}
