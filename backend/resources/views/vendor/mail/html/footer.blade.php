<tr>
    <td class="footer-bg">
        @php
            $socialLinks = [];
            if ($configuration?->facebook) {
                $socialLinks[] = ['url' => $configuration->facebook, 'icon' => 'facebook.png', 'alt' => 'Facebook'];
            }
            if ($configuration?->instagram) {
                $socialLinks[] = ['url' => $configuration->instagram, 'icon' => 'instagram.png', 'alt' => 'Instagram'];
            }
            if ($configuration?->whatsapp) {
                $whatsappUrl = str_starts_with($configuration->whatsapp, 'https://')
                    ? $configuration->whatsapp
                    : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $configuration->whatsapp);
                $socialLinks[] = ['url' => $whatsappUrl, 'icon' => 'whatsapp.png', 'alt' => 'WhatsApp'];
            }
            if ($configuration?->youtube) {
                $socialLinks[] = ['url' => $configuration->youtube, 'icon' => 'youtube.png', 'alt' => 'YouTube'];
            }
        @endphp

        @if (count($socialLinks) > 0)
            <div class="social-icons" style="margin: 20px 0;">
                @foreach ($socialLinks as $link)
                    <a href="{{ $link['url'] }}" target="_blank"
                        style="text-decoration: none; border: none; margin: 0 12px;">
                        <img src="{{ asset('img/email/' . $link['icon']) }}" alt="{{ $link['alt'] }}"
                            style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; max-width: 32px; max-height: 32px; display: inline-block; border: none; object-fit: contain;">
                    </a>
                @endforeach
            </div>
        @endif

        <div class="links-footer" style="margin-top: 20px; border-top: 1px solid #27272a; padding-top: 15px;">
            {{ Illuminate\Mail\Markdown::parse($slot) }}
        </div>
    </td>
</tr>