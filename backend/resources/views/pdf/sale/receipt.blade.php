<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo - {{ config('app.name') }}</title>
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
        body { font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; -webkit-font-smoothing: antialiased; font-size: 9px; }
    </style>
</head>
<body>
    <div class="max-w-3xl mx-auto overflow-hidden">
        <div class="relative bg-linear-to-r from-brand-500 to-brand-700 px-4 pt-4 pb-16 overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 20% 50%, white 0%, transparent 50%), radial-gradient(circle at 80% 20%, white 0%, transparent 50%);"></div>

            <div class="flex items-start justify-between relative z-10">
                <div>
                    <div>
                        <h1 class="text-2xl font-bold text-black tracking-tight">
                            {{ $company->name ?? config('app.name') }}
                        </h1>
                        <p class="text-gray-600 text-sm mt-0.5 tracking-wide">
                            Recibo de Venda
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gray-500 text-xs uppercase tracking-[0.2em] font-semibold">
                        Recibo
                    </p>
                    <p class="text-black font-mono text-sm font-medium mt-0.5">
                        {{ $sale->uuid }}
                    </p>
                </div>
            </div>

            <div class="absolute bottom-2 right-3">
                <img
                    src="data:image/png;base64,{{ $image }}"
                    alt="Recibo"
                    style="width: 180px;"
                >
            </div>

            <div class="bg-zinc-50 rounded-xl p-3 mb-4 border border-zinc-100">
                <h2 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                    <span class="w-1 h-4 bg-brand-500 rounded-full inline-block"></span>
                    Total Pago
                </h2>
                <p class="font-mono font-black text-lg text-brand-600">
                    R$ {{ number_format((float) $sale->total_amount, 2, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="px-4 pt-12 pb-4">
            <div class="bg-zinc-50 rounded-xl p-3 mb-4 border border-zinc-100">
                <h2 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                    <span class="w-1 h-4 bg-brand-500 rounded-full inline-block"></span>
                    Cliente
                </h2>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="text-sm text-zinc-500">Nome</p>
                        <p class="text-base font-bold text-zinc-900">{{ $sale->student?->name ?? '—' }}</p>
                        <p class="text-sm text-zinc-500 mt-0.5">{{ $sale->student?->email ?? '—' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-zinc-500">Código</p>
                        <p class="text-base font-mono font-bold text-zinc-800">{{ $sale->student?->code ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-zinc-50 rounded-xl p-3 mb-4 border border-zinc-100">
                <h2 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-2 flex items-center gap-1">
                    <span class="w-1 h-4 bg-brand-500 rounded-full inline-block"></span>
                    Detalhes da Venda
                </h2>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-xs text-zinc-500">Status</span>
                        <p class="font-semibold text-zinc-800">{{ $statusLabel }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-zinc-500">Data da Venda</span>
                        <p class="font-semibold text-zinc-800">{{ $sale->date_sale?->format('d/m/Y H:i') ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden border border-zinc-200 mb-4">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-zinc-800">
                            <th class="text-left px-3 py-1.5 font-semibold text-zinc-300 text-xs uppercase tracking-wider">Produto</th>
                            <th class="text-center px-2 py-1.5 font-semibold text-zinc-300 text-xs uppercase tracking-wider">Qtd</th>
                            <th class="text-right px-2 py-1.5 font-semibold text-zinc-300 text-xs uppercase tracking-wider">Preço Unit.</th>
                            <th class="text-right px-3 py-1.5 font-semibold text-zinc-300 text-xs uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sale->saleItems as $item)
                        <tr class="border-b border-zinc-100">
                            <td class="px-3 py-2 text-zinc-700">{{ $item->item?->name ?? '—' }}</td>
                            <td class="px-2 py-2 text-center font-mono text-zinc-700">{{ $item->quantity }}</td>
                            <td class="px-2 py-2 text-right font-mono text-zinc-700">R$ {{ number_format((float) $item->unit_price, 2, ',', '.') }}</td>
                            <td class="px-3 py-2 text-right font-mono text-zinc-700">R$ {{ number_format((float) $item->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t border-zinc-200">
                            <td colspan="3" class="px-3 py-1.5 text-sm text-zinc-600 text-right font-medium">Subtotal</td>
                            <td class="px-3 py-1.5 text-right font-mono text-zinc-700">R$ {{ number_format((float) $sale->amount_price, 2, ',', '.') }}</td>
                        </tr>
                        @if ((float) $sale->discount_amount > 0)
                        <tr>
                            <td colspan="3" class="px-3 py-1.5 text-sm text-emerald-600 text-right font-medium">Desconto</td>
                            <td class="px-3 py-1.5 text-right font-mono text-emerald-600">- R$ {{ number_format((float) $sale->discount_amount, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="bg-brand-50">
                            <td colspan="3" class="px-3 py-2 font-bold text-zinc-900 text-base text-right">Total</td>
                            <td class="px-3 py-2 text-right font-mono font-black text-lg text-brand-600">R$ {{ number_format((float) $sale->total_amount, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if ($sale->observation)
            <div class="bg-zinc-50 rounded-xl p-3 mb-4 border border-zinc-100">
                <h2 class="text-xs font-semibold text-zinc-400 uppercase tracking-widest mb-1 flex items-center gap-1">
                    <span class="w-1 h-4 bg-brand-500 rounded-full inline-block"></span>
                    Observações
                </h2>
                <p class="text-sm text-zinc-700 leading-relaxed">{{ $sale->observation }}</p>
            </div>
            @endif

            <div class="flex items-center justify-between text-xs text-zinc-400 pt-1">
                <span>Registrado por {{ $sale->user?->name ?? '—' }} em {{ $sale->created_at?->format('d/m/Y H:i') ?? '—' }}</span>
                <span class="font-mono">{{ $sale->uuid }}</span>
            </div>
        </div>

        <div class="bg-zinc-900 px-4 py-3 text-center border-t border-zinc-800">
            @if ($logoBase64)
                <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo" style="max-height: 25px; width: auto; display: block; margin: 0 auto 4px;">
            @endif
            <p class="text-zinc-300 text-xs font-semibold">{{ $company->name ?? config('app.name') }}</p>
            <p class="text-zinc-500 text-xs mt-0.5">
                @if ($company?->cnpj)CNPJ: {{ $company->cnpj }} — @endif
                @if ($company?->address){{ $company->address }}, {{ $company->number }} @endif
                @if ($company?->neighborhood) — {{ $company->neighborhood }} @endif
                @if ($company?->city) — {{ $company->city }}/{{ $company->state }} @endif
            </p>
            <p class="text-zinc-500 text-xs mt-0.5">
                @if ($company?->phone)Tel: {{ $company->phone }} @endif
                @if ($company?->whatsapp) — WhatsApp: {{ $company->whatsapp }} @endif
                @if ($company?->email) — E-mail: {{ $company->email }} @endif
            </p>
        </div>
    </div>
</body>
</html>
