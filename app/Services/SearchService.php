<?php


namespace App\Services;

use App\Models\Message;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchService
{
    private $data;
    private $result = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function search()
    {
        $result[] = Message::search($this->data);
        $result[] = Profile::search($this->data);

        return $result;
    }
}
