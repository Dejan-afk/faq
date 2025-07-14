<?php
namespace Tests\Feature;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($this->admin);
    }

    public function test_admin_can_create_tag()
    {
        $response = $this->post('/tags', [
            'name' => 'Test-Tag',
        ]);

        $response->assertRedirect('/tags');
        $this->assertDatabaseHas('tags', ['name' => 'Test-Tag']);
    }

    public function test_admin_can_update_tag()
    {
        $tag = Tag::factory()->create(['name' => 'Old Name']);

        $response = $this->put("/tags/{$tag->id}", [
            'name' => 'New Name',
        ]);

        $response->assertRedirect('/tags');
        $this->assertDatabaseHas('tags', ['name' => 'New Name']);
    }

    public function test_admin_can_delete_tag()
    {
        $tag = Tag::factory()->create();

        $response = $this->delete("/tags/{$tag->id}");

        $response->assertRedirect('/tags');
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    public function test_tag_name_must_be_unique_on_store()
    {
        Tag::factory()->create(['name' => 'Doppelt']);

        $response = $this->post('/tags', ['name' => 'Doppelt']);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_validation_error_on_empty_name()
    {
        $response = $this->post('/tags', ['name' => '']);

        $response->assertSessionHasErrors(['name']);
    }
}