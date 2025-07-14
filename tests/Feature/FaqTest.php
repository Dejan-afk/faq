<?php
namespace Tests\Feature;

use App\Models\Faq;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_admin_can_create_faq()
    {
        $category = Category::factory()->create();
        $tags = Tag::factory()->count(2)->create();

        $response = $this->post('/faqs', [
            'question' => 'Was ist Laravel?',
            'answer' => 'Ein PHP-Framework.',
            'category' => $category->id,
            'tags' => $tags->pluck('id')->toArray(),
        ]);

        $response->assertRedirect('/faqs');
        $this->assertDatabaseHas('faqs', ['question' => 'Was ist Laravel?']);
        $this->assertDatabaseCount('faq_tag', 2);
    }

    public function test_admin_can_update_faq()
    {
        $category = Category::factory()->create();
        $faq = Faq::factory()->create([ 'category_id' => $category->id ]);
        $newCategory = Category::factory()->create();

        $response = $this->put("/faqs/{$faq->id}", [
            'question' => 'Neue Frage',
            'answer' => 'Neue Antwort',
            'category' => $newCategory->id,
            'tags' => [],
        ]);

        $response->assertRedirect('/faqs');
        $this->assertDatabaseHas('faqs', ['question' => 'Neue Frage']);
    }

    public function test_admin_can_delete_faq()
    {
        $faq = Faq::factory()->create();

        $response = $this->delete("/faqs/{$faq->id}");

        $response->assertRedirect('/faqs');
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    public function test_validation_errors_on_store()
    {
        $response = $this->post('/faqs', []);
        $response->assertSessionHasErrors(['question', 'answer', 'category']);
    }

    public function test_question_must_be_unique_on_store()
    {
        $faq = Faq::factory()->create(['question' => 'Doppelt?']);
        $response = $this->post('/faqs', [
            'question' => 'Doppelt?',
            'answer' => 'Antwort',
            'category' => Category::factory()->create()->id,
        ]);
        $response->assertSessionHasErrors(['question']);
    }
}