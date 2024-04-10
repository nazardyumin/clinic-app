@extends('nav.nav')
@inject('carbon', 'Carbon\Carbon')
@section('extra')
    <div class="container-fluid- mx-5" style="margin-top: 100px">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                @auth('web')
                    <div class="col-12 col-md-12 col-lg-4">
                        <h3>Оставить отзыв</h3>
                        <form method="POST" action="{{ route('comments.add') }}">
                            @csrf
                            <div class="mb-3 mt-3">
                                <textarea id="InputComment" rows="7" class="form-control" name="comment" required></textarea>
                            </div>
                            <span id="rateBar" style="padding: 0;">
                                @for ($i = 1; $i <= 5; $i++)
                                    <img id="{{ 'star' . $i }}" src="{{ asset('images/star(.png') }}" alt="'star"
                                        height="25px">
                                @endfor
                            </span><br>
                            <input id="starRate" type="hidden" name="rate" value="0">
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <button type="submit" class="btn btn-secondary mt-3">Отправить</button>
                        </form>
                    </div>
                @endauth
                @guest
                    <p>Чтобы оставить отзыв, необходимо <a href="{{ route('login') }}">авторизоваться</a>.</p>
                @endguest
            </div>
        </div>
        @guest
            <div class="row mt-5 overflow-auto" style="height: 77.5vh">
            @endguest
            @auth
                <div class="row mt-5 overflow-auto" style="height: 50vh">
                @endauth
                <div class="col-12 col-md-12 col-lg-6">
                    @if (count($comments) > 0)
                        @foreach ($comments as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $comment->user->first_name . ' ' . $comment->user->last_name }}
                                        @if ($comment->rate > 0)
                                            <span style="padding: 0; margin-left: 10px">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $comment->rate)
                                                        <img id="{{ 'star' . $i }}" src="{{ asset('images/star).png') }}"
                                                            alt="'star" height="15px" style="margin-bottom: 5px;">
                                                    @else
                                                        <img id="{{ 'star' . $i }}" src="{{ asset('images/star(.png') }}"
                                                            alt="'star" height="15px" style="margin-bottom: 5px;">
                                                    @endif
                                                @endfor
                                            </span>
                                        @endif
                                    </h5>
                                    <p class="card-text">{{ $comment->comment }}</p>
                                    @php
                                        $timeZone = 'Europe/Moscow';
                                        if (Auth::getUser()) {
                                            $timeZone = Auth::getUser()->timezone;
                                        }
                                        $commentDate = $carbon::parse($comment->date)->timezone($timeZone);
                                    @endphp
                                    <p class="card-text"><small class="text-body-secondary"><em>Добавлен
                                                {{ $commentDate->format('d.m.Y H:i') }}</em></small></p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h6 class="mt-5">Отзывы пока отсутствуют</h6>
                    @endif
                </div>
            </div>
        </div>
    @endsection
