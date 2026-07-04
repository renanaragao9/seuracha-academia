<tr>
    <td class="header-bg">
        <a href="{{ $url }}" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
            <img src="{{ $configuration?->logo ?? 'https://seuracha.s3.sa-east-1.amazonaws.com/email/logo.png' }}" 
                 alt="{{ $configuration?->name ?? config('app.name') }}" 
                 style="max-width: 60px; height: auto;">
            <span style="color: #ffffff; font-size: 28px; font-weight: bold; margin-left: 15px; font-family: Arial, sans-serif; line-height: 1;">
                | {{ $configuration?->name ?? config('app.name') }}
            </span>
        </a>
    </td>
</tr>

