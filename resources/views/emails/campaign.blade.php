<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>{{ $campaign->subject }}</title>
</head>
<body style="margin:0;padding:0;background:#F5EFE6;font-family:Helvetica,Arial,sans-serif;color:#1C2E1A;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#F5EFE6;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td style="background:#1C2E1A;padding:28px 32px;text-align:center;">
                            <div style="font-family:'Playfair Display',Georgia,serif;font-size:24px;font-weight:700;letter-spacing:0.08em;color:#F5EFE6;">MAU HOUSE</div>
                            <div style="font-size:11px;letter-spacing:0.15em;color:#A8D4AB;margin-top:4px;">PALERMO · APPARTAMENTO 44</div>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:36px 32px 24px;">
                            @if($campaign->body_format === 'html')
                                {!! $campaign->body !!}
                            @else
                                <div style="font-size:15px;line-height:1.7;color:#333;white-space:pre-line;">{{ $campaign->body }}</div>
                            @endif
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px 28px;border-top:1px solid #eee;background:#FAF7F0;">
                            <p style="margin:0 0 10px;font-size:12px;color:#777;text-align:center;line-height:1.5;">
                                Ricevi questa email perché ti sei registrato sul sito di Mau House 44<br>
                                o hai espresso consenso esplicito tramite il form recensioni.
                            </p>
                            <p style="margin:0 0 6px;font-size:12px;color:#777;text-align:center;">
                                <a href="{{ $unsubscribeUrl }}" style="color:#2E5E32;text-decoration:underline;">Disiscriviti da queste email</a>
                                &nbsp;·&nbsp;
                                <a href="https://www.iubenda.com/privacy-policy/21158314" style="color:#2E5E32;text-decoration:underline;">Privacy Policy</a>
                            </p>
                            <p style="margin:12px 0 0;font-size:11px;color:#aaa;text-align:center;line-height:1.5;">
                                Mau House 44 · Vicolo San Carlo, 44 · 90133 Palermo (PA) · Italia
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
