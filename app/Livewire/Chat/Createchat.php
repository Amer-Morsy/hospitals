<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Message;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Livewire\Component;

class Createchat extends Component
{
    public $users;
    public $auth_email;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        if (!Auth::guard('patient')->check() && !Auth::guard('doctor')->check()) {
            return redirect()->route('selection');
        }

        $this->auth_email = Auth::guard('patient')->check() 
            ? Auth::guard('patient')->user()->email 
            : Auth::guard('doctor')->user()->email;
    }

    public function createConversation($receiver_email)
    {
        if (!Auth::guard('patient')->check() && !Auth::guard('doctor')->check()) {
            $this->redirect(route('selection'));
            return;
        }

        $chek_Conversation = Conversation::checkConversation($this->auth_email, $receiver_email)->get();
        
        if ($chek_Conversation->isEmpty()) {
            DB::beginTransaction();
            try {
                $createConversation = Conversation::create([
                    'sender_email' => $this->auth_email,
                    'receiver_email' => $receiver_email,
                    'last_time_message' => now(),
                ]);

                Message::create([
                    'conversation_id' => $createConversation->id,
                    'sender_email' => $this->auth_email,
                    'receiver_email' => $receiver_email,
                    'body' => 'السلام عليكم',
                ]);

                DB::commit();
                return redirect()->route('chatbox', ['conversation' => $createConversation->id]);
            } catch (\Exception $e) {
                DB::rollBack();
                session()->flash('error', 'حدث خطأ ما');
            }
        } else {
            return redirect()->route('chatbox', ['conversation' => $chek_Conversation->first()->id]);
        }

    }

    public function render()
    {
        if (!Auth::guard('patient')->check() && !Auth::guard('doctor')->check()) {
            return view('livewire.chat.createchat');
        }

        if (Auth::guard('patient')->check()) {
            $this->users = Doctor::all();
        } else {
            $this->users = Patient::all();
        }

        return view('livewire.chat.createchat');
    }
}
