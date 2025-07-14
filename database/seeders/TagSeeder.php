<?php

namespace Database\Seeders;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'Video',
            'Barrierefreiheit',
            'Untertitel',
            'Offline-Nutzung',
            'Download',
        ];

        foreach ($tags as $tagName) {
            Tag::updateOrCreate(
                ['name' => $tagName],
                []
            );
        }
    }
}
