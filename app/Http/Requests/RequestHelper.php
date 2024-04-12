<?php

namespace App\Http\Requests;

trait RequestHelper
{
    public function flashSuccessMessage(string $message): void
    {
        $this->flashMessage($message, 'success');
    }


    public function flashInfoMessage(string $message): void
    {
        $this->flashMessage($message, 'info');
    }


    private function flashMessage(string $message, string $type): void
    {
        if (!empty($message)) {
            $this->session()->flash('message', [
                'type' => $type,
                'content' => $message,
                'align' => 'center',
            ]);
        }
    }
}