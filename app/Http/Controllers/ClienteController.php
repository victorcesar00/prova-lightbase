<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller {
    public function createCCliente(Request $request) {
        $dto = json_decode($request->getContent());


    }
}
