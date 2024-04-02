@extends('nav.nav')

@section('extra')
    <div class="container-fluid- mx-5" style="margin-top: 100px">
        <div class="row">
            <div class="col-12">
                @auth('web')
                    @php
                        $timeZone = Auth::getUser()->timezone;
                        date_default_timezone_set($timeZone);
                    @endphp
                    <div class="col-3">
                        <h3>Оставить отзыв</h3>
                        <form method="POST" action="{{ route('comments.add') }}">
                            @csrf
                            <div class="mb-3 mt-3">
                                <textarea id="InputComment" rows="7" class="form-control" name="comment" required></textarea>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                            <button type="submit" class="btn btn-secondary mt-3">Отправить</button>
                        </form>
                    </div>
                @endauth
                @guest
                    <p>Чтобы оставить отзыв, <a href="{{ route('register') }}">зарегистрируйтесь</a></p>
                @endguest
            </div>
        </div>
        <div class="row">
            <div class="col-6 mt-5">
                @if (count($comments) > 0)
                    @foreach ($comments as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $comment->user->name }}</h5>
                                <p class="card-text">{{ $comment->comment }}</p>
                                <p class="card-text"><small class="text-body-secondary"><em>Добавлен
                                            {{ date('d-m-Y H:i', $comment->date) }}</em></small></p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h6>Отзывы пока отсутствуют</h6>
                @endif
            </div>
        </div>
    </div>
@endsection
