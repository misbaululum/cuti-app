<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Notifications\CutiNotification;
use Illuminate\Support\Facades\Notification;

class CutiApproveController extends Controller
{
    public function show(Cuti $cuti)
    {
        $action = null;
        if ($cuti->latestHistory->next_approve_id == user('id')) {
            $action = route('pengajuan.cuti.approve.store', $cuti->uuid);
        }
        return view('pages.pengajuan.cuti-form-detail',[
            'action' => $action,
            'data' => $cuti
        ]);
    }

    public function storeApprove(Request $request, Cuti $cuti)
    {
        $request->validate([
            'status_approve' => 'required',
            'keterangan' => [Rule::requiredIf(function() {
                return request('status_approve') == '0';
            })]
        ]);

        DB::beginTransaction();
        try {
            $request->merge(['tanggal_awal' => $cuti->tanggal_awal, 'tanggal_akhir' => $cuti->tanggal_akhir]);
            $cuti->fill([
                'status_approve' => $request->status_approve,
                'user_approve' => user('nama'),
                'user_approve_id' => user('id'),
                'tanggal_approve' => now(),
            ]);

            $atasanUser = $cuti->user->atasan;
            foreach($atasanUser as $item) {
                if ($item->id == user('id')) {
                    $level = $item->pivot->level + 1;
                }
            }

            if (isset($level)) {
                $atasan = $atasanUser->firstWhere('pivot.level', $level);
            }

            $nextApprove = $nextApprove = [
                'next_approve_id' => null,
                'next_approve' => null
            ];

            // jika setuju
            if ($request->status_approve == 1) {
                // jika masih ada atasan lanjut notif ke atasan untuk proses selanjutnya
                if (isset($atasan) && $atasan) {
                    Notification::send($atasan, new CutiNotification($cuti, [
                        'title' => $cuti->notificationTitle(),
                        'body' => 'Terdapat pengajuan nomor: ' . $cuti->nomor . ', an ' . $cuti->user_input,
                    ]));

                    $nextApprove = [
                        'next_approve_id' => $atasan->id,
                        'next_approve' => $atasan->nama
                    ];
                } else {
                    // update sisa cuti
                    if (user()->hasRole('hrd') && $cuti->step == $cuti->step_approve) {
                        $cutiTahunan = $cuti->user->cutiTahunanActive;
                        $cutiTahunan->digunakan = $cutiTahunan->digunakan + $cuti->total_cuti;
                        $cutiTahunan->save();
                        Notification::send($cuti->user, new CutiNotification($cuti, [
                            'title' => $cuti->notificationTitle(),
                            'body' => 'Pengajuan cuti telah disetujui oleh: ' . $cuti->user_approve,
                            'priority' => 2
                        ]));
                    } else {
                        $hrd = User::role('hrd')->first();
                        $nextApprove = [
                            'next_approve_id' => $hrd->id,
                            'next_approve' => $hrd->nama
                        ];
                        // notif ke hrd
                        Notification::send(User::role('hrd')->get(), new CutiNotification($cuti, [
                            'title' => $cuti->notificationTitle(),
                            'body' => 'Terdapat pengajuan nomor: ' . $cuti->nomor . ', an ' . $cuti->user_input,
                        ]));
                    }
                }
            } else {
                Notification::send($cuti->user, new CutiNotification($cuti, [
                    'title' => $cuti->notificationTitle(),
                    'body' => 'Pengajuan cuti ditolak oleh: ' . $cuti->user_approve,
                    'priority' => 2
                ]));
            }


            $cuti->history()->create([
                ...$nextApprove,
                'status_approve' => $cuti->status_approve,
                'user_approve' => $cuti->user_approve,
                'user_id' => $cuti->user_approve_id,
                'keterangan' => $request->keterangan,
                'tanggal' => now(),
            ]);

            user()->markAsRead($cuti);
            $cuti->save();

            DB::commit();
            return responseSuccess();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseError($th);
        }
    }
}
