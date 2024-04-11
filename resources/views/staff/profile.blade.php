@extends('nav.nav-staff')
@inject('carbon', 'Carbon\Carbon')
@section('extra')
<div class="container-fluid- mx-5" style="margin-top: 100px">
    <div class="row mt-5">
        <h6>Ваши пациенты на {{$today->format('d.m.Y')}}:</h6>
        <hr>
        @if (count($appointments) > 0)

            <div class="col-12 col-md-12 col-lg-2 mt-3 overflow-auto" style="height: 82vh">

                <div class="d-grid gap-2 d-md-block">
                    @foreach ($appointments as $app)
                    @php
                        [$y, $m , $d, $h, $i] = explode('-', $app->date );
                        $app_date = $carbon::create($y, $m , $d, $h, $i, Auth::getUser()->timezone);
                    @endphp
                        @if($app->user())
                        <button type="button"
                            @if($app->date < $today->format('Y-m-d-H-i'))
                            disabled
                            class="btn btn-sm btn-secondary mb-3"
                            @else
                            class="btn btn-sm btn-primary mb-3"
                            @endif>
                            {{$app_date->format('H:i'). ' - '. $app->user()->last_name.' '.mb_substr($app->user()->first_name, 0, 1).'.'.mb_substr($app->user()->patronymic, 0, 1).'.'}}
                        </button>

                        @else
                        <button type="button"
                            @if($app->date < $today->format('Y-m-d-H-i'))
                            disabled
                            class="btn btn-sm btn-outline-secondary mb-3"
                            @else
                            class="btn btn-sm btn-outline-primary mb-3"
                            @endif>
                            {{$app_date->format('H:i'). ' - нет записи'}}
                        </button>

                        @endif
                    @endforeach
                </div>


            </div>

        @else
            <h6>У вас на сегодня нет пациентов</h6>
        @endif
    </div>
</div>
@endsection

{{-- <a href="#" class="btn btn-primary active" role="button" data-bs-toggle="button" aria-pressed="true">Active toggle link</a>
<a class="btn btn-primary disabled" aria-disabled="true" role="button" data-bs-toggle="button">Disabled toggle link</a> --}}
{{-- class="btn btn-outline-secondary" --}}
