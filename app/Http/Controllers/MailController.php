<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;

class MailController extends Controller
{
    public static function sendSignupEmail($name, $email, $verificationCode)
    {
        $data = [
            'name' => $name,
            'emailTo' => $email,
            'verificationCode' => $verificationCode
        ];

        SendEmailJob::dispatch($data);

    }
}
