<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chatbot as ChatbotModel;
use Livewire\Attributes\On;

class Chatbot extends Component
{
    public $chatbot;
    public $chatbotId;
    public $messages = [];
    public $isThinking = false;
    public $newMessage = '';
    public $isEmbedded = false;
    public $questions = [
        'What can this assistant do?',
        'Tell me about your widgets',
        'I have an issue with my widget',
        'I want to leave a review'
    ];

    public function mount($chatbotId = 1, $embedded = false)
    {
        $this->chatbotId = $chatbotId;
        $this->isEmbedded = $embedded;

        // Load chatbot data from database
        $this->chatbot = ChatbotModel::find($chatbotId);

        // If chatbot doesn't exist, create a default one
        if (!$this->chatbot) {
            $this->chatbot = new ChatbotModel([
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
        $this->isThinking = true;

        $this->dispatch('userMessageSent', $userMessage);
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


    #[On('userMessageSent')]
    public function addBotResponse($userMessage)
    {
        $response = $this->generateResponse($userMessage);

        $this->messages[] = [
            'text' => $response,
            'sender' => 'bot',
            'timestamp' => now()->format('g:i A')
        ];
        $this->isThinking = false;
        $this->dispatch('messageSent');

    }

    private function generateResponse($message)
    {
        $responses = [
            'What can this assistant do?' => 'I can help you with information about our real estate properties, answer questions about listings, and assist with property inquiries. I\'m trained on our current property database and can provide detailed information about available properties.',
            'Tell me about your widgets' => 'We offer a comprehensive real estate platform with features like property listings, virtual tours, and AI-powered property recommendations. Our widgets help showcase properties effectively.',
            'I have an issue with my widget' => 'I\'m sorry to hear you\'re having an issue. Please provide more details about the problem you\'re experiencing, and I\'ll do my best to help you resolve it.',
            'I want to leave a review' => 'Thank you for wanting to leave a review! You can share your feedback through our contact form or by reaching out to our support team. We value your input!'
        ];

        return $responses[$message] ?? 'Thank you for your message! I\'m here to help with any questions about our real estate services. What would you like to know?';
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}
