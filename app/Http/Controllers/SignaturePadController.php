<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SignaturePadController extends Controller
{
    public function index()
    {

        return view('signaturePad');

    }
    public function sign($id)
    {
        $data= DB::table('company_mou_peserta')
        ->join('log_kehadiran_pasien','log_kehadiran_pasien.mou_peserta_code','=','company_mou_peserta.mou_peserta_code')
        ->where('log_kehadiran_pasien_token',$id)->first();
        return view('signaturepad.form-sign',['data'=>$data]);
    }

    public function upload(Request $request)
    {
        $folderPath = public_path('/signature/');
        $image_parts = explode(";base64,", $request->signed);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . Str::uuid() . '.' . $image_type;
        // $request->file->move(public_path('uploads'), uniqid() . '.' . $image_type);
        file_put_contents($file, $image_base64);
        return back()->with('success', 'success Full upload signature');
    }
    public function update(Request $request){
        DB::table('log_kehadiran_pasien')->where('log_kehadiran_pasien_token',$request->token)->update([
            'log_kehadiran_pasien_sign'=>$request->signed,
            'log_kehadiran_pasien_status'=>1,
            'log_kehadiran_pasien_time'=>now(),
        ]);
        return back()->with('success', 'success Full upload signature');
    }
}
