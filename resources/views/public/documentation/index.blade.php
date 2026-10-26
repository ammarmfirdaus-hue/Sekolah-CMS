@extends('public.layouts.app')

@section('title', 'Dokumentasi Kegiatan | '.($schoolProfile?->school_name ?? 'Sekolah'))

@section('content')
<section class="hero-section hero-section-simple">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="hero-title">Dokumentasi Kegiatan</h1>
        <p class="hero-subtitle">
            Kumpulan dokumentasi kegiatan pembelajaran, kebersamaan, dan aktivitas {{ $schoolProfile?->school_name ?? 'PKBM Al Falah Sumur Batu' }}
        </p>
    </div>
</section>

@if($groupedEvents->isEmpty())
<section class="section-spacing">
    <div class="container">
        <div class="empty-state">
            <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h2 class="empty-state-title">Dokumentasi belum tersedia</h2>
            <p class="empty-state-description">
                Kegiatan {{ $schoolProfile?->school_name ?? 'PKBM Al Falah Sumur Batu' }} akan ditampilkan di halaman ini.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary-custom mt-3">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@else
<section class="section-spacing documentation-timeline">
    <div class="container">
        @foreach($groupedEvents as $year => $monthGroups)
        <div class="timeline-year-group mb-5">
            <h2 class="timeline-year-heading">{{ $year }}</h2>

            @foreach($monthGroups as $yearMonth => $events)
            @php
            $monthName = \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->locale('id')->translatedFormat('F Y');
            @endphp

            <div class="timeline-month-group mb-5">
                <h3 class="timeline-month-heading">{{ $monthName }}</h3>

                <div class="row g-4">
                    @foreach($events as $event)
                    <div class="col-12">
                        <article class="event-card">
                            <div class="row g-0">
                                @php
                                $featuredMedia = $event->media->where('is_featured', true)->first() ?? $event->media->first();
                                @endphp

                                @if($featuredMedia && $featuredMedia->isPhoto())
                                <div class="col-md-5 col-lg-4">
                                    <div class="event-card-image-wrapper">
                                        @if($featuredMedia->path)
                                        <img
                                            src="{{ $featuredMedia->publicUrl() }}"
                                            alt="{{ $featuredMedia->caption ?: $event->title }}"
                                            class="event-card-image">
                                        @else
                                        <div class="event-card-placeholder">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-7 col-lg-8">
                                    <div class="event-card-body">
                                        <div class="event-card-meta">
                                            <span class="event-card-date">
                                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                </svg>
                                                {{ $event->event_date->locale('id')->translatedFormat('d F Y') }}
                                            </span>
                                            @if($event->location)
                                            <span class="event-card-location">
                                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                                                </svg>
                                                {{ $event->location }}
                                            </span>
                                            @endif
                                        </div>

                                        <h4 class="event-card-title">{{ $event->title }}</h4>

                                        @if($event->description)
                                        <p class="event-card-description">{{ $event->description }}</p>
                                        @endif

                                        @if($event->media->count() > 1)
                                        <div class="event-card-carousel">
                                            <div id="carousel-{{ $event->id }}" class="carousel slide" data-bs-ride="false">
                                                <div class="carousel-inner">
                                                    @foreach($event->media as $index => $media)
                                                    @if($media->isPhoto())
                                                    <div class="carousel-item @if($index === 0) active @endif">
                                                        @if($media->path)
                                                        <img
                                                            src="{{ $media->publicUrl() }}"
                                                            class="d-block w-100"
                                                            alt="{{ $media->caption ?: $event->title }}">
                                                        @else
                                                        <div class="carousel-placeholder">
                                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                        @endif
                                                        @if($media->caption)
                                                        <div class="carousel-caption-custom">
                                                            <p>{{ $media->caption }}</p>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </div>

                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $event->id }}" data-bs-slide="prev" aria-label="Foto sebelumnya">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $event->id }}" data-bs-slide="next" aria-label="Foto berikutnya">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                </button>

                                                <div class="carousel-indicators">
                                                    @foreach($event->media as $index => $media)
                                                    @if($media->isPhoto())
                                                    <button
                                                        type="button"
                                                        data-bs-target="#carousel-{{ $event->id }}"
                                                        data-bs-slide-to="{{ $index }}"
                                                        @if($index===0) class="active" aria-current="true" @endif
                                                        aria-label="Foto {{ $index + 1 }}"></button>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</section>
@endif
@endsection

@push('scripts')
<style>
    .hero-section-simple {
        min-height: 40vh;
        background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
    }

    .documentation-timeline {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    .timeline-year-heading {
        font-size: 2rem;
        font-weight: 700;
        color: var(--color-primary);
        margin-bottom: 2rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--color-primary);
    }

    .timeline-month-heading {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: 1.5rem;
    }

    .event-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .event-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }

    .event-card-image-wrapper {
        height: 100%;
        min-height: 250px;
        overflow: hidden;
        background: #f5f5f5;
    }

    .event-card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-card-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
    }

    .event-card-placeholder svg {
        width: 80px;
        height: 80px;
        color: #ccc;
    }

    .event-card-body {
        padding: 2rem;
    }

    .event-card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: #666;
    }

    .event-card-date,
    .event-card-location {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .event-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-text);
        margin-bottom: 1rem;
    }

    .event-card-description {
        color: #666;
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .event-card-carousel {
        margin-top: 1.5rem;
    }

    .carousel-inner {
        border-radius: 8px;
        overflow: hidden;
    }

    .carousel-item img {
        height: 400px;
        object-fit: cover;
    }

    .carousel-placeholder {
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
    }

    .carousel-placeholder svg {
        width: 80px;
        height: 80px;
        color: #ccc;
    }

    .carousel-caption-custom {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        padding: 2rem 1rem 1rem;
        color: #fff;
    }

    .carousel-caption-custom p {
        margin: 0;
        font-size: 0.9rem;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 2rem;
        height: 2rem;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
    }

    .carousel-indicators {
        margin-bottom: 0.5rem;
    }

    .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
    }

    .carousel-indicators button.active {
        background-color: #fff;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        color: #ccc;
        margin-bottom: 1.5rem;
    }

    .empty-state-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--color-text);
        margin-bottom: 1rem;
    }

    .empty-state-description {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 0;
    }

    @media (max-width: 767px) {
        .hero-section-simple {
            min-height: 30vh;
        }

        .event-card-image-wrapper {
            min-height: 200px;
        }

        .event-card-body {
            padding: 1.5rem;
        }

        .event-card-title {
            font-size: 1.25rem;
        }

        .carousel-item img,
        .carousel-placeholder {
            height: 250px;
        }

        .timeline-year-heading {
            font-size: 1.5rem;
        }

        .timeline-month-heading {
            font-size: 1.25rem;
        }
    }
</style>
@endpush