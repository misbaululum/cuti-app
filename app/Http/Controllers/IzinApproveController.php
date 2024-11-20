<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\User;
use App\Notifications\IzinNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class IzinApproveController extends Controller
{
    public function show(Izin $izin)
    {
        $action = null;
        if ($izin->latestHistory->next_approve_id == user('id')) {
            $action = route('pengajuan.izin.approve.store', $izin->uuid);
        }
        return view('pages.pengajuan.izin-form-detail',[
            'action' => $action,
            'data' => $izin
        ]);
    }

    public function storeApprove(Request $request, Izin $izin)
    {
        $request->validate([
            'status_approve' => 'required',
            'keterangan' => [Rule::requiredIf(function() {
                return request('status_approve') == '0';
            })]
        ]);

        DB::beginTransaction();
        try {
            $request->merge(['tanggal_awal' => $izin->tanggal_awal, 'tanggal_akhir' => $izin->tanggal_akhir]);
            $izin->fill([
                'status_approve' => $request->status_approve,
                'user_approve' => user('nama'),
                'user_approve_id' => user('id'),
                'tanggal_approve' => now(),
            ]);

            $atasanUser = $izin->user->atasan;
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
                    Notification::send($atasan, new IzinNotification($izin, [
                        'title' => $izin->notificationTitle(),
                        'body' => 'Terdapat pengajuan nomor: ' . $izin->nomor . ', an ' . $izin->user_input,
                    ]));

                    $nextApprove = [
                        'next_approve_id' => $atasan->id,
                        'next_approve' => $atasan->nama
                    ];
                } else {
                    // update sisa cuti
                    if (user()->hasRole('hrd') && $izin->step == $izin->step_approve) {
                        $izinTahunan = $izin->user->cutiTahunanActive;
                        $izinTahunan->digunakan = $izinTahunan->digunakan + $izin->total_cuti;
                        $izinTahunan->save();
                        Notification::send($izin->user, new IzinNotification($izin, [
                            'title' => $izin->notificationTitle(),
                            'body' => 'Pengajuan cuti telah disetujui oleh: ' . $izin->user_approve,
                            'priority' => 2
                        ]));
                    } else {
                        $hrd = User::role('hrd')->first();
                        $nextApprove = [
                            'next_approve_id' => $hrd->id,
                            'next_approve' => $hrd->nama
                        ];
                        // notif ke hrd
                        Notification::send(User::role('hrd')->get(), new IzinNotification($izin, [
                            'title' => $izin->notificationTitle(),
                            'body' => 'Terdapat pengajuan nomor: ' . $izin->nomor . ', an ' . $izin->user_input,
                        ]));
                    }
                }
            } else {
                Notification::send($izin->user, new IzinNotification($izin, [
                    'title' => $izin->notificationTitle(),
                    'body' => 'Pengajuan cuti ditolak oleh: ' . $izin->user_approve,
                    'priority' => 2
                ]));
            }


            $izin->history()->create([
                ...$nextApprove,
                'status_approve' => $izin->status_approve,
                'user_approve' => $izin->user_approve,
                'user_id' => $izin->user_approve_id,
                'keterangan' => $request->keterangan,
                'tanggal' => now(),
            ]);

            user()->markAsRead($izin);
            $izin->save();

            DB::commit();
            return responseSuccess();
        } catch (\Throwable $th) {
            DB::rollBack();
            return responseError($th);
        }
    }
}
