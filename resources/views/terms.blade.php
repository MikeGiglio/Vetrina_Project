@extends('layouts.app')

@section('title', __('terms.page_title') . ' — Mau House 44 · Palermo')

@section('content')

@php
    $biz = config('business');
    $cin = $biz['cin'] ?: '[' . __('terms.placeholder_cin') . ']';
    $whatsappDisplay = '+' . substr($biz['whatsapp'], 0, 2) . ' ' .
                       substr($biz['whatsapp'], 2, 3) . ' ' .
                       substr($biz['whatsapp'], 5, 3) . ' ' .
                       substr($biz['whatsapp'], 8);
@endphp

{{-- ════════════════════════════════════════
     HERO
════════════════════════════════════════ --}}
<section style="background:#08060A;padding:9rem 0 4rem;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse 60% 60% at 50% 0%,rgba(46,94,50,0.12),transparent);pointer-events:none;"></div>

    <div class="max-w-4xl mx-auto px-6 text-center" style="position:relative;z-index:1;">
        <a href="/" style="display:inline-flex;align-items:center;gap:0.5rem;font-family:'DM Sans',sans-serif;font-size:0.78rem;font-weight:500;color:rgba(245,239,230,0.45);text-decoration:none;letter-spacing:0.06em;text-transform:uppercase;margin-bottom:2.5rem;transition:color 0.2s;"
           onmouseover="this.style.color='rgba(245,239,230,0.8)'" onmouseout="this.style.color='rgba(245,239,230,0.45)'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            {{ __('terms.back_home') }}
        </a>

        <div style="display:inline-block;padding:0.35rem 1rem;border:1px solid rgba(46,94,50,0.4);border-radius:2rem;font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:600;letter-spacing:0.14em;color:rgba(168,212,171,0.8);text-transform:uppercase;margin-bottom:1.5rem;">
            {{ __('terms.section_label') }}
        </div>

        <h1 style="font-family:'Playfair Display',serif;font-size:clamp(2.2rem,5vw,3.6rem);font-weight:700;color:#F5EFE6;line-height:1.15;margin-bottom:1.25rem;">
            {{ __('terms.title') }}
        </h1>

        <p style="font-family:'DM Sans',sans-serif;font-size:0.85rem;color:rgba(245,239,230,0.5);letter-spacing:0.04em;">
            {{ __('terms.last_updated_label') }} {{ __('terms.last_updated_date') }}
        </p>
    </div>
</section>

