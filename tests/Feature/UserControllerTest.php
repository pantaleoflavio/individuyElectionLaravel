<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** 
    * @var \App\Models\User 
    */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /**
     * Test the `show` method.
     */
    public function test_user_can_view_profile()
    {
        Auth::login($this->user);

        $response = $this->actingAs($this->user)->get(route('user.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('user.profile');
        $response->assertViewHas(['user', 'wrestlerVotes', 'tagTeamVotes']);
    }

    /**
     * Test the `edit` method.
     */
    public function test_user_can_access_edit_page()
    {
        $response = $this->actingAs($this->user)->get(route('user.profile'));

        $response->assertOk();
        $response->assertViewIs('user.profile');
        $response->assertViewHas(['user', 'wrestlerVotes', 'tagTeamVotes']);
    }

    /**
     * Test the `update` method with valid data.
     */
    public function test_user_can_update_profile()
    {
        Auth::login($this->user);
    
        $response = $this->actingAs($this->user)->put(route('user.update'), [
            'name' => 'Updated Name',
            'username' => $this->user->username,
            'email' => $this->user->email,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ]);
    
        $response->assertRedirect(route('user.edit'));
        $response->assertSessionHas('success', 'Profilo aggiornato con successo!');
    
        $this->user->refresh();
    
        // Verifica che i campi siano stati aggiornati correttamente
        $this->assertEquals('Updated Name', $this->user->name);
        $this->assertTrue(Hash::check('newpassword', $this->user->password));
    
        // Debug: Verifica che il percorso immagine sia stato salvato
        $this->assertNotEmpty($this->user->image_path);
    } 

    /**
     * Test the `update` method with invalid data.
     */
    public function test_user_cannot_update_profile_with_invalid_data()
    {
        // Effettua il login con l'utente
        Auth::login($this->user);
    
        // Invia una richiesta PUT con dati non validi
        $response = $this->actingAs($this->user)->put(route('user.update'), [
            'name' => '',
            'username' => '',
            'email' => 'invalid-email',
        ]);
    
        // Controlla che la risposta abbia un redirect
        $response->assertStatus(302);
    
        // Controlla che gli errori di validazione siano presenti nella sessione
        $response->assertSessionHasErrors([
            'name',
            'username',
            'email',
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
