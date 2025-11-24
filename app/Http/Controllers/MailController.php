<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\passwordReset;

class MailController extends Controller
{
    public function index()
    {
        Mail::to('chromedm@live.co.uk')->send(new passwordReset([
            'title' => 'The Title',
            'body' => 'The Body',
        ]));
    }
}