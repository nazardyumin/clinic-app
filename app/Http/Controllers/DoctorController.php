<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $specialities = Speciality::all();
        $doctors = Doctor::all();
        return view('admin.admin_doctor', ['specialities' => $specialities, 'doctors' => $doctors]);
    }

    public function show_doctors()
    {
        $doctors = Doctor::all();
        return view('doctors.doctors', compact('doctors'));
    }

    public function create()
    {
        return redirect(route('home'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "string"],
            "photo" => ["required", "image", "dimensions:min_width=1500,min_height=1000,max_width=1500,max_height=1000"]
        ]);

        if ((int)$request->speciality_id > 0) {
            $photo = Storage::disk('public')->put('images', $data['photo']);
            Doctor::create([
                "name" => $data["name"],
                "speciality_id" => $request->speciality_id,
                "photo" => 'storage/' . $photo
            ]);
            return redirect(route('doctor.index'))->withErrors(['success' => 'Врач успешно добавлен']);
        }
        return redirect(route('doctor.index'))->withErrors(['name' => 'Специальность не выбрана']);
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
        $doctor = Doctor::find($id);

        if ($request->has('photo')) {

            $data = Validator::make($request->all(), [
                "name" => ["required", "string"],
                "speciality_id" => ["numeric"],
                "photo" => ["required", "image", "dimensions:min_width=1500,min_height=1000,max_width=1500,max_height=1000"]
            ]);
            if ($data->fails()) {
                return response()->json(['message' => 'Допустимое разрешение фото 1500х1000']);
            }
            Storage::disk('public')->delete(mb_substr($doctor->photo, mb_strpos($doctor->photo, 'storage/') + strlen('storage/')));
            $photo = Storage::disk('public')->put('images', $request->photo);
            $doctor->photo = "storage/" . $photo;
            $doctor->name = $request->name;
            $doctor->speciality_id = $request->speciality_id;
            $doctor->save();
            return response()->json(['status' => 'OK']);
        } else {
            $data = $request->validate([
                "name" => ["required", "string"],
                "speciality_id" => ["numeric"]
            ]);
            $doctor->name = $data['name'];
            $doctor->speciality_id = $data['speciality_id'];
            $doctor->save();
            return response()->json(['status' => 'OK']);
        }
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);
        Storage::disk('public')->delete(mb_substr($doctor->photo, mb_strpos($doctor->photo, 'storage/') + strlen('storage/')));
        $doctor->delete();
        return response()->json(['status' => 'OK']);
    }
}
