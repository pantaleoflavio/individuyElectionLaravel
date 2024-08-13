@props(['title', 'text', 'href', 'linkLabel'])

<div class="col-md-6 mb-4">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $title }}</h2>
            <p class="card-text">{{ $text }}</p>
            <a href="{{ $href }}" class="btn btn-primary">{{ $linkLabel }}</a>
        </div>
    </div>
</div>