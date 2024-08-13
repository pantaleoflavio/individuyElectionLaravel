@props(['title', 'text', 'href'])

<div class="col-md-6 mb-4">
    <a href="{{ $href }}">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h2>{{ $title }}</h2>
                <p>{{ $text }}</p>
            </div>
        </div>
    </a>
</div>