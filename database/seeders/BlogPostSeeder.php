<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogPost;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'The Rise of Neural Travel: Predictive Itineraries',
                'excerpt' => 'How AI is transforming the standard vacation into a high-precision execution of personalized desires...',
                'content' => 'Full report on how neural matching engines are revolutionizing the luxury travel sector by predicting user preferences before they are even voiced.',
                'featured_image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2070&auto=format&fit=crop',
                'category' => 'Strategic Briefing',
            ],
            [
                'title' => 'Digital Concierge vs Human Touch',
                'excerpt' => 'Analyzing the friction points in premium automated service delivery...',
                'content' => 'A deep dive into the balance between AI efficiency and the irreplaceable value of human empathy in the hospitality industry.',
                'featured_image' => 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?q=80&w=2074&auto=format&fit=crop',
                'category' => 'Hospitality Core',
            ],
            [
                'title' => 'Encryption in Event Logistics',
                'excerpt' => 'Securing high-profile client data across fragmented vendor pipelines...',
                'content' => 'Technical specifications for the end-to-end encryption protocols required to protect VIP data during large-scale global events.',
                'featured_image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2070&auto=format&fit=crop',
                'category' => 'Protocol Insight',
            ],
            [
                'title' => 'The 2026 Luxury Global Calendar',
                'excerpt' => 'Previewing the most exclusive events across our priority global nodes...',
                'content' => 'An executive overview of the upcoming year\'s most prestigious summits, galas, and travel benchmarks.',
                'featured_image' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=2070&auto=format&fit=crop',
                'category' => 'Global Reach',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'featured_image' => $post['featured_image'],
                'category' => $post['category'],
                'is_published' => true,
                'published_at' => now(),
            ]);
        }
    }
}
