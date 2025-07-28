<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ApiController extends Controller
{
    public function gateway_email()
    {
        $data = DB::table('h_log_mail')->where('h_log_mail_status','=', 0)->first();
        if ($data) {
            $details = [
                'name' => $data->h_log_mail_name,
                'title' => $data->h_log_mail_subject,
                'body' => $data->h_log_mail_messages
            ];
            Mail::to($data->h_log_mail_address)->send(new \App\Mail\MyTestMail($details,$data->h_log_mail_subject));
            DB::table('h_log_mail')->where('h_log_mail_code', $data->h_log_mail_code)->update([
                'h_log_mail_status' => 1
            ]);
            return response()->json($details);
        }
    }
}
