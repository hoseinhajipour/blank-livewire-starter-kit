<?php

namespace App\Livewire;

use App\Models\Question;
use App\Support\SiteCatalog;
use Livewire\Component;

class FaqPreview extends Component
{
    public function render()
    {
        $services = SiteCatalog::services();
        $questions = Question::approved()->latest('approved_at')->take(5)->get()->map(function (Question $question) use ($services): array {
            $service = collect($services)->firstWhere('slug', $question->service_slug);

            return [
                'tag' => $service['title'] ?? 'دندانپزشکی',
                'question' => $question->subject,
                'answer' => $question->answer,
                'date' => optional($question->approved_at)->diffForHumans() ?? 'تازه',
            ];
        });

        return view('livewire.faq-preview', compact('questions'));
    }
}
