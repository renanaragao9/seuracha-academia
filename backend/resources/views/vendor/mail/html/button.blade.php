@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])

<table class="action" align="{{ $align }}" width="100%" cellpadding="0" cellspacing="0" role="presentation" style="margin: 20px 0;">
    <tr>
        <td align="{{ $align }}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td align="{{ $align }}">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td>
                                    <a href="{{ $url }}" 
                                       class="button button-{{ $color }}" 
                                       target="_blank" 
                                       rel="noopener" 
                                       style="display: inline-block; padding: 14px 35px; font-size: 16px; font-weight: bold; text-decoration: none; border-radius: 6px; text-align: center; 
                                       @if($color === 'primary')
                                           background-color: #0b1f3f; color: #ffffff;
                                       @elseif($color === 'success')
                                           background-color: #28a745; color: #ffffff;
                                       @elseif($color === 'secondary')
                                           background-color: #6c757d; color: #ffffff;
                                       @elseif($color === 'outline')
                                           background-color: transparent; border: 2px solid #0b1f3f; color: #0b1f3f;
                                       @endif">
                                        {!! $slot !!}
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
