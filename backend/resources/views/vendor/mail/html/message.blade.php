<x-mail::layout>
<x-slot:header>
<x-mail::header :url="config('app.frontend_url')">
{{ $configuration?->name ?? config('app.name') }}
</x-mail::header>
</x-slot:header>

{!! $slot !!}

@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} {{ $configuration?->name ?? config('app.name') }}. {{ __('Todos os direitos reservados.') }}
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
