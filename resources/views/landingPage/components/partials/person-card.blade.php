<div class="person-circle {{ $class ?? '' }}" data-id="{{ $id }}">
    <div class="person-avatar">
        @if($person->foto)
            <img src="{{ url('/storage/'.$person->foto) }}" alt="{{ $person->nama }}">
        @else
            @php
                // Icon berdasarkan posisi nama
                $icon = 'fas fa-user';
                $posisiNama = strtolower($person->posisi ?? '');
                if (str_contains($posisiNama, 'wakil')) {
                    $icon = 'fas fa-user-friends';
                } elseif (str_contains($posisiNama, 'sekretaris')) {
                    $icon = 'fas fa-user-edit';
                } elseif (str_contains($posisiNama, 'bendahara')) {
                    $icon = 'fas fa-calculator';
                } elseif (str_contains($posisiNama, 'koordinator')) {
                    $icon = 'fas fa-users-cog';
                } elseif (str_contains($posisiNama, 'kepala') || str_contains($posisiNama, 'ketua')) {
                    $icon = 'fas fa-user-tie';
                } elseif (str_contains($posisiNama, 'manajer')) {
                    $icon = 'fas fa-briefcase';
                } elseif (str_contains($posisiNama, 'direktur')) {
                    $icon = 'fas fa-crown';
                }
            @endphp
            <i class="{{ $icon }}"></i>
        @endif
    </div>
    <div class="position-label">{{ $person->posisi }}</div>
    <div class="person-info-card">
        <div class="info-header">
            <div class="info-avatar" 
                 @if($class === 'wakil-kepala') 
                     style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"
                 @elseif($class === 'sekretaris')
                     style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);"
                 @elseif($class === 'bendahara')
                     style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);"
                 @endif>
                @if($person->foto)
                    <img src="{{ url('/storage/'.$person->foto) }}" alt="{{ $person->nama }}" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    <i class="{{ $icon }}"></i>
                @endif
            </div>
            <div class="info-details">
                <h3>{{ $person->nama }}</h3>
                <div class="position">{{ $person->posisi }}</div>
            </div>
        </div>
        <div class="info-content">
            @if($person->periode_awal && $person->periode_akhir)
                <strong>Periode:</strong> {{ $person->periode_awal }}-{{ $person->periode_akhir }}<br>
            @endif
            @if($person->pengalaman)
                <strong>Pengalaman:</strong> {{ $person->pengalaman }}<br>
            @endif
            @if($person->fokus)
                <strong>Bidang:</strong> {{ $person->fokus }}
            @endif
        </div>
        @if($person->nomor_telepon || $person->email)
            <div class="info-contact">
                @if($person->nomor_telepon)
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ $person->nomor_telepon }}</span>
                    </div>
                @endif
                @if($person->email)
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $person->email }}</span>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>