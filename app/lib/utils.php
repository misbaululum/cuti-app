<?php

use App\Models\SetupAplikasi;
use Illuminate\Support\Facades\Cache;

if (!function_exists('responseSuccess')) 
{
    function responseSuccess(string $message = 'Berhasil menyimpan data')
    {
        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }
}

if (!function_exists('responseError')) 
{
    function responseError(string | \Exception $th)
    {
        $message = 'Terjadi kesalahan, silahkan coba beberapa saat lagi';
        if ($th instanceof \Exception) {
            if (config('app.debug')) {
                $message = $th->getMessage();
                $message .= ' in line ' . $th->getLine(). ' at '. $th->getFile();
                $data = $th->getTrace();
                
            }
        } else {
            $message = $th;
        } 


        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data ?? null
        ], 500);
    }
}

if (!function_exists('convertDate')) 
{
    function convertDate($date, $format = 'd-m-Y'): string {
     return date_create($date)->format($format);   
    }
}

if (!function_exists('user')) {
    function user($key = null): string | \App\Models\User
    {
        if ($key) {
            return request()->user()?->{$key};
        }

        return request()->user();
    }
}
 
if (!function_exists('setupAplikasi')) {
    function setupAplikasi($key = null): SetupAplikasi | string | array
    {
        if (!Cache::has('setupAplikasi')) Cache::forever('setupAplikasi', SetupAplikasi::first());
        $setupAplikasi = Cache::get('setupAplikasi');

        if ($key) {
            return $setupAplikasi->{$key};
        }

        return $setupAplikasi;
    }
}