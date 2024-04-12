@extends('admin.admin_nav')


@section('admin-extra')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-3">
            <form method="POST" action="{{ route('doctor.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="InputDoctor" class="form-label">Введите имя врача</label>
                    <input id="InputDoctor" type="text" class="form-control" name="name" aria-describedby="Input Doctor"
                        required autocomplete="name">
                </div>
                <div class="mb-3">
                    <label for="InputSpeciality" class="form-label">Выберите специалиста</label>
                    <select id="InputSpeciality" class="form-select" aria-label="Input Speciality" name="speciality_id">
                        <option value="0" selected>-- Не выбран --</option>
                        @foreach ($specialities as $speciality)
                            <option value="{{ $speciality->id }}">
                                {{ $speciality->speciality }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="PhotoDoctor" class="form-label">Добавьте фото врача (450х300)</label>
                    <input id="PhotoDoctor" type="file" class="form-control" aria-describedby="Photo Doctor"
                        accept="image/*" name="photo" required>
                </div>
                <div class="mb-3">
                    <label for="EmailDoctor" class="form-label">Введите e-mail врача</label>
                    <input id="EmailDoctor" type="email" class="form-control" aria-describedby="Email Doctor" name="email" required>
                </div>
                <button type="submit" class="btn btn-secondary mt-3">Добавить</button>
                @error('name')
                    <div id="DoctorErrorHelp" class="form-text text-danger mt-3">{{ $message }}</div>
                @enderror
                @error('email')
                    <div id="DoctorErrorHelp" class="form-text text-danger mt-3">{{ $message }}</div>
                @enderror
                @error('photo')
                    <div id="PhotoErrorHelp" class="form-text text-danger mt-3">{{ $message }}</div>
                @enderror
                @error('success')
                    <div id="DoctorSuccessHelp" class="form-text text-success mt-3">{{ $message }}</div>
                @enderror
                <div id="AjaxHelp" class="form-text text-danger mt-3"></div>
            </form>
        </div>

        <div class="col-12 col-md-12 col-lg-9 overflow-auto" style="height: 80vh;">
            <div class="container-fluid- mb-3">
                <table class="table table-lg">
                    <thead class="sticky-md-top" style="background-color: white">
                        <tr>
                            <td>ID</td>
                            <td>Врач</td>
                            <td>Специалист</td>
                            <td>Email</td>
                            <td>Фото (450х300)</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="DocTable">
                        @foreach ($doctors as $doctor)
                            <tr id="tr{{ $doctor->id }}">
                                <td>
                                    <p class="form-text">{{ $doctor->id }}</p>
                                </td>
                                <td>
                                    <input id="inputdoc-{{ $doctor->id }}" type="text" class="form-control"
                                        value="{{ $doctor->name }}" required>
                                </td>
                                <td style="width: 180px">
                                    <select id="specdoc-{{ $doctor->id }}" class="form-select"
                                        aria-label="Doc Speciality">
                                        @foreach ($specialities as $speciality)
                                            <option value="{{ $speciality->id }}"
                                                {{ $speciality->id == $doctor->speciality_id ? 'selected' : '' }}>
                                                {{ $speciality->speciality }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width: 250px">
                                    <input id="emaildoc-{{ $doctor->id }}" type="email" class="form-control"
                                    value="{{ $doctor->email }}" required>
                                </td>
                                <td style="width: 350px">
                                    <input id="photodoc-{{ $doctor->id }}" type="file" class="form-control"
                                        accept="image/*">
                                </td>
                                <td style="width: 30px">
                                    <button id="editdoc-{{ $doctor->id }}" class="btn btn-secondary DocEdit">
                                        <img id="imgedit{{ $doctor->id }}" src="{{ asset('images/edit.png') }}"
                                            alt="edit">
                                    </button>
                                </td>
                                <td style="width: 30px">
                                    <button id="{{ $doctor->id }}" class="btn btn-danger DocDelete">
                                        <img id="imgdelete{{ $doctor->id }}" src="{{ asset('images/delete.png') }}"
                                            alt="delete">
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
