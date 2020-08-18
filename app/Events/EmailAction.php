<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class EmailAction
{
    use SerializesModels;
    
    public $id;
    public $password;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id,$password)
    {
        $this->id = $id;
        $this->password = $password;
    }

}
