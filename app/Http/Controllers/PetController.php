<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Services\PetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    private $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index()
    {
        $response = $this->petService->indexPets();
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

        $response = $this->petService->showPet($validator, $id);

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

        $response = $this->petService->createPet($validator, $request);

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

        $response = $this->petService->showPet($validator, $id);

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

        $response = $this->petService->updatePet($validator, $request, $id);

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

        $response = $this->petService->deletePet($validator, $request, $id);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        return back()->with('successful', 'Great! You deleted pet #' . $id . ' entity!');
    }
}
