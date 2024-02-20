<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;

class PetService
{
    const URL = 'https://petstore.swagger.io/v2/pet/';

    public function indexPets() : \Illuminate\Http\Client\Response
    {
        return Http::acceptJson()->get(self::URL . 'findByStatus?status=available&status=pending&status=sold');
    }

    public function createPet(Validator &$validator, $request) : \Illuminate\Http\Client\Response
    {
        $response = Http::acceptJson()->post(self::URL, $request->all());
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        return $response;
    }

    public function showPet(Validator &$validator, $id) : \Illuminate\Http\Client\Response
    {
        $response = Http::acceptJson()->get(self::URL . $id);
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        return $response;
    }

    public function updatePet(Validator &$validator, $request, $id) : \Illuminate\Http\Client\Response
    {
        $response = Http::acceptJson()->put(self::URL, $request->all() + ['id' => $id]);
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        return $response;
    }

    public function deletePet(Validator &$validator, $request, $id) : \Illuminate\Http\Client\Response
    {
        $response = Http::acceptJson()->delete(self::URL . $id, $request->all());
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        return $response;
    }
}
