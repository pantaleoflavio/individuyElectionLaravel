<x-layout>
    <x-second-title>{{ $tagTeam->name }}</x-second-title>

    @php
        $imageUrl = $tagTeam->image_url;
        $imageSrc = null;
        if ($imageUrl) {
            if (\Illuminate\Support\Str::startsWith($imageUrl, 'data:image/')) {
                $imageSrc = $imageUrl;
            } elseif (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://', '//'])) {
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
            <img src="{{ $imageSrc }}" alt="{{ $tagTeam->name }}" style="max-width: 320px; height: auto; border-radius: 8px;">
        </div>
    @endif

    <p><strong>Descrizione:</strong> {{ $tagTeam->description }}</p>
    <p><strong>Nazionalità:</strong> {{ $tagTeam->country }}</p>
    <p><strong>Stato:</strong> {{ $tagTeam->is_active ? 'Attivo' : 'Ritirato' }}</p>

    <p>
        <strong>Categorie:</strong>
        {{ $tagTeam->categories->pluck('name')->merge($tagTeam->category ? [$tagTeam->category->name] : [])->unique()->implode(', ') ?: 'Nessuna' }}
    </p>
    <p>
        <strong>Federazioni:</strong>
        {{ $tagTeam->federations->pluck('name')->merge($tagTeam->federation ? [$tagTeam->federation->name] : [])->unique()->implode(', ') ?: 'Nessuna' }}
    </p>
</x-layout>