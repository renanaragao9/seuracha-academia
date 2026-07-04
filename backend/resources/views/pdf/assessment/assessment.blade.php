<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação Física - {{ config('app.name') }}</title>
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
        @page { margin: 0; }
        body { font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; -webkit-font-smoothing: antialiased; }
    </style>
</head>
<body>
    <div class="max-w-4xl mx-auto">
        <div class="relative bg-linear-to-r from-brand-500 to-brand-700 px-6 pt-5 pb-4 overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, white 0%, transparent 50%), radial-gradient(circle at 80% 20%, white 0%, transparent 50%);"></div>

            <div class="relative z-10 pt-4">
                <div class="absolute left-0 bottom-0">
                    <img
                        src="data:image/png;base64,{{ $image }}"
                        alt="Avaliação Física"
                        style="width: 100px;"
                        class="rounded-lg"
                    >
                </div>
                <div class="absolute right-0 bottom-0 text-right">
                    <p class="text-black/60 text-xs uppercase tracking-[0.2em] font-semibold">
                        Avaliação
                    </p>
                    @if ($assessment)
                    <p class="text-white font-mono text-sm font-bold mt-0.5">
                        #{{ $assessment->id }}
                    </p>
                    @endif
                </div>
                <div class="text-center">
                    <h1 class="text-2xl font-bold text-black tracking-tight leading-tight">
                        {{ $company->name ?? config('app.name') }}
                    </h1>
                    <p class="text-white/80 text-xs mt-0.5 tracking-wide font-medium">
                        Avaliação Física
                    </p>
                </div>
            </div>
        </div>

        <div class="px-6 pb-4">
            <div class="bg-white rounded-lg border border-zinc-200 px-4 py-2 mb-3">
                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-[9px] font-semibold text-zinc-400 uppercase tracking-wider">Aluno</span>
                        <p class="font-bold text-zinc-900 text-sm">{{ $student->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-semibold text-zinc-400 uppercase tracking-wider">Código</span>
                        <p class="font-mono font-bold text-zinc-800 text-sm">{{ $student->code }}</p>
                    </div>
                    @if ($assessment)
                    <div>
                        <span class="text-[9px] font-semibold text-zinc-400 uppercase tracking-wider">Avaliação</span>
                        <p class="font-bold text-zinc-900 text-sm">{{ $assessment->name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[9px] font-semibold text-zinc-400 uppercase tracking-wider">Período</span>
                        <p class="font-mono font-bold text-zinc-800 text-sm">
                            {{ $assessment->start_date?->format('d/m/Y') ?? '—' }} a {{ $assessment->end_date?->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>
                    @if ($assessment->observations)
                    <div class="col-span-2">
                        <span class="text-[9px] font-semibold text-zinc-400 uppercase tracking-wider">Observações</span>
                        <p class="text-zinc-700 text-xs">{{ $assessment->observations }}</p>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            @if ($grouped->isNotEmpty())
            <div class="grid grid-cols-2 gap-3">
                @foreach ($grouped as $typeName => $items)
                    <div class="rounded-lg overflow-hidden border border-zinc-200 h-full">
                        <div class="bg-zinc-800 px-3 py-1.5">
                            <h3 class="font-semibold text-zinc-100 text-[10px] uppercase tracking-wider">{{ $typeName }}</h3>
                        </div>
                        <table class="w-full text-[10px]">
                            <thead>
                                <tr class="bg-zinc-50">
                                    <th class="text-left px-2 py-1 font-semibold text-zinc-500 uppercase tracking-wider w-6">#</th>
                                    <th class="text-left px-2 py-1 font-semibold text-zinc-500 uppercase tracking-wider">Valor</th>
                                    <th class="text-center px-2 py-1 font-semibold text-zinc-500 uppercase tracking-wider">Unidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                <tr class="border-t border-zinc-100">
                                    <td class="px-2 py-1 text-zinc-400 font-mono">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-1 text-zinc-800 font-medium">{{ number_format((float) $item->value, 2, ',', '.') }}</td>
                                    <td class="px-2 py-1 text-center font-mono text-zinc-700">{{ $item->unit ?? '—' }}</td>
                                </tr>
                                @if ($item->notes)
                                <tr class="border-t border-zinc-100">
                                    <td colspan="3" class="px-2 pb-1 text-[9px] text-zinc-500 italic">
                                        <span class="font-semibold not-italic text-zinc-600">Obs:</span> {{ $item->notes }}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-lg border border-zinc-200 px-4 py-6 text-center">
                <p class="text-zinc-500 text-xs">Nenhuma avaliação encontrada.</p>
            </div>
            @endif

            <div class="flex items-center justify-between text-[9px] text-zinc-400 pt-2">
                <span>Gerado em {{ now()->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="bg-zinc-900 px-6 py-4 text-center">
            @if ($logoBase64)
                <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" style="max-height: 35px; width: auto; display: block; margin: 0 auto 6px;">
            @endif
            <p class="text-zinc-300 text-xs font-semibold">{{ $company->name ?? config('app.name') }}</p>
            <p class="text-zinc-500 text-[10px] mt-1">
                @if ($company?->cnpj)CNPJ: {{ $company->cnpj }} — @endif
                @if ($company?->address){{ $company->address }}, {{ $company->number }} @endif
                @if ($company?->neighborhood) — {{ $company->neighborhood }} @endif
                @if ($company?->city) — {{ $company->city }}/{{ $company->state }} @endif
            </p>
            <p class="text-zinc-500 text-[10px] mt-1">
                @if ($company?->phone)Tel: {{ $company->phone }} @endif
                @if ($company?->whatsapp) — WhatsApp: {{ $company->whatsapp }} @endif
                @if ($company?->email) — E-mail: {{ $company->email }} @endif
            </p>
        </div>
    </div>
</body>
</html>
