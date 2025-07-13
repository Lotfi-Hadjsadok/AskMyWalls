<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chatbot;

class ChatbotDemo extends Component
{
    public $chatbot;
    public $chatbotId;
    public $messages = [];
    public $newMessage = '';
    public $isEmbedded = false;

    public function mount($chatbotId = 1, $embedded = false)
    {
        $this->chatbotId = $chatbotId;
        $this->isEmbedded = $embedded;

        // Load chatbot data from database
        $this->chatbot = Chatbot::find($chatbotId);

        // If chatbot doesn't exist, create a default one
        if (!$this->chatbot) {
            $this->chatbot = new Chatbot([
                'primary_color' => '#FF6B9D',
                'welcome_message' => 'Hi there 👋<br>Welcome to ElfSight!<br>How can I help you today?',
                'headline' => 'Virtual Assistant',
                'include_not_available_property' => false,
            ]);
        }

        // Initialize with welcome message
        $this->messages = [
            [
                'text' => $this->chatbot->welcome_message ?? 'Hi there 👋<br>Welcome to ElfSight!<br>How can I help you today?',
                'sender' => 'bot',
                'timestamp' => now()->format('g:i A')
            ]
        ];
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage))) {
            return;
        }

        // Add user message
        $this->messages[] = [
            'text' => $this->newMessage,
            'sender' => 'user',
            'timestamp' => now()->format('g:i A')
        ];

        $userMessage = $this->newMessage;
        $this->newMessage = '';

        // Simulate AI response
        $this->addBotResponse($userMessage);

        // Dispatch messageSent event
        $this->dispatch('messageSent');
    }

    public function sendQuickAction($message)
    {
        // Add user message
        $this->messages[] = [
            'text' => $message,
            'sender' => 'user',
            'timestamp' => now()->format('g:i A')
        ];

        // Add bot response
        $this->addBotResponse($message);

        // Dispatch messageSent event
        $this->dispatch('messageSent');
    }

    private function addBotResponse($userMessage)
    {
        $response = $this->generateResponse($userMessage);

        $this->messages[] = [
            'text' => $response,
            'sender' => 'bot',
            'timestamp' => now()->format('g:i A')
        ];
    }

    private function generateResponse($message)
    {
        $responses = [
            'What can this assistant do?' => 'I can help you with property inquiries, provide information about available listings, answer questions about real estate, and guide you through our services!',
            'Tell me about your widgets' => 'Our widgets include property search tools, virtual tours, mortgage calculators, and neighborhood information displays. They\'re designed to enhance your real estate experience!',
            'I have an issue with my widget' => 'I\'m sorry to hear you\'re experiencing issues. Could you please describe what specific problem you\'re encountering? I\'ll do my best to help you resolve it.',
            'I want to leave a review' => 'Thank you for wanting to share your feedback! You can leave a review on our website or I can guide you through the process. What would you like to review?',
        ];

        return $responses[$message] ?? 'Thank you for your message! I\'m here to help with any questions about our real estate services. What would you like to know?';
    }

    public function render()
    {
        return view('livewire.chatbot-demo');
    }
}