@extends('public.layouts.app')

@section('title', ($registrationInfo?->title ?? 'Pendaftaran Peserta Didik').' | '.($schoolProfile?->school_name ?? 'Sekolah'))

@section('meta_description', $registrationInfo?->description ? strip_tags($registrationInfo->description) : 'Informasi pendaftaran peserta didik baru.')

@section('content')
<section class="hero-section hero-section-simple">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="hero-title">{{ $registrationInfo?->title ?? 'Pendaftaran Peserta Didik' }}</h1>
        <p class="hero-subtitle">
            {{ $registrationInfo?->subtitle ?? 'Informasi dan prosedur pendaftaran '.($schoolProfile?->school_name ?? 'PKBM Al Falah Sumur Batu') }}
        </p>
    </div>
</section>

<section class="section-spacing">
    <div class="container">
        @if ($registrationInfo && !$registrationInfo->is_open)
            <div class="alert alert-warning" style="border-radius: var(--radius-sm); margin-bottom: 2rem;">
                <strong>Pendaftaran Ditutup</strong>
                <p class="mb-0" style="margin-top: 0.3rem;">Pendaftaran peserta didik saat ini sedang ditutup. Silakan hubungi kami untuk informasi lebih lanjut.</p>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content-card">
                    @if ($registrationInfo?->description)
                        <div class="registration-description">
                            <p>{{ $registrationInfo->description }}</p>
                        </div>
                        <hr style="border-color: var(--color-border); margin: 1.5rem 0;">
                    @endif

                    <div class="registration-info">
                        @if ($registrationInfo?->requirements)
                            <div class="info-box">
                                <h3>Persyaratan</h3>
                                <div class="info-box-content">{!! nl2br(e($registrationInfo->requirements)) !!}</div>
                            </div>
                        @endif

                        @if ($registrationInfo?->process)
                            <div class="info-box">
                                <h3>Alur Pendaftaran</h3>
                                <div class="info-box-content">{!! nl2br(e($registrationInfo->process)) !!}</div>
                            </div>
                        @endif

                        @if ($registrationInfo?->schedule)
                            <div class="info-box">
                                <h3>Jadwal Pendaftaran</h3>
                                <div class="info-box-content">{!! nl2br(e($registrationInfo->schedule)) !!}</div>
                            </div>
                        @endif
                    </div>

                    @if ($registrationInfo?->contact_info)
                        <div style="background: var(--color-bg); border-radius: var(--radius-sm); padding: 1.5rem; margin-top: 1.5rem;">
                            <h3 style="color: var(--color-primary-dark); font-size: 1.15rem; font-weight: 700; margin-bottom: 0.75rem;">Informasi Kontak</h3>
                            <p style="margin: 0;">{{ $registrationInfo->contact_info }}</p><br>081234567890
                        </div>
                    @endif

                    @if ($registrationInfo?->cta_text)
                        <!-- <div class="contact-cta">
                            <h3>Butuh Informasi Lebih Lanjut?</h3>
                            <p>Hubungi kami untuk informasi lebih detail mengenai prosedur pendaftaran.</p>
                            <a href="{{ $registrationInfo->cta_url && !str_starts_with($registrationInfo->cta_url, '#') ? url($registrationInfo->cta_url) : route('home').($registrationInfo->cta_url ?: '#kontak') }}" class="btn btn-primary-custom">{{ $registrationInfo->cta_text }}</a>
                        </div> -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
.hero-section-simple {
    min-height: 40vh;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
}

.content-card {
    background: var(--color-surface);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    padding: 2.5rem;
}

.registration-description {
    color: var(--color-text);
    font-size: 1.05rem;
    line-height: 1.8;
}

.registration-info {
    display: grid;
    gap: 1.5rem;
    margin: 1.5rem 0;
}

.info-box {
    background: var(--color-primary-soft);
    border-left: 4px solid var(--color-primary);
    border-radius: var(--radius-sm);
    padding: 1.5rem;
}

.info-box h3 {
    color: var(--color-primary-dark);
    font-size: 1.15rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.info-box-content {
    color: var(--color-text);
    line-height: 1.7;
}

.info-box-content p {
    margin-bottom: 0.5rem;
}

.contact-cta {
    background: var(--color-bg);
    border-radius: var(--radius-sm);
    margin-top: 2rem;
    padding: 2rem;
    text-align: center;
}

.contact-cta h3 {
    color: var(--color-primary-dark);
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.contact-cta p {
    color: var(--color-muted);
    margin-bottom: 1.5rem;
}

.alert-warning {
    background: var(--color-accent-soft);
    border: 1px solid rgba(242, 201, 76, 0.35);
    color: #7c5a00;
    padding: 1.25rem;
}

@media (max-width: 767.98px) {
    .content-card {
        padding: 1.5rem;
    }

    .contact-cta {
        padding: 1.5rem;
    }
}
</style>
@endpush
