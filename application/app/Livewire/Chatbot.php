<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Chatbot as ChatbotModel;

class Chatbot extends Component
{
    public string $tab = 'settings';
    public bool $includeNotAvailableProperty = false;
    public string $primaryColor = '#3490dc';
    public string $welcomeMessage = 'Welcome! How can I help you today?';
    public string $headline = 'Chat with us';
    public array $logs = [];

    public function mount()
    {
        $this->loadChatbotSettings();
    }

    public function loadChatbotSettings()
    {
        $chatbot = Auth::user()->chatbot;

        if ($chatbot) {
            $this->includeNotAvailableProperty = $chatbot->include_not_available_property;
            $this->primaryColor = $chatbot->primary_color;
            $this->welcomeMessage = $chatbot->welcome_message ?? '';
            $this->headline = $chatbot->headline ?? '';
        }
    }

    public function updateSettings()
    {
        $this->validate([
            'primaryColor' => 'required|string',
            'includeNotAvailableProperty' => 'boolean',
            'welcomeMessage' => 'nullable|string',
            'headline' => 'nullable|string',
        ]);

        $chatbot = Auth::user()->chatbot;

        if ($chatbot) {
            $chatbot->update([
                'primary_color' => $this->primaryColor,
                'include_not_available_property' => $this->includeNotAvailableProperty,
                'welcome_message' => $this->welcomeMessage,
                'headline' => $this->headline,
            ]);
        } else {
            Auth::user()->chatbots()->create([
                'primary_color' => $this->primaryColor,
                'include_not_available_property' => $this->includeNotAvailableProperty,
                'welcome_message' => $this->welcomeMessage,
                'headline' => $this->headline,
            ]);
        }
        Flux::toast('Settings updated successfully!', variant: 'success');
    }

    public function copyEmbedCode()
    {
        // Logic for copying embed code (handled in JS/UI)
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}
