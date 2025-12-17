<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ApiController extends Controller
{
    public function gateway_email()
    {
        $data = DB::table('h_log_mail')->where('h_log_mail_status', '=', 0)->first();
        if ($data) {
            $details = [
                'name' => $data->h_log_mail_name,
                'title' => $data->h_log_mail_subject,
                'body' => $data->h_log_mail_messages
            ];
            DB::table('h_log_mail')->where('h_log_mail_code', $data->h_log_mail_code)->update([
                'h_log_mail_status' => 1
            ]);
            Mail::to($data->h_log_mail_address)->send(new \App\Mail\MyTestMail($details, $data->h_log_mail_subject));
            return response()->json($details);
        }
    }
    public function gateway_whatsapp($cabang)
    {
        $pesan = DB::table('message_wa_mcu')->where('message_wa_mcu_cabang', $cabang)->where('message_wa_mcu_status', 0)->first();
        return response()->json($pesan);
    }
    public function verify_gateway_whatsapp($id)
    {
        DB::table('message_wa_mcu')->where('message_wa_mcu_code', $id)->update([
            'message_wa_mcu_status' => 1,
            'updated_at' => now()
        ]);
    }
}
