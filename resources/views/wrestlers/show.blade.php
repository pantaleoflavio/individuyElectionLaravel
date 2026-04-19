<x-layout>
    <x-second-title>{{ $wrestler->name }}</x-second-title>

    @php
        $imageUrl = $wrestler->image_url;
        $imageSrc = null;
        if ($imageUrl) {
            if (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://', '//'])) {
                $imageSrc = $imageUrl;
            } elseif (\Illuminate\Support\Str::startsWith($imageUrl, 'www.')) {
                $imageSrc = 'https://' . $imageUrl;
            } else {
                $imageSrc = asset('storage/' . ltrim($imageUrl, '/'));
            }
        }
    @endphp

    @if($imageSrc)
        <div class="mb-3">
            <img src="{{ $imageSrc }}" alt="{{ $wrestler->name }}" style="max-width: 320px; height: auto; border-radius: 8px;">
        </div>
    @endif

    <p><strong>Descrizione:</strong> {{ $wrestler->description }}</p>
    <p><strong>Nazionalità:</strong> {{ $wrestler->country }}</p>
    <p><strong>Stato:</strong> {{ $wrestler->is_active ? 'Attivo' : 'Ritirato' }}</p>

    <p>
        <strong>Categorie:</strong>
        {{ $wrestler->categories->pluck('name')->merge($wrestler->category ? [$wrestler->category->name] : [])->unique()->implode(', ') ?: 'Nessuna' }}
    </p>
    <p>
        <strong>Federazioni:</strong>
        {{ $wrestler->federations->pluck('name')->merge($wrestler->federation ? [$wrestler->federation->name] : [])->unique()->implode(', ') ?: 'Nessuna' }}
    </p>
</x-layout>