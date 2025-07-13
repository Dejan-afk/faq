<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;
use App\Models\Category;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/fragen-antworten.json');

        if (!file_exists($jsonPath)) {
            $this->command->error("JSON-Datei nicht gefunden: {$jsonPath}");
            return;
        }

        $faqData = json_decode(file_get_contents($jsonPath), true);

        if (!$faqData || !is_array($faqData)) {
            $this->command->error("Fehler beim Parsen der JSON-Datei.");
            return;
        }

        // Kategorien einfügen
        $categories = collect($faqData)->pluck('category')->unique();

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]); 
        }

        // FAQs einfügen
        foreach ($faqData as $item) {
            $category = Category::where('name', $item['category'])->first();

            if (!$category) {
                $this->command->warn("Kategorie '{$item['category']}' nicht gefunden. Frage wird übersprungen.");
                continue;
            }

            Faq::updateOrCreate(
                [
                    'question' => $item['question'],
                ],
                [
                    'category_id' => $category->id,
                    'answer'      => $item['answer'],
                    'is_active'   => true,
                ]
            );

            $this->command->info("FAQ '{$item['question']}' hinzugefügt.");

        }

        $this->command->info("FAQ-Seeding abgeschlossen.");
    }
}
