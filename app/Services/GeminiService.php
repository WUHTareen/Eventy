<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->model = config('services.gemini.model', 'gemini-1.5-flash');
    }

    /**
     * Generate content based on a prompt.
     */
    public function generateContent(string $prompt)
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API key is missing.');
            return [
                'success' => false,
                'message' => 'AI Service is currently unavailable (Mising API Key).'
            ];
        }

        try {
            $response = Http::post($this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if ($text) {
                    return [
                        'success' => true,
                        'text' => trim($text)
                    ];
                }
            }

            Log::error('Gemini API error: ' . $response->body());
            return [
                'success' => false,
                'message' => 'Failed to generate content from AI.'
            ];

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred while connecting to the AI service.'
            ];
        }
    }

    /**
     * Optimize a service description.
     */
    public function optimizeDescription(string $serviceName, string $category, string $currentDescription = '')
    {
        $prompt = "You are a professional marketing copywriter for an event services platform. 
        Enhance the following service listing to make it more appealing, professional, and persuasive for customers.
        
        Service Name: {$serviceName}
        Category: {$category}
        Current Description: {$currentDescription}
        
        Requirements:
        1. Use a professional and engaging tone.
        2. Highlight the value proposition.
        3. Use bullet points for key features if appropriate.
        4. Keep it concise but descriptive (max 250 words).
        5. Return ONLY the enhanced description text without any labels like 'Enhanced Description:' or 'Here is your text:'.";

        return $this->generateContent($prompt);
    }

    /**
     * Suggest photos for a service.
     */
    public function suggestImages(string $serviceName, string $category)
    {
        $prompt = "You are a creative consultant for an event services platform. 
        A vendor is listing a service called '{$serviceName}' in the '{$category}' category.
        
        Suggest 4-5 high-impact, professional photo ideas they should include in their gallery to maximize bookings.
        For each idea, provide a short 'Why it works' explanation.
        
        Format the response as a clean HTML bulleted list. 
        Return ONLY the HTML list without any intro or outro text.";

        return $this->generateContent($prompt);
    }

    /**
     * Answer customer questions about a service.
     */
    public function answerServiceQuery($service, string $query)
    {
        $packages = json_encode($service->packages);
        $addons = json_encode($service->add_ons);
        $categoryName = $service->category->name ?? 'N/A';
        
        $prompt = "You are an AI Concierge for an elite event services platform. 
        Your goal is to answer a customer's question about a specific service listing.
        
        SERVICE DETAILS:
        Name: {$service->name}
        Category: {$categoryName}
        Description: {$service->description}
        Packages: {$packages}
        Add-ons: {$addons}
        Location: {$service->location}
        
        CUSTOMER QUESTION:
        '{$query}'
        
        INSTRUCTIONS:
        1. Be polite, helpful, and professional.
        2. Use the provided service details to answer accurately.
        3. If the information is not in the details, politely say you don't have that specific information and suggest they contact the vendor directly.
        4. Keep your response concise (max 3-4 sentences).
        5. Respond in a natural, conversational tone.
        6. Return ONLY the answer text.";

        return $this->generateContent($prompt);
    }
}