{{-- ════════════════════════════════════════
     CORPO TERMINI
════════════════════════════════════════ --}}
<section style="background:#FDFAF5;padding:5rem 0 4rem;">
    <div class="max-w-3xl mx-auto px-6 terms-content">

        <p class="terms-intro">{{ __('terms.intro_p1') }}</p>
        <p class="terms-intro">{{ __('terms.intro_p2') }}</p>

        {{-- 1. IDENTIFICAZIONE TITOLARE --}}
        <h2 class="terms-h2">1. {{ __('terms.s1_title') }}</h2>
        <div class="terms-card">
            <dl class="terms-dl">
                <dt>{{ __('terms.s1_label_name') }}</dt><dd>{{ $biz['name'] }}</dd>
                <dt>{{ __('terms.s1_label_owner') }}</dt><dd>{{ $biz['owner'] }}</dd>
                <dt>{{ __('terms.s1_label_address') }}</dt><dd>{{ $biz['address'] }}</dd>
                <dt>{{ __('terms.s1_label_cin') }}</dt><dd>{{ $cin }}</dd>
                <dt>{{ __('terms.s1_label_email') }}</dt><dd><a href="mailto:{{ $biz['email'] }}">{{ $biz['email'] }}</a></dd>
                <dt>{{ __('terms.s1_label_whatsapp') }}</dt><dd>{{ $whatsappDisplay }}</dd>
            </dl>
        </div>
        <p class="terms-note">{{ __('terms.s1_note') }}</p>

        {{-- 2. OGGETTO --}}
        <h2 class="terms-h2">2. {{ __('terms.s2_title') }}</h2>
        <p>{{ __('terms.s2_p1') }}</p>
        <p>{{ __('terms.s2_p2') }}</p>

        {{-- 3. MODALITÀ DI PRENOTAZIONE --}}
        <h2 class="terms-h2">3. {{ __('terms.s3_title') }}</h2>
        <p>3.1 {{ __('terms.s3_p1') }}</p>
        <p>3.2 {{ __('terms.s3_p2') }}</p>
        <p>3.3 {{ __('terms.s3_p3') }}</p>
        <p>3.4 {{ __('terms.s3_p4') }}</p>

        {{-- 4. REGOLE DELLA STRUTTURA --}}
        <h2 class="terms-h2">4. {{ __('terms.s4_title') }}</h2>
        <p>4.1 <strong>{{ __('terms.s4_capacity_label') }}:</strong> {{ __('terms.s4_capacity_body') }}</p>
        <p>4.2 <strong>{{ __('terms.s4_checkin_label') }}:</strong> {{ __('terms.s4_checkin_body') }}</p>
        <p>4.3 <strong>{{ __('terms.s4_checkout_label') }}:</strong> {{ __('terms.s4_checkout_body') }}</p>
        <p>4.4 <strong>{{ __('terms.s4_rules_label') }}:</strong></p>
        <ul class="terms-ul">
            <li>{{ __('terms.s4_rule_pets') }}</li>
            <li>{{ __('terms.s4_rule_smoking') }}</li>
            <li>{{ __('terms.s4_rule_parties') }}</li>
            <li>{{ __('terms.s4_rule_sublet') }}</li>
            <li>{{ __('terms.s4_rule_quiet') }}</li>
        </ul>
        <p>4.5 <strong>{{ __('terms.s4_documents_label') }}:</strong> {{ __('terms.s4_documents_body') }}</p>
        <p>4.6 <strong>{{ __('terms.s4_minors_label') }}:</strong> {{ __('terms.s4_minors_body') }}</p>

        {{-- 5. TASSA DI SOGGIORNO --}}
        <h2 class="terms-h2">5. {{ __('terms.s5_title') }}</h2>
        <p>{{ __('terms.s5_body') }}</p>

        {{-- 6. PREZZI, PAGAMENTO, FATTURAZIONE --}}
        <h2 class="terms-h2">6. {{ __('terms.s6_title') }}</h2>
        <p>6.1 {{ __('terms.s6_p1') }}</p>
        <p>6.2 {{ __('terms.s6_p2') }}</p>
        <ul class="terms-ul">
            <li>{{ __('terms.s6_channel_booking') }}</li>
            <li>{{ __('terms.s6_channel_direct') }}</li>
        </ul>
        <p>6.3 {{ __('terms.s6_p3') }}</p>

        {{-- 7. CANCELLAZIONE --}}
        <h2 class="terms-h2">7. {{ __('terms.s7_title') }}</h2>
        <p>7.1 {{ __('terms.s7_p1') }}</p>
        <p>7.2 {{ __('terms.s7_p2_label') }}:</p>
        <ul class="terms-ul">
            <li>{{ __('terms.s7_p2_rule1') }}</li>
            <li>{{ __('terms.s7_p2_rule2') }}</li>
            <li>{{ __('terms.s7_p2_rule3') }}</li>
            <li>{{ __('terms.s7_p2_rule4') }}</li>
        </ul>
        <p>7.3 {{ __('terms.s7_p3') }}</p>

        {{-- 8. RESPONSABILITÀ OSPITE + CAUZIONE --}}
        <h2 class="terms-h2">8. {{ __('terms.s8_title') }}</h2>
        <p>8.1 {{ __('terms.s8_p1') }}</p>
        <p>8.2 {{ __('terms.s8_p2') }}</p>
        <p>8.3 {{ __('terms.s8_p3') }}</p>

        {{-- 9. LIMITAZIONE RESPONSABILITÀ --}}
        <h2 class="terms-h2">9. {{ __('terms.s9_title') }}</h2>
        <p>9.1 {{ __('terms.s9_p1') }}</p>
        <p>9.2 {{ __('terms.s9_p2') }}</p>
        <p>9.3 {{ __('terms.s9_p3') }}</p>

        {{-- 10. PRIVACY --}}
        <h2 class="terms-h2">10. {{ __('terms.s10_title') }}</h2>
        <p>10.1 {!! __('terms.s10_p1') !!}</p>
        <p>10.2 {{ __('terms.s10_p2') }}</p>
        <p>10.3 {{ __('terms.s10_p3') }}</p>

        {{-- 11. COOKIE --}}
        <h2 class="terms-h2">11. {{ __('terms.s11_title') }}</h2>
        <p>{!! __('terms.s11_body') !!}</p>

        {{-- 12. PROPRIETÀ INTELLETTUALE --}}
        <h2 class="terms-h2">12. {{ __('terms.s12_title') }}</h2>
        <p>{{ __('terms.s12_body') }}</p>

        {{-- 13. MODIFICHE --}}
        <h2 class="terms-h2">13. {{ __('terms.s13_title') }}</h2>
        <p>{{ __('terms.s13_body') }}</p>

        {{-- 14. LEGGE E FORO --}}
        <h2 class="terms-h2">14. {{ __('terms.s14_title') }}</h2>
        <p>14.1 {{ __('terms.s14_p1') }}</p>
        <p>14.2 {{ __('terms.s14_p2') }}</p>
        <p>14.3 {!! __('terms.s14_p3', ['forum' => $biz['forum']]) !!}</p>
        <p>14.4 {!! __('terms.s14_odr') !!}</p>

        {{-- 15. DISPOSIZIONI FINALI --}}
        <h2 class="terms-h2">15. {{ __('terms.s15_title') }}</h2>
        <p>15.1 {{ __('terms.s15_p1') }}</p>
        <p>15.2 {{ __('terms.s15_p2') }}</p>

        {{-- 16. CONTATTI --}}
        <h2 class="terms-h2">16. {{ __('terms.s16_title') }}</h2>
        <div class="terms-card">
            <dl class="terms-dl">
                <dt>{{ __('terms.s16_email_label') }}</dt><dd><a href="mailto:{{ $biz['email'] }}">{{ $biz['email'] }}</a></dd>
                <dt>{{ __('terms.s16_whatsapp_label') }}</dt><dd>{{ $whatsappDisplay }}</dd>
                <dt>{{ __('terms.s16_address_label') }}</dt><dd>{{ $biz['address'] }}</dd>
            </dl>
        </div>

        {{-- Footer doc --}}
        <div class="terms-foot">
            <p>{{ __('terms.last_updated_label') }} <strong>{{ __('terms.last_updated_date') }}</strong></p>
            <a href="/" class="terms-back-btn">{{ __('terms.back_home') }}</a>
        </div>
    </div>
</section>

@endsection
