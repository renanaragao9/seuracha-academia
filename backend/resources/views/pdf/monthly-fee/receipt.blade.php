<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante - {{ config('app.name') }}</title>
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
<body >
    <div class="max-w-3xl mx-auto overflow-hidden">
        <div class="relative bg-linear-to-r from-brand-500 to-brand-700 px-8 pt-8 pb-24 overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, white 0%, transparent 50%), radial-gradient(circle at 80% 20%, white 0%, transparent 50%);"></div>
           <div class="flex items-start justify-between relative z-10">
                <div>
                    <div>
                        <h1 class="text-3xl font-bold text-black tracking-tight">
                            {{ $company->name ?? config('app.name') }}
                        </h1>
                        <p class="text-gray-600 text-sm mt-1 tracking-wide">
                            Comprovante de Mensalidade
                        </p>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-gray-500 text-xs uppercase tracking-[0.2em] font-semibold">
                        Recibo
                    </p>

                    <p class="text-black font-mono text-sm font-medium mt-1">
                        {{ $fee->uuid }}
                    </p>
                </div>
            </div>

            <div class="absolute bottom-4 right-6">
                <img
                    src="data:image/png;base64,{{ $image }}"
                    alt="Comprovante"
                    style="width: 250px;"
                >
            </div>

            <div class="bg-zinc-50 rounded-xl p-5 mb-6 border border-zinc-100">
                <h2 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <span class="w-1 h-4 bg-brand-500 rounded-full inline-block"></span>
                    Valor Pago
                </h2>
                <p class="font-mono font-black text-lg text-brand-600">
                    R$ {{ number_format((float) $fee->amount_paid, 2, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="px-8 pt-20 pb-6">
            <div class="bg-zinc-50 rounded-xl p-5 mb-6 border border-zinc-100">
                <h2 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <span class="w-1 h-4 bg-brand-500 rounded-full inline-block"></span>
                    Aluno
                </h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-zinc-500">Nome</p>
                        <p class="text-base font-bold text-zinc-900">{{ $fee->student->name }}</p>
                        <p class="text-sm text-zinc-500 mt-1">{{ $fee->student->email ?? '—' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-zinc-500">Código</p>
                        <p class="text-base font-mono font-bold text-zinc-800">{{ $fee->student->code }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-zinc-50 rounded-xl p-5 mb-6 border border-zinc-100">
                <h2 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <span class="w-1 h-4 bg-brand-500 rounded-full inline-block"></span>
                    Detalhes do Pagamento
                </h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-zinc-500">Período</span>
                        <p class="font-semibold text-zinc-800">
                            {{ $fee->start_date?->format('d/m/Y') ?? '—' }} a {{ $fee->end_date?->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-xs text-zinc-500">Data do Pagamento</span>
                        <p class="font-semibold text-zinc-800">{{ $fee->date_payment?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-zinc-500">Plano</span>
                        <p class="font-semibold text-zinc-800">{{ $fee->planType->name ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-zinc-500">Forma de Pagamento</span>
                        <p class="font-semibold text-zinc-800">{{ $fee->paymentType->name ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden border border-zinc-200 mb-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-zinc-800">
                            <th class="text-left px-5 py-3 font-semibold text-zinc-300 text-xs uppercase tracking-wider">Descrição</th>
                            <th class="text-right px-5 py-3 font-semibold text-zinc-300 text-xs uppercase tracking-wider">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-zinc-100">
                            <td class="px-5 py-3.5 text-zinc-700">Valor Integral do Plano</td>
                            <td class="px-5 py-3.5 text-right font-mono text-zinc-700">R$ {{ number_format((float) $fee->full_payment, 2, ',', '.') }}</td>
                        </tr>
                        @if ((float) $fee->discount_payment > 0)
                        <tr class="border-b border-zinc-100">
                            <td class="px-5 py-3.5 text-emerald-700">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Desconto
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right font-mono text-emerald-600">- R$ {{ number_format((float) $fee->discount_payment, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="bg-brand-50">
                            <td class="px-5 py-4 font-bold text-zinc-900 text-base">Valor Pago</td>
                            <td class="px-5 py-4 text-right font-mono font-black text-lg text-brand-600">R$ {{ number_format((float) $fee->amount_paid, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between text-xs text-zinc-400 pt-2">
                <span>Registrado por {{ $fee->user?->name ?? '—' }} em {{ $fee->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
                <span class="font-mono">{{ $fee->uuid }}</span>
            </div>
        </div>

        <div class="bg-zinc-900 px-8 py-5 text-center border-t border-zinc-800">
            @if ($logoBase64)
                <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" style="max-height: 35px; width: auto; display: block; margin: 0 auto 6px;">
            @endif
            <p class="text-zinc-300 text-xs font-semibold">{{ $company->name ?? config('app.name') }}</p>
            <p class="text-zinc-500 text-xs mt-1">
                @if ($company?->cnpj)CNPJ: {{ $company->cnpj }} — @endif
                @if ($company?->address){{ $company->address }}, {{ $company->number }} @endif
                @if ($company?->neighborhood) — {{ $company->neighborhood }} @endif
                @if ($company?->city) — {{ $company->city }}/{{ $company->state }} @endif
            </p>
            <p class="text-zinc-500 text-xs mt-1">
                @if ($company?->phone)Tel: {{ $company->phone }} @endif
                @if ($company?->whatsapp) — WhatsApp: {{ $company->whatsapp }} @endif
                @if ($company?->email) — E-mail: {{ $company->email }} @endif
            </p>
        </div>
    </div>
</body>
</html>