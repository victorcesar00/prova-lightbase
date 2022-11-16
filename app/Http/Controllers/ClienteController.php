<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Services\ClienteService;

use App\Enums\ApiErrorCodesEnum;

class ClienteController extends Controller {
    private $clienteService;

    function __construct() {
        $this->clienteService = new ClienteService();
    }

    public function createCliente(Request $request) {
        $dto = json_decode($request->getContent());

        if(isset($dto->cpf)) {
            $dto->cpf = str_replace(['.', '-'], '', $dto->cpf);
        }

        if(isset($dto->placa)) {
            $dto->placa = str_replace([' ', '-'], '', $dto->placa);
        }

        $validator = Validator::make((array)$dto, [
            'nome' => 'required',
            'telefone' => 'required|unique:clientes',
            'cpf' => 'required|unique:clientes|digits:11',
            'placa' => 'required|unique:clientes|size:7'
        ]);

        if($validator->fails()) {
            return response(['errorCode' => ApiErrorCodesEnum::VALIDATION_ERROR, 'messages' => $validator->errors()->all()], 400);
        }

        $newCliente = $this->clienteService->createCliente($dto);

        return json_encode($newCliente);
    }

    public function editCliente($id, Request $request) {
        $dto = json_decode($request->getContent());

        if(isset($dto)) {
            $validator = Validator::make((array)$dto, [
                'telefone' => 'unique:clientes'.(isset($dto->telefone) ? ",telefone,$id" : ''),
                'cpf' => 'unique:clientes'.(isset($dto->cpf) ? ",cpf,$id" : '').'|digits:11',
                'placa' => 'unique:clientes'.(isset($dto->placa) ? ",placa,$id" : '').'|size:7'
            ]);

            if($validator->fails()) {
                return response(['errorCode' => ApiErrorCodesEnum::VALIDATION_ERROR, 'messages' => $validator->errors()->all()], 400);
            }

            $cliente = $this->clienteService->getCliente($id);

            if($cliente == NULL) {
                return response(['errorCode' => ApiErrorCodesEnum::NOT_FOUND, 'message' => 'Cliente not registered'], 404);
            }

            $editedCliente = $this->clienteService->editCliente($cliente, $dto);

            return json_encode($editedCliente);
        } else {
            return response(['errorCode' => ApiErrorCodesEnum::EMPTY_OBJECT, 'message' => 'Empty object provided'], 400);
        }
    }

    public function deleteCliente($id) {
        $cliente = $this->clienteService->getCliente($id);

        if($cliente == NULL) {
            return response(['errorCode' => ApiErrorCodesEnum::NOT_FOUND, 'message' => 'Cliente not registered'], 404);
        }

        $this->deleteCliente($id);

        return response('Cliente deleted successfully', 204);
    }

    public function getCliente($id) {
        $cliente = $this->clienteService->getCliente($id);

        if($cliente == NULL) {
            return response(['errorCode' => ApiErrorCodesEnum::NOT_FOUND, 'message' => 'Cliente not registered'], 404);
        }

        return json_encode($cliente);
    }

    public function getClientesByPlacaLastCharacter($character) {
        $clienteList = $this->clienteService->getClientesByPlacaLastCharacter($character);

        return json_encode($clienteList);
    }
}
