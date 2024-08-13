<table id="{{ $id ?? 'table' }}" class="table">
    <thead>
        {{ $header }}
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
