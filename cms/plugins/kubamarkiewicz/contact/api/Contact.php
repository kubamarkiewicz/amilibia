<?php namespace KubaMarkiewicz\Contact\Api;

use Illuminate\Routing\Controller;
use Input;
use KubaMarkiewicz\Contact\Models\Settings;

class Contact extends Controller
{

    public function send()
    {
        // dump(Input::all()); exit;

        $vars = [];
        $vars['name'] = Input::get('name');
        $vars['company'] = Input::get('company');
        $vars['email_'] = Input::get('email');
        $vars['phone'] = Input::get('phone');
        $vars['message_'] = nl2br(Input::get('message'));

        // print_r($vars); exit;

        $result = Mail::send('kubamarkiewicz.contact::mail.contact', $vars, function($message) {

            $to = Settings::get('contact_email');
            $message->to($to);

        });

        return response()->json($result, 200, array(), JSON_PRETTY_PRINT);
    }

}