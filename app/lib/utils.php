<?php

use App\Models\SetupAplikasi;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

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
    function convertDate($date, $format = 'd-m-Y')
    {
        if (!$date) return null;
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


// if (!function_exists('numbering')) {
//     function numbering(Model $model, $format, $column = 'nomor', $length = 4)
//     {
//         $model = $model->select(\Illuminate\Support\Facades\DB::raw("MAX($column) as $column"))->where("$column", 'like', "%{$format}%")->orderByDesc('id')->first();

//         // PC24110001
//         return $format . sprintf("%0{$length}s", ((int) substr($model->{$column}, strlen($format), $length)) + 1);
//     }
// }

if (!function_exists('numbering')) {
    function numbering(Model $model, $format, $column = 'nomor', $length = 6)
    {
        // Cari data terakhir dengan nomor sesuai format
        $model = $model->where($column, 'like', "{$format}%")
            ->orderByDesc('id')
            ->first([$column]);

        if (!$model) {
            // Jika tidak ada nomor sebelumnya, mulai dari 1
            return $format . sprintf("%0{$length}s", 1);
        }

        // Ekstrak angka dari kolom nomor
        $lastNumber = (int) substr($model->{$column}, strlen($format), $length);

        // Buat nomor baru
        return $format . sprintf("%0{$length}s", $lastNumber + 1);
    }
}

if (!function_exists('notifications')) {
    function notifications()
    {
        return user()->unreadNotifications;
    }
}

if (!function_exists('hmin')) {
    function hmin($min = 7, $format = 'Y-m-d')
    {
        $min += 1;
        return date_create("+{$min} days")->format($format);
    }
}