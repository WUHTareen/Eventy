<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function optimizeDescription(Request $request)
    {
        $name = $request->input('name');
        $category = $request->input('category');
        $current = $request->input('description');

        // High-end luxury templates
        $templates = [
            "Experience the pinnacle of $category with our signature '$name' service. We blend technical mastery with an elite aesthetic to ensure your moments are nothing short of legendary.",
            "Elevate your event with '$name'. Our $category experts bring a level of refined sophistication and meticulous detail that transforms the ordinary into the extraordinary.",
            "Sophistication. Elegance. Mastery. Our '$name' $category offering is curated for those who demand the absolute best. Let us architect the background to your greatest memories."
        ];

        $optimized = $templates[array_rand($templates)];

        return response()->json([
            'success' => true,
            'optimized_text' => $optimized
        ]);
    }

    public function suggestImages(Request $request)
    {
        $category = $request->input('category');

        $suggestions = [
            'Media & Coverage' => [
                'A cinematic wide-angle shot of a grand ballroom entry.',
                'Close-up detail of high-end camera lenses or equipment with bokeh.',
                'A "Behind the Scenes" shot showing your team in professional attire.',
                'A split-screen edit showing raw vs. color-graded footage.'
            ],
            'Travel & Hospitality' => [
                'The view from the main balcony or window at golden hour.',
                'Crisp, white linen details with branded vanity kits.',
                'A slow-motion video of the luxury pool or spa area.',
                'Table setting with gourmet food items and premium lighting.'
            ],
            'Default' => [
                'Show your team in action with high-end tools.',
                'Capture the "Result" – happy clients in a luxury setting.',
                'Detail shots of your most expensive hardware/service assets.',
                'A high-contrast professional portrait of your lead coordinator.'
            ]
        ];

        $list = $suggestions[$category] ?? $suggestions['Default'];
        $html = '<ul class="space-y-3">';
        foreach ($list as $item) {
            $html .= '<li class="flex items-start gap-3"><i class="fa-solid fa-check-circle text-indigo-400 mt-1"></i> <span>' . $item . '</span></li>';
        }
        $html .= '</ul>';

        return response()->json([
            'success' => true,
            'suggestions' => $html
        ]);
    }

    public function serviceChat(Request $request)
    {
        $serviceId = $request->input('service_id');
        $query = strtolower($request->input('query'));
        $service = \App\Models\Service::find($serviceId);

        if (!$service) return response()->json(['success' => false, 'message' => 'Service not found.']);

        $responses = [
            'price' => "The base investment for '{$service->name}' is PKR " . number_format($service->price) . ". We also offer bespoke tiers and signature enhancements for a tailored experience.",
            'location' => "'{$service->name}' is currently deployed out of {$service->location}. We are fully equipped for regional and international engagements.",
            'booking' => "To initiate the protocol for '{$service->name}', simply click the 'Initiate Protocol' button on the dashboard. Our concierge will guide you through the secure escrow process.",
            'contact' => "For a direct dossier or specific inquiries, you can reach our coordination desk via the 'Inquiry Desk' button. We typically respond within the hour.",
            'default' => "I am an elite AI concierge. Regarding '{$service->name}', I can assist with pricing, logistics, and deployment protocols. How may I facilitate your experience today?"
        ];

        $key = 'default';
        if (str_contains($query, 'price') || str_contains($query, 'cost') || str_contains($query, 'pkr')) $key = 'price';
        elseif (str_contains($query, 'location') || str_contains($query, 'where') || str_contains($query, 'city')) $key = 'location';
        elseif (str_contains($query, 'book') || str_contains($query, 'schedule') || str_contains($query, 'reserve')) $key = 'booking';
        elseif (str_contains($query, 'contact') || str_contains($query, 'message') || str_contains($query, 'call')) $key = 'contact';

        return response()->json([
            'success' => true,
            'response' => $responses[$key]
        ]);
    }
}
