<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home | KESRA',
            'pendingCount' => $this->pendingCount
        ];

        return view('pages/home', $data);
    }


}
