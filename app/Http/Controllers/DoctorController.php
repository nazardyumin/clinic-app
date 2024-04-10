<?php

namespace App\Http\Controllers;

use App\Mail\DocUserCreated;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Speciality;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => ['required', 'string'],
            'photo' => ['required', 'image', 'dimensions:min_width=450,min_height=300,max_width=450,max_height=300'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Doctor::class],
        ]);

        $password = Str::random(10);

        if ((int)$request->speciality_id > 0) {
            $photo = Storage::disk('images')->put('/docs', $data['photo']);
            $doctor = Doctor::create([
                'name' => $data['name'],
                'speciality_id' => $request->speciality_id,
                'photo' => 'images/'.$photo,
                'email' => $data['email'],
                'password' => Hash::make($password),
            ]);

            Mail::to($doctor)->send(new DocUserCreated($doctor, $password));

            return redirect(route('doctor.index'))->withErrors(['success' => 'Врач успешно добавлен']);
        }
        return redirect(route('doctor.index'))->withErrors(['name' => 'Специальность не выбрана'])->withInput();
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
                "photo" => ["required", "image", "dimensions:min_width=450,min_height=300,max_width=450,max_height=300"],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Doctor::class],
            ]);

            if ($data->fails('photo')) {
                return response()->json(['message' => 'Допустимое разрешение фото 450х300']);
            }
            if ($data->fails('email') && $request->email != $doctor->email) {
                return response()->json(['message' => 'Введен некорректный email']);
            }

            Storage::disk('images')->delete(mb_substr($doctor->photo, mb_strpos($doctor->photo, 'images/') + strlen('images/')));
            $photo = Storage::disk('images')->put('/docs', $request->photo);
            $doctor->photo = 'images/'.$photo;
            $doctor->name = $request->name;
            $doctor->speciality_id = $request->speciality_id;
            $doctor->email = $request->email;
            $doctor->save();
            return response()->json(['status' => 'OK']);
        } else {
            $data = Validator::make($request->all(), [
                "name" => ["required", "string"],
                "speciality_id" => ["numeric"],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . Doctor::class],
            ]);

            if ($data->fails('email') && $request->email != $doctor->email) {
                return response()->json(['message' => 'Введен некорректный email']);
            }

            $doctor->name = $request->name;
            $doctor->speciality_id = $request->speciality_id;
            $doctor->email = $request->email;
            $doctor->save();
            return response()->json(['status' => 'OK']);
        }
    }

    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);
        Storage::disk('images')->delete(mb_substr($doctor->photo, mb_strpos($doctor->photo, 'images/') + strlen('images/')));
        $doctor->delete();
        return response()->json(['status' => 'OK']);
    }
}
