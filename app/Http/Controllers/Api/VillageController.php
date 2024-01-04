<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VillageRequest;
use App\Http\Resources\VillageCollection;
use App\Http\Resources\VillageResource;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index()
    {
        return VillageResource::collection(Village::paginate(20));
    }

    public function store(VillageRequest $request)
    {
        Village::create($request->all());

        return response()->json('Data desa berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $village = Village::find($id);
        if (!$village) {
            return response()->json('Data desa tidak ditemukan!');
        }
        return new VillageResource($village);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'code' => 'max:10|unique:indonesia_villages,code,' . $id,
            'district_code' => 'max:7',
            'name' => 'max:255',
            'meta' => 'nullable'
        ]);

        $village = Village::find($id);
        if (!$village) {
            return response()->json('Data desa tidak ditemukan!');
        }

        $village->update($validated);

        return response()->json('Data desa berhasil diperbaharui!');
    }
    public function destroy(string $id)
    {
        $village = Village::find($id);
        if (!$village) {
            return response()->json('Data desa tidak ditemukan!');
        }

        $village->delete();

        return response()->json('Data desa berhasil dihapus!');
    }
}
