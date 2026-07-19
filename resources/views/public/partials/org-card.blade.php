<article class="structure-card h-100 {{ !$member || !$member->name ? 'is-empty' : '' }}">
    <div class="structure-card-body">
        @if($member && $member->photo)
            <img src="{{ asset('storage/'.ltrim($member->photo, '/')) }}" alt="{{ $member->name }}" class="structure-photo">
        @else
            <div class="structure-photo-placeholder">
                @if($member && $member->name)
                    {{ strtoupper(substr($member->name, 0, 1)) }}
                @else
                    ?
                @endif
            </div>
        @endif
        
        <h3 class="structure-name">{{ $member && $member->name ? $member->name : 'Belum Diisi' }}</h3>
        <p class="structure-position">{{ $member ? $member->position : $defaultPosition }}</p>
        
        @if($member && $member->description)
            <p class="structure-description">{{ $member->description }}</p>
        @endif
    </div>
</article>
