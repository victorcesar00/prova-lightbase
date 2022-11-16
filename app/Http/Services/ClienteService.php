<?php

namespace App\Http\Services;

use App\Models\Cliente;

class ClienteService {
    public function getCliente($id) {
        $cliente = Cliente::where('id', $id)->first();

        return $cliente;
    }

    public function createCliente($dto) {
        $cliente = new Cliente();

        $cliente->nome = $dto->nome;
        $cliente->telefone = $dto->telefone;
        $cliente->cpf = $dto->cpf;
        $cliente->placa = $dto->placa;

        $cliente->save();

        return $cliente;
    }

    public function editCliente(Cliente $cliente, $dto) {
        if(isset($dto->nome)) {
            $cliente->nome = $dto->nome;
        }

        if(isset($dto->telefone)) {
            $cliente->telefone = $dto->telefone;
        }

        if(isset($dto->cpf)) {
            $cliente->cpf = $dto->cpf;
        }

        if(isset($dto->placa)) {
            $cliente->placa = $dto->placa;
        }

        $cliente->save();

        return $cliente;
    }

    public function deleteCliente($id) {
        Cliente::where('id', $id)->delete();
    }

    public function getClientesByPlacaLastCharacter($character) {
        $clienteList = Cliente::where('placa', 'LIKE', "%$character")->get();

        return $clienteList;
    }
}
