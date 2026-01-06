<x-layout>
    <x-second-title>Registrazione</x-second-title>
    <form action="/register" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Your full name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Your email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="username">Your username</label>
            <input type="text" class="form-control" name="username" id="username" value="{{ old('username') }}" required>
            @error('username')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Profile Image</label>
            <input class="form-control" type="file" name="image" id="image">
            @error('image')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
        </div>
        <button type="submit" name="signup" class="btn btn-primary my-2">Registrati</button>
    </form>
</x-layout>
