<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test the `store` method with valid data.
     */
    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post(route('register'), [
            'name' => 'John Dean',
            'username' => 'johndean',
            'email' => 'johndean@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ]);
    
        // Verifica che l'utente sia reindirizzato alla homepage
        $response->assertRedirect('/');
    
        // Verifica che l'utente sia creato nel database
        $this->assertDatabaseHas('users', [
            'name' => 'John Dean',
            'username' => 'johndean',
            'email' => 'johndean@example.com',
        ]);
    
        // Recupera l'utente dal database
        $user = User::where('username', 'johndean')->first();
        $this->assertNotNull($user);
    
        // Verifica che il percorso immagine sia stato salvato
        $this->assertNotNull($user->image_path);
        $this->assertStringStartsWith('profile_images/', $user->image_path);
    }

    /**
     * Test the `store` method with invalid data.
     */
    public function test_user_cannot_register_with_invalid_data()
    {
        // Eseguo una richiesta POST con dati mancanti o non validi
        $response = $this->post(route('register'), [
            'name' => '',
            'username' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'different',
            'image' => UploadedFile::fake()->image('profile.pdf'),
        ]);

        // Verifica che non ci sia stato un redirect alla homepage
        $response->assertStatus(302);

        // Verifica che ci siano errori nella sessione
        $response->assertSessionHasErrors([
            'name',
            'username',
            'email',
            'password',
            'image',
        ]);

        // Verifica che nessun utente sia stato creato
        $this->assertDatabaseMissing('users', [
            'email' => 'invalid-email',
        ]);
    }

    /**
     * Test the `store` method with duplicate data.
     */
    public function test_user_cannot_register_with_duplicate_data()
    {
        // Creare un utente esistente
        User::factory()->create([
            'name' => 'New user',
            'username' => 'newuser',
            'email' => 'newuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Tentare di registrare un nuovo utente con gli stessi dati
        $response = $this->post(route('register'), [
            'name' => 'New user',
            'username' => 'newuser', // Username già esistente
            'email' => 'newuser@example.com', // Email già esistente
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Verifica che la richiesta fallisca con errori di validazione
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'username' => 'Il nome utente è già stato preso. Scegline un altro.',
            'email' => 'L\'email è già registrata. Prova ad accedere.',
        ]);

        // Verifica che nessun nuovo utente sia stato creato
        $this->assertEquals(1, User::count());
    }

    
}
