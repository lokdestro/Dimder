<?php 
 
namespace App\Mail; 
 
use Illuminate\Bus\Queueable; 
use Illuminate\Contracts\Queue\ShouldQueue; 
use Illuminate\Mail\Mailable; 
use Illuminate\Queue\SerializesModels; 
 
class ConfirmOperatorAssignMail extends Mailable 
{ 
    use Queueable, SerializesModels; 
    /** 
     * @var string 
     */ 
    private $hash; 
 
    /** 
     * Create a new message instance. 
     * 
     * @param string $hash 
     */ 
    public function __construct(string $hash) 
    { 
        $this->hash = $hash; 
    } 
 
    /** 
     * Build the message. 
     * 
     * @return $this 
     */ 
    public function build() 
    { 
        return $this->view('mail', ['hash' => $this->hash]) 
            ->subject(sprintf('%s | %s', env('APP_NAME'), 'Подтверждение добавление в качестве оператора')); 
    } 
}