<x-layout>
    <x-second-title>Registrazione</x-second-title>
        <form action="/register" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Your full name</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Your email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="username">Your username</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="image">Profile Image</label>
                <input class="form-control" type="file" name="image" id="image">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
            </div>
            <button type="submit" name="signup" class="btn btn-primary">Registrati</button>
        </form>
</x-layout>