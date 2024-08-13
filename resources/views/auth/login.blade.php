<x-layout>
    <x-second-title>Login</x-second-title>
    <form action="/login" method="post">
        @csrf
        @method('')
        <div class="mb-3">
            <label for="email" class="form-label">Indirizzo Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary">Accedi</button>
    </form>
        <div class="mt-3">
            <a href="">Hai dimenticato la password?</a>
        </div>
</x-layout>