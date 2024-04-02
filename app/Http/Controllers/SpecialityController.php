<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Speciality;

class SpecialityController extends Controller
{
    public function index()
    {
        $specialities = Speciality::all();
        return view('admin.admin_specialities', compact('specialities'));
    }

    public function create()
    {
        return redirect(route('home'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "speciality" => ["required", "string", "unique:specialities,speciality"]
        ]);

        Speciality::create([
            "speciality" => $data["speciality"]
        ]);

        return redirect(route('speciality.index'))->withErrors(['success' => 'Специалист успешно добавлен']);
    }

    public function show(string $id)
    {
        return redirect(route('home'));
    }

    public function edit(string $id)
    {
        return redirect(route('home'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            "speciality" => ["required", "string"]
        ]);
        $speciality = Speciality::find($id);
        $speciality->speciality = $data['speciality'];
        $speciality->save();
        $specialities = Speciality::all();
        return response()->json(['specialities' => $specialities]);
    }

    public function destroy(string $id)
    {
        $speciality = Speciality::find($id);
        $speciality->delete();
        $specialities = Speciality::all();
        return response()->json(['specialities' => $specialities]);
    }
}
