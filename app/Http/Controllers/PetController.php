<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    public function index()
    {
        $response = Http::acceptJson()->get('https://petstore.swagger.io/v2/pet/findByStatus?status=available&status=pending&status=sold');
        return view('Pet.index', ['pets' => $response->collect()]);
    }

    /** 
     * Errors:
     * 400	Invalid ID supplied
     * 404	Pet not found
     * 405	Validation exception
    */
    public function show($id)
    {
        $validator = Validator::make(['id' => $id],['id' => 'integer']);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $response = Http::acceptJson()->get('https://petstore.swagger.io/v2/pet/' . $id);
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        return view('Pet.show', ['id' => $id, 'pet' => $response->collect()]);
    }

    public function create()
    {
        return view('Pet.create');
    }

    /** 
     * Errors:
     * 405	Invalid input
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),Pet::$rules);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput($request->all());
        }
        $response = Http::acceptJson()->post('https://petstore.swagger.io/v2/pet', $request->all());
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput($request->all());
        }
        return back()->with('successful', 'Great! You created new pet entity! New pet\'s id #' . $response->json()['id']);
    }

    /** 
     * Errors:
     * 400	Invalid ID supplied
     * 404	Pet not found
     * 405	Validation exception
    */
    public function edit($id)
    {
        $validator = Validator::make(['id' => $id],['id' => 'integer']);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $response = Http::acceptJson()->get('https://petstore.swagger.io/v2/pet/' . $id);
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        return view('Pet.edit', ['id' => $id, 'pet' => $response->collect()]);
    }

    /** 
     * Errors:
     * 400	Invalid ID supplied
     * 404	Pet not found
    */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),Pet::$rules);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $response = Http::acceptJson()->put('https://petstore.swagger.io/v2/pet', $request->all() + ['id' => $id]);
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        return back()->with('successful', 'Great! You updated pet #' . $id . ' entity!');
    }

    /** 
     * Errors:
     * 400	Invalid ID supplied
     * 404	Pet not found
    */
    public function delete(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], ['id' => 'integer']);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput($request->all());
        }
        $response = Http::acceptJson()->delete('https://petstore.swagger.io/v2/pet/' . $id, $request->all());
        $response->onError(fn ($err) => $validator->after(function ($validator) use ($err) {
            $validator->errors()->add(
                'server',
                json_decode($err->body(), true)['message']
            );
        }));
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        return back()->with('successful', 'Great! You deleted pet #' . $id . ' entity!');
    }
}
