<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Class untuk menangani tanggal dan waktu

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama beserta statistik tugas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // =================================================================
        // LANGKAH 1: Simulasi Pengambilan Data dari Database
        // =================================================================
        // Di aplikasi nyata, data ini akan diambil dari model, contoh:
        // $tasks = Task::all();
        $tasks = [
            // Tugas yang sudah selesai
            ['title' => 'Kirim laporan mingguan', 'due_date' => '2025-06-11', 'completed' => true],
            ['title' => 'Update dokumentasi API', 'due_date' => '2025-06-12', 'completed' => true],

            // Tugas yang TERLAMBAT (Overdue) - jatuh tempo sebelum hari ini & belum selesai
            ['title' => 'Follow up client A', 'due_date' => '2025-06-10', 'completed' => false],
            ['title' => 'Review budget Q2', 'due_date' => '2025-06-12', 'completed' => false],

            // Tugas yang JATUH TEMPO HARI INI (Due Today) - 13 Juni 2025
            ['title' => 'Rapat tim proyek', 'due_date' => '2025-06-13', 'completed' => false],
            ['title' => 'Presentasi ke direksi', 'due_date' => '2025-06-13', 'completed' => false],
            ['title' => 'Bayar tagihan internet', 'due_date' => '2025-06-13', 'completed' => false],

            // Tugas yang AKAN DATANG (Upcoming)
            ['title' => 'Siapkan materi untuk kickoff', 'due_date' => '2025-06-15', 'completed' => false],
            ['title' => 'Pesan tiket perjalanan dinas', 'due_date' => '2025-06-20', 'completed' => false],
        ];

        // =================================================================
        // LANGKAH 2: Lakukan Kalkulasi Statistik
        // =================================================================
        $today = Carbon::today(); // Mengambil tanggal hari ini (2025-06-13)

        // Menghitung total semua tugas
        $totalTasks = count($tasks);

        // Menghitung tugas yang memiliki status 'completed' => true
        $completedCount = count(array_filter($tasks, function ($task) {
            return $task['completed'] === true;
        }));

        // Menghitung tugas yang belum selesai DAN tanggalnya adalah hari ini
        $dueTodayCount = count(array_filter($tasks, function ($task) use ($today) {
            return !$task['completed'] && Carbon::parse($task['due_date'])->isSameDay($today);
        }));

        // Menghitung tugas yang belum selesai DAN tanggalnya sudah lewat
        $overdueCount = count(array_filter($tasks, function ($task) use ($today) {
            return !$task['completed'] && Carbon::parse($task['due_date'])->isPast() && !$today->isSameDay($task['due_date']);
        }));

        // =================================================================
        // LANGKAH 3: Kirim Data Hasil Kalkulasi ke View
        // =================================================================
        // Fungsi compact() adalah cara singkat untuk membuat array, contoh:
        // ['totalTasks' => $totalTasks, 'completedCount' => $completedCount, ...]
        return view('dashboard', compact(
            'totalTasks',
            'completedCount',
            'dueTodayCount',
            'overdueCount'
        ));
    }
}
