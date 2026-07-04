<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Treino - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @page { margin: 5mm 0; }
        body { font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
        .page-break { page-break-after: always; }
        .page-break:last-child { page-break-after: auto; }
    </style>
</head>
<body>
    @foreach ($trainingSheet->divisions as $division)
    @php
        $count = $division->exercises->count();
        $tableSize = $count <= 4 ? 'text-base' : ($count <= 8 ? 'text-sm' : 'text-xs');
        $headSize = $count <= 4 ? 'text-xs' : ($count <= 8 ? 'text-[11px]' : 'text-[10px]');
        $bodySize = $count <= 4 ? 'text-sm' : ($count <= 8 ? 'text-xs' : 'text-[11px]');
        $cellPad = $count <= 4 ? 'py-3' : ($count <= 8 ? 'py-2.5' : 'py-2');
    @endphp
    <div class="max-w-4xl mx-auto page-break">
        <div class="relative bg-linear-to-r from-brand-500 to-brand-700 px-8 pt-8 pb-6 overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, white 0%, transparent 50%), radial-gradient(circle at 80% 20%, white 0%, transparent 50%);"></div>

            <div class="relative z-10 pt-4">
                <div class="absolute left-0 bottom-0">
                    <img
                        src="data:image/png;base64,{{ $image }}"
                        alt="Ficha de Treino"
                        style="width: 110px;"
                        class="rounded-lg"
                    >
                </div>
                <div class="absolute right-0 bottom-0 text-right">
                    <p class="text-black/60 text-xs uppercase tracking-[0.2em] font-semibold">
                        Ficha
                    </p>
                    <p class="text-white font-mono text-sm font-bold mt-0.5">
                        #{{ $trainingSheet->id }}
                    </p>
                </div>
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-black tracking-tight leading-tight">
                        {{ $company->name ?? config('app.name') }}
                    </h1>
                    <p class="text-white/80 text-sm mt-0.5 tracking-wide font-medium">
                        Ficha de Treino &mdash; {{ $trainingSheet->name }}
                    </p>
                </div>
            </div>
        </div>

        <div class="px-8 pb-6">
            <div class="bg-white rounded-xl border border-zinc-200 px-6 py-3 mb-5">
                <div class="grid grid-cols-3 gap-6 text-sm">
                    <div>
                        <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Aluno</span>
                        <p class="font-bold text-zinc-900">{{ $trainingSheet->student->name }}</p>
                        <p class="text-xs text-zinc-500">{{ $trainingSheet->student->email ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Código</span>
                        <p class="font-mono font-bold text-zinc-800">{{ $trainingSheet->student->code }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] font-semibold text-zinc-400 uppercase tracking-wider">Período</span>
                        <p class="font-semibold text-zinc-800">
                            {{ $trainingSheet->start_date?->format('d/m/Y') ?? '—' }} a {{ $trainingSheet->end_date?->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden border border-zinc-200">
                <div class="bg-zinc-800 px-4 py-2 flex items-center justify-between">
                    <h3 class="font-semibold text-zinc-100 text-xs uppercase tracking-wider flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-brand-400 rounded-full inline-block"></span>
                        Treino {{ $division->trainingDivision?->name ?? '—' }}
                    </h3>
                    <span class="text-[10px] text-zinc-400">{{ $count }} {{ $count === 1 ? 'exercício' : 'exercícios' }}</span>
                </div>
                <table class="w-full {{ $tableSize }}">
                    <thead>
                        <tr class="bg-zinc-50">
                            <th class="text-left px-2 {{ $headSize }} py-1.5 font-semibold text-zinc-500 uppercase tracking-wider w-8">#</th>
                            <th class="text-left px-2 {{ $headSize }} py-1.5 font-semibold text-zinc-500 uppercase tracking-wider">Exercício</th>
                            <th class="text-center px-1 {{ $headSize }} py-1.5 font-semibold text-zinc-500 uppercase tracking-wider">Séries</th>
                            <th class="text-center px-1 {{ $headSize }} py-1.5 font-semibold text-zinc-500 uppercase tracking-wider">Repetições</th>
                            <th class="text-center px-1 {{ $headSize }} py-1.5 font-semibold text-zinc-500 uppercase tracking-wider">Descanso</th>
                            <th class="text-center px-1 {{ $headSize }} py-1.5 font-semibold text-zinc-500 uppercase tracking-wider">Carga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($division->exercises as $exercise)
                        <tr class="border-t border-zinc-100">
                            <td class="px-2 {{ $bodySize }} {{ $cellPad }} text-zinc-400 font-mono">{{ $exercise->order }}</td>
                            <td class="px-2 {{ $bodySize }} {{ $cellPad }} text-zinc-800 font-medium">{{ $exercise->exercise?->name ?? '—' }}</td>
                            <td class="px-1 {{ $bodySize }} {{ $cellPad }} text-center font-mono text-zinc-700">{{ $exercise->series ?? '—' }}</td>
                            <td class="px-1 {{ $bodySize }} {{ $cellPad }} text-center font-mono text-zinc-700">{{ $exercise->repetitions ?? '—' }}</td>
                            <td class="px-1 {{ $bodySize }} {{ $cellPad }} text-center font-mono text-zinc-700">{{ $exercise->rest_seconds ? $exercise->rest_seconds.'s' : '—' }}</td>
                            <td class="px-1 {{ $bodySize }} {{ $cellPad }} text-center font-mono text-zinc-700">{{ $exercise->load ? number_format((float) $exercise->load, 2, ',', '.').' kg' : '—' }}</td>
                        </tr>
                        @if ($exercise->observation)
                        <tr class="border-t border-zinc-100">
                            <td colspan="6" class="px-2 py-1 text-[11px] text-zinc-500 italic">
                                <span class="font-semibold not-italic text-zinc-600">Observação:</span> {{ $exercise->observation }}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-right text-[11px] text-zinc-400 mt-6">
                <span>Registrado por {{ $trainingSheet->creator?->name ?? '—' }} em {{ $trainingSheet->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
            </div>
        </div>

        <div class="bg-zinc-900 px-8 py-4 text-center">
            @if ($logoBase64)
                <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" style="max-height: 35px; width: auto; display: block; margin: 0 auto 6px;">
            @endif
            <p class="text-zinc-300 text-xs font-semibold">{{ $company->name ?? config('app.name') }}</p>
            <p class="text-zinc-500 text-[11px] mt-1">
                @if ($company?->cnpj)CNPJ: {{ $company->cnpj }} — @endif
                @if ($company?->address){{ $company->address }}, {{ $company->number }} @endif
                @if ($company?->neighborhood) — {{ $company->neighborhood }} @endif
                @if ($company?->city) — {{ $company->city }}/{{ $company->state }} @endif
            </p>
            <p class="text-zinc-500 text-[11px] mt-1">
                @if ($company?->phone)Tel: {{ $company->phone }} @endif
                @if ($company?->whatsapp) — WhatsApp: {{ $company->whatsapp }} @endif
                @if ($company?->email) — E-mail: {{ $company->email }} @endif
            </p>
        </div>
    </div>
    @endforeach
</body>
</html>
