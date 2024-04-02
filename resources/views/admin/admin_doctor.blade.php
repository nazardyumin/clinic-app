@extends('admin.admin_nav')


@section('admin-extra')
    <div class="row">
        <div class="col-3">
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
                    <label for="PhotoDoctor" class="form-label">Добавьте фото врача (1500х1000)</label>
                    <input id="PhotoDoctor" type="file" class="form-control" aria-describedby="Photo Doctor"
                        accept="image/*" name="photo" required>
                </div>
                <button type="submit" class="btn btn-secondary mt-3">Добавить</button>
                @error('name')
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

        <div class="col-8 overflow-auto mx-5" style="height: 75vh;">
            <div class="mb-3">
                <table class="table table-sm">
                    <thead class="sticky-md-top" style="background-color: white">
                        <tr>
                            <td>ID</td>
                            <td>Врач</td>
                            <td>Специалист</td>
                            <td>Фото (1500х1000)</td>
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
                                <td>
                                    <select id="specdoc-{{ $doctor->id }}" class="form-select"
                                        aria-label="Doc Speciality">
                                        @foreach ($specialities as $speciality)
                                            <option value="{{ $speciality->id }}"
                                                {{ $speciality->id == $doctor->speciality_id ? 'selected' : '' }}>
                                                {{ $speciality->speciality }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input id="photodoc-{{ $doctor->id }}" type="file" class="form-control"
                                        accept="image/*">
                                </td>
                                <td>
                                    <button id="editdoc-{{ $doctor->id }}" class="btn btn-secondary DocEdit">
                                        <img id="imgedit{{ $doctor->id }}" src="{{ asset('images/edit.png') }}"
                                            alt="edit">
                                    </button>
                                </td>
                                <td>
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
