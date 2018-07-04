<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class DocumentController extends Controller
{
    /**
     * Realiza a liberação do documento
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function liberate($document_id)
    {
        $libDoc = App\Models\Document::liberate($document_id);
    }

}
