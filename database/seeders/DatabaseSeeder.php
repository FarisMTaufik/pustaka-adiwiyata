<?php

// database/seeders/DatabaseSeeder.php (Modifikasi)
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\FarisCategory;
use App\Models\FarisMember;
use App\Models\FarisBook; // Tambahkan ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Pustaka',
                'password' => Hash::make('password'), // Ganti dengan password yang kuat
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Buat data member untuk admin (opsional, jika admin juga dianggap member)
        FarisMember::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'member_id_number' => 'ADM001',
                'address' => 'Jl. Admin No. 1',
                'phone_number' => '081234567890',
                'role' => 'admin',
                'total_points' => 0,
            ]
        );


        // Buat user anggota
        $memberUser = User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Anggota Pustaka',
                'password' => Hash::make('password'), // Ganti dengan password yang kuat
                'role' => 'member',
                'email_verified_at' => now(),
            ]
        );

        // Buat data member untuk anggota
        FarisMember::firstOrCreate(
            ['user_id' => $memberUser->id],
            [
                'member_id_number' => 'MEMBER001',
                'address' => 'Jl. Anggota No. 1',
                'phone_number' => '0876543210',
                'role' => 'member',
                'total_points' => 50, // Contoh poin awal
            ]
        );

        // Buat kategori
        $fiksiCategory = FarisCategory::firstOrCreate(['name' => 'Fiksi']);
        $nonFiksiCategory = FarisCategory::firstOrCreate(['name' => 'Non-Fiksi']);
        $adiwiyataCategory = FarisCategory::firstOrCreate(['name' => 'Modul Adiwiyata']);
        $jurnalCategory = FarisCategory::firstOrCreate(['name' => 'Jurnal Lingkungan']);

        // Buat beberapa buku contoh
        FarisBook::firstOrCreate(
            ['isbn' => '978-602-03-3295-5'],
            [
                'title' => 'Bumi',
                'author' => 'Tere Liye',
                'publication_year' => 2014,
                'quantity' => 5,
                'available_quantity' => 5,
                'category_id' => $fiksiCategory->id,
                'description' => 'Novel fantasi tentang petualangan Raib dan teman-temannya di dunia paralel.',
            ]
        );

        FarisBook::firstOrCreate(
            ['isbn' => '978-979-433-875-1'],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'publication_year' => 2018,
                'quantity' => 3,
                'available_quantity' => 3,
                'category_id' => $nonFiksiCategory->id,
                'description' => 'Panduan praktis untuk hidup tenang ala Stoikisme.',
            ]
        );

        FarisBook::firstOrCreate(
            ['isbn' => '978-623-00-1234-5'],
            [
                'title' => 'Panduan Pengelolaan Sampah Organik',
                'author' => 'Tim Adiwiyata',
                'publication_year' => 2023,
                'quantity' => 10,
                'available_quantity' => 10,
                'category_id' => $adiwiyataCategory->id,
                'theme' => 'Daur Ulang',
                'description' => 'Modul praktis untuk siswa dalam mengelola sampah organik di sekolah.',
            ]
        );

        FarisBook::firstOrCreate(
            ['isbn' => '978-123-456-789-0'],
            [
                'title' => 'Ekologi dan Konservasi Lingkungan',
                'author' => 'Dr. Budi Santoso',
                'publication_year' => 2022,
                'quantity' => 7,
                'available_quantity' => 7,
                'category_id' => $jurnalCategory->id,
                'theme' => 'Konservasi',
                'description' => 'Jurnal ilmiah tentang prinsip-prinsip ekologi dan upaya konservasi.',
            ]
        );

        // Tambahan data dummy untuk fitur utama
        $member = FarisMember::where('user_id', $memberUser->id)->first();
        $bookBumi = FarisBook::where('title', 'Bumi')->first();
        $bookFilosofi = FarisBook::where('title', 'Filosofi Teras')->first();

        // Peminjaman Buku
        \App\Models\FarisBorrowing::firstOrCreate([
            'book_id' => $bookBumi->id,
            'member_id' => $member->id,
            'borrow_date' => now()->subDays(10),
            'due_date' => now()->subDays(3),
        ], [
            'return_date' => null,
            'status' => 'overdue',
            'fine_amount' => 15000,
        ]);
        \App\Models\FarisBorrowing::firstOrCreate([
            'book_id' => $bookFilosofi->id,
            'member_id' => $member->id,
            'borrow_date' => now()->subDays(5),
            'due_date' => now()->addDays(2),
        ], [
            'return_date' => null,
            'status' => 'borrowed',
            'fine_amount' => 0,
        ]);

        // Reservasi Buku
        \App\Models\FarisReservation::firstOrCreate([
            'book_id' => $bookFilosofi->id,
            'member_id' => $member->id,
            'reservation_date' => now()->subDays(1),
        ], [
            'expiration_date' => now()->addDays(2),
            'status' => 'pending',
        ]);
        \App\Models\FarisReservation::firstOrCreate([
            'book_id' => $bookBumi->id,
            'member_id' => $member->id,
            'reservation_date' => now()->subDays(7),
        ], [
            'expiration_date' => now()->subDays(2),
            'status' => 'fulfilled',
        ]);

        // Poin Literasi
        \App\Models\FarisLiteracyPoint::firstOrCreate([
            'member_id' => $member->id,
            'activity_type' => 'Peminjaman Buku',
            'points' => 10,
            'description' => 'Meminjam buku Bumi',
            'created_at' => now()->subDays(10),
        ]);
        \App\Models\FarisLiteracyPoint::firstOrCreate([
            'member_id' => $member->id,
            'activity_type' => 'Ulasan Buku',
            'points' => 5,
            'description' => 'Memberikan ulasan pada buku Filosofi Teras',
            'created_at' => now()->subDays(2),
        ]);

        // Ulasan Buku
        \App\Models\FarisReview::firstOrCreate([
            'book_id' => $bookBumi->id,
            'member_id' => $member->id,
        ], [
            'rating' => 5,
            'comment' => 'Buku yang sangat seru dan inspiratif!',
        ]);
        \App\Models\FarisReview::firstOrCreate([
            'book_id' => $bookFilosofi->id,
            'member_id' => $member->id,
        ], [
            'rating' => 4,
            'comment' => 'Banyak insight baru tentang hidup tenang.',
        ]);
    }
}
