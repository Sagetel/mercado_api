<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
use Illuminate\Support\Facades\Log;


class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::all();
        return $ads;
    }

    public function create(Request $request)
    {

    }
    public function store(Request $request)
    {
        $request->validate([
            'personal.phone' => 'required|string',
            'personal.tg' => 'required|string',
            'information.brand' => 'required|string',
            'information.model' => 'required|string',
            'information.gear' => 'required|string',
            'information.engine' => 'required|string',
            'information.year' => 'required|string',
            'information.type' => 'required|string',
            'information.volume' => 'required|string',
            'information.transmission' => 'required|string',
            'information.carBody' => 'required|string',
            'information.photo' => 'required|string',
            'information.mileage' => 'required|string',
            'information.price' => 'required|string',
            'information.description' => 'required|string',
        ]);
        
        $ad = new Ad();
        $ad->personal = [
            'phone' => $request->input('personal.phone'),
            'tg' => $request->input('personal.tg'),
        ];
        $ad->information = [
            'brand' => $request->input('information.brand'),
            'model' => $request->input('information.model'),
            'gear' => $request->input('information.gear'),
            'engine' => $request->input('information.engine'),
            'year' => $request->input('information.year'),
            'type' => $request->input('information.type'),
            'volume' => $request->input('information.volume'),
            'transmission' => $request->input('information.transmission'),
            'carBody' => $request->input('information.carBody'),
            'photo' => $request->input('information.photo'),
            'mileage' => $request->input('information.mileage'),
            'price' => $request->input('information.price'),
            'description' => $request->input('information.description'),
        ];
        $user = auth('api')->user();
        $userId = $user->id;
        $userName = $user->name;
        
        $ad->user = [
            'userId' => $userId,
            'userName' => $userName,
        ];
        Log::info($ad);    
        $ad->save();
        return response()->json(['message' => 'Объявленеи успешно создано', 'data' => $ad], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ad = Ad::find($id);
        if (!$ad) {
            return response()->json(['message' => 'Объявление не найдено'], 404);
        }
        return response()->json($ad, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
