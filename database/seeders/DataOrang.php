<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataOrang extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $people = [
            // Students (60 records)
            ['NIS2023001', 'Ahmad Fauzi', 'L', 'Siswa', '10 IPA 1', 'ahmad.fauzi@example.com', '081234567001', 'Anak rajin', $now, $now],
            ['NIS2023002', 'Budi Santoso', 'L', 'Siswa', '10 IPA 2', 'budi.santoso@example.com', '081234567002', null, $now, $now],
            ['NIS2023003', 'Citra Dewi', 'P', 'Siswi', '10 IPS 1', 'citra.dewi@example.com', '081234567003', 'Juara kelas', $now, $now],
            ['NIS2023004', 'Gita Permata', 'P', 'Siswi', '11 IPA 1', 'gita.permata@example.com', '081234567007', null, $now, $now],
            ['NIS2023005', 'Hendro Prasetyo', 'L', 'Siswa', '11 IPA 2', 'hendro.prasetyo@example.com', '081234567008', 'Ekstrakurikuler basket', $now, $now],
            ['NIS2023006', 'Joko Widodo', 'L', 'Siswa', '11 IPS 1', 'joko.widodo@example.com', '081234567010', null, $now, $now],
            ['NIS2023007', 'Kartika Sari', 'P', 'Siswi', '12 IPA 1', 'kartika.sari@example.com', '081234567011', 'Osis', $now, $now],
            ['NIS2023008', 'Maya Indah', 'P', 'Siswi', '12 IPA 2', 'maya.indah@example.com', '081234567013', null, $now, $now],
            ['NIS2023009', 'Oki Setiawan', 'L', 'Siswa', '12 IPS 1', 'oki.setiawan@example.com', '081234567015', 'Prestasi olahraga', $now, $now],
            ['NIS2023010', 'Putri Ayu', 'P', 'Siswi', '10 IPA 1', 'putri.ayu@example.com', '081234567016', null, $now, $now],
            ['NIS2023011', 'Surya Dharma', 'L', 'Siswa', '10 IPA 2', 'surya.dharma@example.com', '081234567018', null, $now, $now],
            ['NIS2023012', 'Umar Said', 'L', 'Siswa', '10 IPS 1', 'umar.said@example.com', '081234567020', 'Anak baru', $now, $now],
            ['NIS2023013', 'Vina Melati', 'P', 'Siswi', '11 IPA 1', 'vina.melati@example.com', '081234567021', null, $now, $now],
            ['NIS2023014', 'Wahyu Nugroho', 'L', 'Siswa', '11 IPA 2', 'wahyu.nugroho@example.com', '081234567022', 'Juara lomba sains', $now, $now],
            ['NIS2023015', 'Yuni Astuti', 'P', 'Siswi', '11 IPS 1', 'yuni.astuti@example.com', '081234567024', null, $now, $now],
            ['NIS2023016', 'Agus Supriyanto', 'L', 'Siswa', '12 IPA 1', 'agus.supriyanto@example.com', '081234567026', null, $now, $now],
            ['NIS2023017', 'Bella Nurul', 'P', 'Siswi', '12 IPA 2', 'bella.nurul@example.com', '081234567027', 'Paskibra', $now, $now],
            ['NIS2023018', 'Candra Wijaya', 'L', 'Siswa', '12 IPS 1', 'candra.wijaya@example.com', '081234567028', null, $now, $now],
            ['NIS2023019', 'Fitriani', 'P', 'Siswi', '10 IPA 1', 'fitriani@example.com', '081234567031', null, $now, $now],
            ['NIS2023020', 'Guntur Wibowo', 'L', 'Siswa', '10 IPA 2', 'guntur.wibowo@example.com', '081234567032', 'Ekstrakurikuler musik', $now, $now],
            ['NIS2023021', 'Hesti Rahayu', 'P', 'Siswi', '10 IPS 1', 'hesti.rahayu@example.com', '081234567033', null, $now, $now],
            ['NIS2023022', 'Joni Prakoso', 'L', 'Siswa', '11 IPA 1', 'joni.prakoso@example.com', '081234567035', null, $now, $now],
            ['NIS2023023', 'Lukman Hakim', 'L', 'Siswa', '11 IPA 2', 'lukman.hakim@example.com', '081234567037', 'Juara debat', $now, $now],
            ['NIS2023024', 'Mira Susanti', 'P', 'Siswi', '11 IPS 1', 'mira.susanti@example.com', '081234567038', null, $now, $now],
            ['NIS2023025', 'Oki Fernando', 'L', 'Siswa', '12 IPA 1', 'oki.fernando@example.com', '081234567040', null, $now, $now],
            ['NIS2023026', 'Putra Ramadhan', 'L', 'Siswa', '12 IPA 2', 'putra.ramadhan@example.com', '081234567041', 'Pramuka', $now, $now],
            ['NIS2023027', 'Rina Amelia', 'P', 'Siswi', '12 IPS 1', 'rina.amelia@example.com', '081234567043', null, $now, $now],
            ['NIS2023028', 'Teguh Santoso', 'L', 'Siswa', '10 IPA 1', 'teguh.santoso@example.com', '081234567045', null, $now, $now],
            ['NIS2023029', 'Umi Kulsum', 'P', 'Siswi', '10 IPA 2', 'umi.kulsum@example.com', '081234567046', 'Juara pidato', $now, $now],
            ['NIS2023030', 'Vino Bastian', 'L', 'Siswa', '10 IPS 1', 'vino.bastian@example.com', '081234567047', null, $now, $now],
            ['NIS2023031', 'Zahra Aulia', 'P', 'Siswi', '11 IPA 1', 'zahra.aulia@example.com', '081234567050', null, $now, $now],
            ['NIS2023032', 'Ade Putra', 'L', 'Siswa', '11 IPA 2', 'ade.putra@example.com', '081234567051', 'Basket', $now, $now],
            ['NIS2023033', 'Bunga Citra', 'P', 'Siswi', '11 IPS 1', 'bunga.citra@example.com', '081234567052', null, $now, $now],
            ['NIS2023034', 'Eko Prasetyo', 'L', 'Siswa', '12 IPA 1', 'eko.prasetyo@example.com', '081234567055', null, $now, $now],
            ['NIS2023035', 'Fani Oktavia', 'P', 'Siswi', '12 IPA 2', 'fani.oktavia@example.com', '081234567056', 'Paskibraka', $now, $now],
            ['NIS2023036', 'Hendra Kurnia', 'L', 'Siswa', '12 IPS 1', 'hendra.kurnia@example.com', '081234567058', null, $now, $now],
            ['NIS2023037', 'Jihan Aulia', 'P', 'Siswi', '10 IPA 1', 'jihan.aulia@example.com', '081234567060', null, $now, $now],
            ['NIS2023038', 'Kevin Anggara', 'L', 'Siswa', '10 IPA 2', 'kevin.anggara@example.com', '081234567061', 'Futsal', $now, $now],
            ['NIS2023039', 'Lia Amelia', 'P', 'Siswi', '10 IPS 1', 'lia.amelia@example.com', '081234567062', null, $now, $now],
            ['NIS2023040', 'Oki Pratama', 'L', 'Siswa', '11 IPA 1', 'oki.pratama@example.com', '081234567065', null, $now, $now],
            ['NIS2023041', 'Putri Maharani', 'P', 'Siswi', '11 IPA 2', 'putri.maharani@example.com', '081234567066', 'Juara lomba menulis', $now, $now],
            ['NIS2023042', 'Rafi Ahmad', 'L', 'Siswa', '11 IPS 1', 'rafi.ahmad@example.com', '081234567067', null, $now, $now],
            ['NIS2023043', 'Toni Wijaya', 'L', 'Siswa', '12 IPA 1', 'toni.wijaya@example.com', '081234567069', null, $now, $now],
            ['NIS2023044', 'Vira Amanda', 'P', 'Siswi', '12 IPA 2', 'vira.amanda@example.com', '081234567071', 'Pramuka', $now, $now],
            ['NIS2023045', 'Wahid Hasyim', 'L', 'Siswa', '12 IPS 1', 'wahid.hasyim@example.com', '081234567072', null, $now, $now],
            ['NIS2023046', 'Zaki Alamsyah', 'L', 'Siswa', '10 IPA 1', 'zaki.alamsyah@example.com', '081234567074', null, $now, $now],
            ['NIS2023047', 'Anisa Rahma', 'P', 'Siswi', '10 IPA 2', 'anisa.rahma@example.com', '081234567075', 'Juara cerdas cermat', $now, $now],
            ['NIS2023048', 'Bagus Setiawan', 'L', 'Siswa', '10 IPS 1', 'bagus.setiawan@example.com', '081234567076', null, $now, $now],
            ['NIS2023049', 'Eva Susanti', 'P', 'Siswi', '11 IPA 1', 'eva.susanti@example.com', '081234567079', null, $now, $now],
            ['NIS2023050', 'Fajar Nugraha', 'L', 'Siswa', '11 IPA 2', 'fajar.nugraha@example.com', '081234567080', 'Basket', $now, $now],
            ['NIS2023051', 'Gina Melati', 'P', 'Siswi', '11 IPS 1', 'gina.melati@example.com', '081234567081', null, $now, $now],
            ['NIS2023052', 'Indra Kusuma', 'L', 'Siswa', '12 IPA 1', 'indra.kusuma@example.com', '081234567083', null, $now, $now],
            ['NIS2023053', 'Kartini', 'P', 'Siswi', '12 IPA 2', 'kartini@example.com', '081234567085', 'Juara pidato', $now, $now],
            ['NIS2023054', 'Luki Hermansyah', 'L', 'Siswa', '12 IPS 1', 'luki.hermansyah@example.com', '081234567086', null, $now, $now],
            ['NIS2023055', 'Nando Pratama', 'L', 'Siswa', '10 IPA 1', 'nando.pratama@example.com', '081234567088', null, $now, $now],
            ['NIS2023056', 'Oktavia', 'P', 'Siswi', '10 IPA 2', 'oktavia@example.com', '081234567089', 'Paduan suara', $now, $now],
            ['NIS2023057', 'Pandu Wijaya', 'L', 'Siswa', '10 IPS 1', 'pandu.wijaya@example.com', '081234567090', null, $now, $now],
            ['NIS2023058', 'Siska Wulandari', 'P', 'Siswi', '11 IPA 1', 'siska.wulandari@example.com', '081234567093', null, $now, $now],
            ['NIS2023059', 'Tegar Putra', 'L', 'Siswa', '11 IPA 2', 'tegar.putra@example.com', '081234567094', 'Futsal', $now, $now],
            ['NIS2023060', 'Ulya Rahma', 'P', 'Siswi', '11 IPS 1', 'ulya.rahma@example.com', '081234567095', null, $now, $now],
            ['NIS2023061', 'Wahyu Setiawan', 'L', 'Siswa', '12 IPA 1', 'wahyu.setiawan@example.com', '081234567097', null, $now, $now],
            ['NIS2023062', 'Yoga Permana', 'L', 'Siswa', '12 IPA 2', 'yoga.permana@example.com', '081234567099', 'Pramuka', $now, $now],
            ['NIS2023063', 'Zahra Fitriani', 'P', 'Siswi', '12 IPS 1', 'zahra.fitriani@example.com', '081234567100', null, $now, $now],

            // Teachers (20 records)
            ['NIP1980001', 'Drs. Haryanto', 'L', 'Guru', null, 'haryanto@sekolah.sch.id', '081234567004', 'Guru Matematika', $now, $now],
            ['NIP1995001', 'Irma Susanti, S.Pd', 'P', 'Guru', null, 'irma.susanti@sekolah.sch.id', '081234567009', 'Guru Bahasa Inggris', $now, $now],
            ['NIP1985001', 'Nur Cahyono, M.Pd', 'L', 'Guru', null, 'nur.cahyono@sekolah.sch.id', '081234567014', 'Guru Fisika', $now, $now],
            ['NIP1990001', 'Tri Wahyuni, S.Pd', 'P', 'Guru', null, 'tri.wahyuni@sekolah.sch.id', '081234567019', 'Guru Kimia', $now, $now],
            ['NIP1988001', 'Zainal Abidin, S.Pd', 'L', 'Guru', null, 'zainal.abidin@sekolah.sch.id', '081234567025', 'Guru Biologi', $now, $now],
            ['NIP1975001', 'Eko Prasetyo, M.Pd', 'L', 'Guru', null, 'eko.prasetyo@sekolah.sch.id', '081234567030', 'Guru Sejarah', $now, $now],
            ['NIP1992001', 'Indra Kurniawan, S.Pd', 'L', 'Guru', null, 'indra.kurniawan@sekolah.sch.id', '081234567034', 'Guru Ekonomi', $now, $now],
            ['NIP1983001', 'Nurhayati, S.Pd', 'P', 'Guru', null, 'nurhayati@sekolah.sch.id', '081234567039', 'Guru Sosiologi', $now, $now],
            ['NIP1998001', 'Suryadi, M.Pd', 'L', 'Guru', null, 'suryadi@sekolah.sch.id', '081234567044', 'Guru Geografi', $now, $now],
            ['NIP1987001', 'Yusuf Mansur, S.Pd', 'L', 'Guru', null, 'yusuf.mansur@sekolah.sch.id', '081234567049', 'Guru Agama', $now, $now],
            ['NIP1993001', 'Cahyo Nugroho, M.Pd', 'L', 'Guru', null, 'cahyo.nugroho@sekolah.sch.id', '081234567053', 'Guru PKn', $now, $now],
            ['NIP1986001', 'Siti Rahma, M.Pd', 'P', 'Guru', null, 'siti.rahma@sekolah.sch.id', '081234567068', 'Guru Bahasa Indonesia', $now, $now],
            ['NIP1991001', 'Yoga Pratama, S.Pd', 'L', 'Guru', null, 'yoga.pratama@sekolah.sch.id', '081234567073', 'Guru TIK', $now, $now],
            ['NIP1989001', 'Dedi Supriyanto, M.Pd', 'L', 'Guru', null, 'dedi.supriyanto@sekolah.sch.id', '081234567078', 'Guru Prakarya', $now, $now],
            ['NIP1994001', 'Hendra Setiawan, S.Pd', 'L', 'Guru', null, 'hendra.setiawan@sekolah.sch.id', '081234567082', 'Guru Bahasa Jawa', $now, $now],
            ['NIP1981001', 'Maya Indriani, M.Pd', 'P', 'Guru', null, 'maya.indriani@sekolah.sch.id', '081234567087', 'Guru BK', $now, $now],
            ['NIP1996001', 'Rudi Hartono, S.Pd', 'L', 'Guru', null, 'rudi.hartono@sekolah.sch.id', '081234567092', 'Guru Matematika', $now, $now],
            ['NIP1984001', 'Vivi Anggraeni, M.Pd', 'P', 'Guru', null, 'vivi.anggraeni@sekolah.sch.id', '081234567096', 'Guru Bahasa Sunda', $now, $now],
            ['NIP1997001', 'Nia Kurniasih, S.Pd', 'P', 'Guru', null, 'nia.kurniasih@sekolah.sch.id', '081234567064', 'Guru Seni', $now, $now],
            ['NIP1982001', 'Irfan Maulana, S.Pd', 'L', 'Guru', null, 'irfan.maulana@sekolah.sch.id', '081234567059', 'Guru Olahraga', $now, $now],

            // Staff (15 records)
            ['STF2020001', 'Eka Wulandari', 'P', 'Staff', null, 'eka.wulandari@sekolah.sch.id', '081234567005', 'Staff TU', $now, $now],
            ['STF2021001', 'Luki Hermawan', 'L', 'Staff', null, 'luki.hermawan@sekolah.sch.id', '081234567012', 'Staff perpustakaan', $now, $now],
            ['STF2022001', 'Xavier Tan', 'L', 'Staff', null, 'xavier.tan@sekolah.sch.id', '081234567023', 'Staff IT', $now, $now],
            ['STF2023001', 'Dewi Sartika', 'P', 'Staff', null, 'dewi.sartika@sekolah.sch.id', '081234567029', 'Staff kebersihan', $now, $now],
            ['STF2021002', 'Kartika Dewi', 'P', 'Staff', null, 'kartika.dewi@sekolah.sch.id', '081234567036', 'Staff kesiswaan', $now, $now],
            ['STF2019001', 'Queen Safira', 'P', 'Staff', null, 'queen.safira@sekolah.sch.id', '081234567042', 'Staff perpustakaan', $now, $now],
            ['STF2020002', 'Wulan Sari', 'P', 'Staff', null, 'wulan.sari@sekolah.sch.id', '081234567048', 'Staff TU', $now, $now],
            ['STF2022002', 'Gunawan Wibowo', 'L', 'Staff', null, 'gunawan.wibowo@sekolah.sch.id', '081234567057', 'Staff keamanan', $now, $now],
            ['STF2023002', 'Maman Suherman', 'L', 'Staff', null, 'maman.suherman@sekolah.sch.id', '081234567063', 'Staff kebersihan', $now, $now],
            ['STF2021003', 'Umi Kalsum', 'P', 'Staff', null, 'umi.kalsum@sekolah.sch.id', '081234567070', 'Staff laboratorium', $now, $now],
            ['STF2018001', 'Rina Marlina', 'P', 'Staff', null, 'rina.marlina@sekolah.sch.id', '081234567017', 'Staff laboratorium', $now, $now],
            ['STF2018002', 'Citra Lestari', 'P', 'Staff', null, 'citra.lestari@sekolah.sch.id', '081234567077', 'Staff perpustakaan', $now, $now],
            ['STF2023003', 'Joko Susilo', 'L', 'Staff', null, 'joko.susilo@sekolah.sch.id', '081234567084', 'Staff keamanan', $now, $now],
            ['STF2022003', 'Queen Maryam', 'P', 'Staff', null, 'queen.maryam@sekolah.sch.id', '081234567091', 'Staff TU', $now, $now],
            ['STF2019002', 'Luki Hermawan', 'L', 'Staff', null, 'luki.hermawan2@sekolah.sch.id', '081234567101', 'Staff kebersihan', $now, $now],

            // Admins (5 records)
            ['ADM2019001', 'Fajar Setiawan', 'L', 'Admin', null, 'fajar.setiawan@sekolah.sch.id', '081234567006', 'Admin sistem', $now, $now],
            ['ADM2020001', 'Dian Permata', 'P', 'Admin', null, 'dian.permata@sekolah.sch.id', '081234567054', 'Admin kedua', $now, $now],
            ['ADM2021001', 'Xena Putri', 'P', 'Admin', null, 'xena.putri@sekolah.sch.id', '081234567098', 'Admin ketiga', $now, $now],
            ['ADM2018001', 'Bambang Sutrisno', 'L', 'Admin', null, 'bambang.sutrisno@sekolah.sch.id', '081234567102', 'Admin senior', $now, $now],
            ['ADM2022001', 'Rina Wijaya', 'P', 'Admin', null, 'rina.wijaya@sekolah.sch.id', '081234567103', 'Admin junior', $now, $now],
        ];

        // Insert all data
        foreach ($people as $person) {
            DB::table('people')->insert([
                'kode_orang' => $person[0],
                'nama' => $person[1],
                'jenis_kelamin' => $person[2],
                'role' => $person[3],
                'kelas' => $person[4],
                'email' => $person[5],
                'telepon' => $person[6],
                'catatan' => $person[7],
                'created_at' => $person[8],
                'updated_at' => $person[9],
            ]);
        }
    }
}
