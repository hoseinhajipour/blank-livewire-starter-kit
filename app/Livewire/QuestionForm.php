<?php

namespace App\Livewire;

use App\Models\Question;
use App\Support\SiteCatalog;
use Livewire\Component;

class QuestionForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $service_slug = '';
    public string $subject = '';
    public string $body = '';
    public bool $sent = false;

    public function submit(): void
    {
        $this->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'nullable|email|max:150',
            'service_slug' => 'required|in:'.implode(',', array_column(SiteCatalog::services(), 'slug')),
            'subject' => 'required|min:3|max:180',
            'body' => 'required|min:10|max:5000',
        ]);

        Question::create([
            'service_slug' => $this->service_slug,
            'name' => $this->name,
            'email' => $this->email ?: null,
            'subject' => $this->subject,
            'body' => $this->body,
            'status' => 'pending',
        ]);

        $this->reset(['name', 'email', 'service_slug', 'subject', 'body']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.question-form', ['services' => SiteCatalog::services()]);
    }
}
