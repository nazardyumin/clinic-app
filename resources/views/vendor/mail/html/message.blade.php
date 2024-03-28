<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
    <img src="https://blotos.ru/wp-content/uploads/f/b/d/fbdb60147c4e1e4b924f6b85991ae9e0.png" alt="App Logo" width="250px">
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ config('app.name') }}. {{ __('ru.All rights reserved.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
