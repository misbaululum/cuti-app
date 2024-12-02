<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FORM PERMOHONAN CUTI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6">
    <div class="relative mx-auto">
        <h1 class="mb-4 border-b-2 border-black pb-2 text-center text-lg font-bold">
            <span class="border-b-2 border-black">FORM PERMOHONAN CUTI</span> <br> <span class="text-sm font-normal">LEAVE APPLICATION</span>
        </h1>
        <div class="absolute right-4 top-4 text-center text-xs text-gray-900">
            CBA/PERS/F-028 <br> Rev: {{ $data->nomor }}
        </div>

        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <div class="flex gap-3">
                    <label class="flex font-semibold">
                        <span class="w-[6rem] underline decoration-black decoration-2">Nama</span>
                        <span class="ml-1">:</span>
                    </label>
                    <label class="font-semibold">{{ $data->user_input }}</label>
                </div>
                <span class="text-sm">Name</span>
            </div>
            <div>
                <div class="flex gap-3">
                    <label class="flex font-semibold">
                        <span class="w-[6rem] underline decoration-black decoration-2">Tanggal</span>
                        <span class="ml-1">:</span>
                    </label>
                    <label class="font-semibold">{{ $data->updated_at->format('d-m-Y') }}</label>
                </div>
                <span class="text-sm">Date</span>
            </div>
            <div>
                <div class="flex gap-3">
                    <label class="flex font-semibold">
                        <span class="w-[6rem] underline decoration-black decoration-2">Jabatan</span>
                        <span class="ml-1">:</span>
                    </label>
                    <label class="font-semibold">IT Support Officer</label>
                </div>
                <span class="text-sm">Position</span>
            </div>
            <div>
                <div class="flex gap-3">
                    <label class="flex font-semibold">
                        <span class="w-[6rem] underline decoration-black decoration-2">Bagian</span>
                        <span class="ml-1">:</span>
                    </label>
                    <label class="font-semibold">{{ $data->karyawan?->divisi?->nama }}</label>
                </div>
                <span class="text-sm">Departement</span>
            </div>
        </div>

        <div>
            <div class="flex gap-3 border-t-2 border-black pt-4">
                <label class="flex font-semibold">
                    <span class="w-[6rem] underline decoration-black decoration-2">Jenis Cuti</span>
                    <span class="ml-1">:</span>
                </label>
                <label class="font-semibold">Cuti Tahunan</label>
            </div>
            <span class="text-sm">Leave Type</span>
        </div>
        <div>
            <div class="flex gap-3 pt-2">
                <label class="flex font-semibold">
                    <span class="w-[6rem] underline decoration-black decoration-2">Alasan</span>
                    <span class="ml-1">:</span>
                </label>
                <label class="font-semibold">{{ $data->keterangan }}</label>
            </div>
            <span class="text-sm">Reason</span>
        </div>

        <table class="mt-4 w-full border border-gray-300 text-sm">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 p-2"><span class="border-b-2 border-black">Mulai </span><br> From</th>
                    <th class="border border-gray-300 p-2"><span class="border-b-2 border-black">s/d </span><br> up to</th>
                    <th class="border border-gray-300 p-2"><span class="border-b-2 border-black">Hari </span><br> Days</th>
                    <th class="border border-gray-300 p-2"><span class="border-b-2 border-black">Keterangan Cuti </span><br> Leave Information</th>
                    <th class="border border-gray-300 p-2"><span class="border-b-2 border-black">Hari </span><br> Days</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border border-gray-300 p-2 text-center">{{ $data->tanggal_awal->format('d-m-Y') }}</td>
                    <td class="border border-gray-300 p-2 text-center">{{ $data->tanggal_akhir->format('d-m-Y') }}</td>
                    <td class="border border-gray-300 p-2 text-center">{{ $data->total_cuti }}</td>
                    <td class="border border-gray-300 p-2"><span class="border-b-2 border-black">Hak Cuti Tahunan </span><br> Annual Leave</td>
                    <td class="border border-gray-300 p-2 text-center">{{ $data->sisa_cuti_awal }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"><span class="border-b-2 border-black">Cuti yang telah diambil </span><br> Leave already taken</td>
                    <td class="border border-gray-300 p-2 text-center">{{ $data->total_cuti }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"><span class="border-b-2 border-black">Cuti yang akan diambil </span><br> Leave to be taken</td>
                    <td class="border border-gray-300 p-2 text-center">{{ $data->total_cuti }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"></td>
                    <td class="border border-gray-300 p-2"><span class="border-b-2 border-black">Sisa Cuti </span><br> Before of leave</td>
                    <td class="border border-gray-300 p-2 text-center">{{ $data->sisa_cuti }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-8 grid grid-cols-3 gap-4 text-center">
            <div>
                <p class="font-semibold"><span class="border-b-2 border-black">Tanda tangan pemohon</span></p>
                <p class="text-sm">Signature</p>
                <br>
                <p class="font-semibold"><span class="">{{ $data->user_input }}</span></p>
                <hr class="mx-auto w-3/4 border-t border-gray-400">
                <p class="text-sm">Karyawan/Employee</p>
            </div>
            <div>
                <p class="font-semibold"><span class="border-b-2 border-black">Disetujui</span></p>
                <p class="text-sm">Approved by</p>
                <br>
                <p class="font-semibold">
                    {{ $data->user_approve }}
                </p>
                <hr class="mx-auto w-3/4 border-t border-gray-400">
                <p class="text-sm">Departemen Head</p>
            </div>

            <div>
                <p class="font-semibold"><span class="border-b-2 border-black">Mengetahui</span></p>
                <p class="text-sm">Noticed by</p>
                <br>
                <p class="font-semibold">
                    {{ $approver2->user_approve ?? 'Tidak Diketahui' }}
                </p>
                <hr class="mx-auto w-3/4 border-t border-gray-400">
                <p class="text-sm">Personalia & Admin. Dept</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
