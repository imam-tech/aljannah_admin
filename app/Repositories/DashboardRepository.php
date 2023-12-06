<?php

namespace App\Repositories;

use App\Models\PpdbRegistration;

class DashboardRepository {
    public function ppdb() {
        $all = PpdbRegistration::with([])->count();
        $paidPendaftaran = PpdbRegistration::with([])
            ->whereNotIn('status_pembayaran', ['-', 'menunggu pembayaran pendaftaran', 'menunggu verifikasi bukti bayar'])->count();
        $lolosInterview = PpdbRegistration::with([])
            ->where('status_pendaftaran', 'lolos wawancara')->count();
        $paidUangPangkal = PpdbRegistration::with([])
            ->where('status_pendaftaran', 'lolos wawancara')->where('status_pembayaran', 'bukti terverifikasi')->count();

        return [
            'all' => $all,
            'paid_pendaftaran' => $paidPendaftaran,
            'lolos_wawancara' => $lolosInterview,
            'paid_uang_pangkal' => $paidUangPangkal
        ];
    }

    public function incomePpdb($filters) {
        $ppdbRegistrationAlls = PpdbRegistration::with(['proven_pendaftaran', 'proven_bpms'])
            ->whereNotIn('status_pembayaran', ['-', 'menunggu pembayaran pendaftaran']);
        $ppdbRegistrations = PpdbRegistration::with(['proven_pendaftaran', 'proven_bpms'])
            ->whereNotIn('status_pembayaran', ['-', 'menunggu pembayaran pendaftaran']);

        if (!empty($filters['angkatan'])) {
            $ppdbRegistrations = $ppdbRegistrations->where('angkatan', $filters['angkatan']);
            $ppdbRegistrationAlls = $ppdbRegistrationAlls->where('angkatan', $filters['angkatan']);
        }

        $ppdbRegistrations = $ppdbRegistrations->paginate(5);
        $ppdbRegistrationAlls = $ppdbRegistrationAlls->get();

        $totalPendaftaran = 0;
        $totalUangPangal = 0;
        foreach ($ppdbRegistrationAlls as $ppdbRegistration) {
            $totalPendaftaran = $totalPendaftaran + $ppdbRegistration->proven_pendaftaran->jumlah_bayar;
            if ($ppdbRegistration->proven_bpms) {

                $totalUangPangal = $totalUangPangal + $ppdbRegistration->proven_bpms->jumlah_bayar;
            }
        }

        return [
            'total_pendaftaran' => $totalPendaftaran,
            'total_uang_pangkal' => $totalUangPangal,
            'data' => $ppdbRegistrations
        ];
    }
}