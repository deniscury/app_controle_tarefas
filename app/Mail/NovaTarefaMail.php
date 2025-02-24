<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Tarefa;

class NovaTarefaMail extends Mailable
{
    use Queueable, SerializesModels;
    public $tarefa, $data_limite_conclusao, $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tarefa $tarefa)
    {
        //
        $this->tarefa = $tarefa->tarefa;
        $this->data_limite_conclusao = $tarefa->data_limite_conclusao;
        $this->url = 'http://127.0.0.1:8000/tarefa/'.$tarefa->id;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                    ->markdown('emails.nova-tarefa')
                    ->subject('Nova Tarefa Criada');
    }
}
