<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * Test the `show` method.
     */
    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->actingAs($user)->get(route('user.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('user.profile');
        $response->assertViewHas(['user', 'wrestlerVotes', 'tagTeamVotes']);
    }

    /**
     * Test the `edit` method.
     */
    public function test_user_can_access_edit_page()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $response = $this->actingAs($user)->get(route('user.edit'));

        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user', $user);
    }

    /**
     * Test the `update` method with valid data.
     */
    public function test_user_can_update_profile()
    {
        
        $user = User::factory()->create();
        Auth::login($user);
    
        $response = $this->actingAs($user)->put(route('user.update'), [
            'name' => 'Updated Name',
            'username' => $user->username,
            'email' => $user->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ]);
    
        $response->assertRedirect(route('user.edit'));
        $response->assertSessionHas('success', 'Profilo aggiornato con successo!');
    
        $user->refresh();
    
        // Verifica che i campi siano stati aggiornati correttamente
        $this->assertEquals('Updated Name', $user->name);
        $this->assertTrue(Hash::check('newpassword', $user->password));
    
        // Debug: Verifica che il percorso immagine sia stato salvato
        $this->assertNotEmpty($user->image_path);
    } 

    /**
     * Test the `update` method with invalid data.
     */
    public function test_user_cannot_update_profile_with_invalid_data()
    {
        // Crea un utente
        $user = User::factory()->create();
    
        // Effettua il login con l'utente
        Auth::login($user);
    
        // Invia una richiesta PUT con dati non validi
        $response = $this->actingAs($user)->put(route('user.update'), [
            'name' => '', // Nome vuoto
            'username' => '', // Username vuoto
            'email' => 'invalid-email', // Email non valida
        ]);
    
        // Controlla che la risposta abbia un redirect (fallimento della validazione)
        $response->assertStatus(302);
    
        // Controlla che gli errori di validazione siano presenti nella sessione
        $response->assertSessionHasErrors([
            'name',     // Errore per il campo `name`
            'username', // Errore per il campo `username`
            'email',    // Errore per il campo `email`
        ]);
    }
    

    /**
     * Test the `destroy` method (stub).
     */
    //public function test_user_can_be_deleted()
    //{
     //   $user = User::factory()->create();
     //   Auth::login($user);

        // Stub: implement logic in the controller before testing.
    //    $this->assertTrue(true);
    //}
    
}
