@extends('admin.admin_nav')

@section('admin-extra')
    <div class="row">
        <div class="col-12 col-md-12 col-lg-4">
            <form method="POST" action="{{ route('speciality.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="InputSpeciality" class="form-label">Введите специалиста</label>
                    <input id="InputSpeciality" type="text" class="form-control" name="speciality"
                        aria-describedby="Input Speciality" required>
                </div>
                <button type="submit" class="btn btn-secondary">Добавить</button>
                @error('speciality')
                    <div id="SpecialityErrorHelp" class="form-text text-danger mt-3">{{ $message }}</div>
                @enderror
                @error('success')
                    <div id="SpecialitySuccessHelp" class="form-text text-success mt-3">{{ $message }}</div>
                @enderror
            </form>
        </div>

        <div class="col-12 col-md-12 col-lg-4 overflow-auto mt-3" style="height: 75vh;">
            <div class="mb-3">
                <table class="table table-sm">
                    <thead class="sticky-md-top" style="background-color: white">
                        <tr>
                            <td>Специалист</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="SpecTable">
                        @foreach ($specialities as $speciality)
                            <tr>
                                <td>
                                    <input id="input-{{ $speciality->id }}" type="text" class="form-control"
                                        value="{{ $speciality->speciality }}" required>
                                </td>
                                <td>
                                    <button id="edit-{{ $speciality->id }}" class="btn btn-secondary SpecEdit">
                                        <img id="imgedit{{ $speciality->id }}" src="{{ asset('images/edit.png') }}"
                                            alt="edit">
                                    </button>
                                </td>
                                <td>
                                    <button id="{{ $speciality->id }}" class="btn btn-danger SpecDelete">
                                        <img id="imgdelete{{ $speciality->id }}" src="{{ asset('images/delete.png') }}"
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
