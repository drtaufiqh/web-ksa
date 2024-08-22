<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        //
        $instansi = [
            ['id_user' => 3300, 'nama' => 'BPS Provinsi Jawa Tengah', 'alamat_lengkap' => 'Jl. Pahlawan No. 6 Semarang 50241', 'is_prov' => 1, 'kode_kabkota' => '3374', 'id_kab_kota' => '3374'],
            ['id_user' => 3301, 'nama' => 'BPS Kabupaten Cilacap', 'alamat_lengkap' => 'Jl. Dr. Soetomo no 16A Cilacap', 'is_prov' => 0, 'kode_kabkota' => '3301', 'id_kab_kota' => '3301'],
            ['id_user' => 3302, 'nama' => 'BPS Kabupaten Banyumas', 'alamat_lengkap' => 'Jl. Warga Bhakti No. 5, Purwokerto 53114', 'is_prov' => 0, 'kode_kabkota' => '3302', 'id_kab_kota' => '3302'],
            ['id_user' => 3303, 'nama' => 'BPS Kabupaten Purbalingga', 'alamat_lengkap' => 'Jl. Letjen S. Parman No. 48, Purbalingga 53317', 'is_prov' => 0, 'kode_kabkota' => '3303', 'id_kab_kota' => '3303'],
            ['id_user' => 3304, 'nama' => 'BPS Kabupaten Banjarnegara', 'alamat_lengkap' => 'Jl. Selamanik No. 33, Banjarnegara 53415', 'is_prov' => 0, 'kode_kabkota' => '3304', 'id_kab_kota' => '3304'],
            ['id_user' => 3305, 'nama' => 'BPS Kabupaten Kebumen', 'alamat_lengkap' => 'Jl. Arungbinang No. 17 A, Kebumen 54311', 'is_prov' => 0, 'kode_kabkota' => '3305', 'id_kab_kota' => '3305'],
            ['id_user' => 3306, 'nama' => 'BPS Kabupaten Purworejo', 'alamat_lengkap' => 'Jl Banyuurip , Purworejo', 'is_prov' => 0, 'kode_kabkota' => '3306', 'id_kab_kota' => '3306'],
            ['id_user' => 3307, 'nama' => 'BPS Kabupaten Wonosobo', 'alamat_lengkap' => 'Jl. Bambang Sugeng Km 2,2 Wonosobo', 'is_prov' => 0, 'kode_kabkota' => '3307', 'id_kab_kota' => '3307'],
            ['id_user' => 3308, 'nama' => 'BPS Kabupaten Magelang', 'alamat_lengkap' => 'Jl. Letnan Tukiyat No. 4, Kota Mungkid 56511', 'is_prov' => 0, 'kode_kabkota' => '3308', 'id_kab_kota' => '3308'],
            ['id_user' => 3309, 'nama' => 'BPS Kabupaten Boyolali', 'alamat_lengkap' => 'Jl Raya Boyolali - Solo Km2', 'is_prov' => 0, 'kode_kabkota' => '3309', 'id_kab_kota' => '3309'],
            ['id_user' => 3310, 'nama' => 'BPS Kabupaten Klaten', 'alamat_lengkap' => 'Jl. Merapi No. 6, Gayamprit, Klaten Selatan 57423', 'is_prov' => 0, 'kode_kabkota' => '3310', 'id_kab_kota' => '3310'],
            ['id_user' => 3311, 'nama' => 'BPS Kabupaten Sukoharjo', 'alamat_lengkap' => 'Jl. Slamet Riyadi No. 49, Sukoharjo 57513', 'is_prov' => 0, 'kode_kabkota' => '3311', 'id_kab_kota' => '3311'],
            ['id_user' => 3312, 'nama' => 'BPS Kabupaten Wonogiri', 'alamat_lengkap' => 'Jl. Ki Mangun Sarkoro , Kaloran, Giripurwo Wonogiri', 'is_prov' => 0, 'kode_kabkota' => '3312', 'id_kab_kota' => '3312'],
            ['id_user' => 3313, 'nama' => 'BPS Kabupaten Karanganyar', 'alamat_lengkap' => 'Jl. Majapahit No. 11 B Perkantoran Cangakan 57712', 'is_prov' => 0, 'kode_kabkota' => '3313', 'id_kab_kota' => '3313'],
            ['id_user' => 3314, 'nama' => 'BPS Kabupaten Sragen', 'alamat_lengkap' => 'Jl Letjen Suprapto No 48 Sragen 57211', 'is_prov' => 0, 'kode_kabkota' => '3314', 'id_kab_kota' => '3314'],
            ['id_user' => 3315, 'nama' => 'BPS Kabupaten Grobogan', 'alamat_lengkap' => 'Jl. Jend. Sudirman No. 6, Purwodadi 58111', 'is_prov' => 0, 'kode_kabkota' => '3315', 'id_kab_kota' => '3315'],
            ['id_user' => 3316, 'nama' => 'BPS Kabupaten Blora', 'alamat_lengkap' => 'Jl. Rajawali No. 12, Blora 58211', 'is_prov' => 0, 'kode_kabkota' => '3316', 'id_kab_kota' => '3316'],
            ['id_user' => 3317, 'nama' => 'BPS Kabupaten Rembang', 'alamat_lengkap' => 'Jl. Blora Km. 1, Rembang 59217', 'is_prov' => 0, 'kode_kabkota' => '3317', 'id_kab_kota' => '3317'],
            ['id_user' => 3318, 'nama' => 'BPS Kabupaten Pati', 'alamat_lengkap' => 'Jl Raya Pati - Kudus Km 3', 'is_prov' => 0, 'kode_kabkota' => '3318', 'id_kab_kota' => '3318'],
            ['id_user' => 3319, 'nama' => 'BPS Kabupaten Kudus', 'alamat_lengkap' => 'Jl. Mejobo Komplek Perkantoran, Kudus 59319', 'is_prov' => 0, 'kode_kabkota' => '3319', 'id_kab_kota' => '3319'],
            ['id_user' => 3320, 'nama' => 'BPS Kabupaten Jepara', 'alamat_lengkap' => 'Jl. Ratu Kalinyamat Komplek Perkantoran, Jepara', 'is_prov' => 0, 'kode_kabkota' => '3320', 'id_kab_kota' => '3320'],
            ['id_user' => 3321, 'nama' => 'BPS Kabupaten Demak', 'alamat_lengkap' => 'Jl. Sultan Hadi Wijaya No. 23, Demak 59515', 'is_prov' => 0, 'kode_kabkota' => '3321', 'id_kab_kota' => '3321'],
            ['id_user' => 3322, 'nama' => 'BPS Kabupaten Semarang', 'alamat_lengkap' => 'Jl. Garuda No. 7, Ungaran 50511', 'is_prov' => 0, 'kode_kabkota' => '3322', 'id_kab_kota' => '3322'],
            ['id_user' => 3323, 'nama' => 'BPS Kabupaten Temanggung', 'alamat_lengkap' => 'Jl Suwandi Suwardi', 'is_prov' => 0, 'kode_kabkota' => '3323', 'id_kab_kota' => '3323'],
            ['id_user' => 3324, 'nama' => 'BPS Kabupaten Kendal', 'alamat_lengkap' => 'Jl. Pramuka Komplek Perkantoran , Kendal 51351', 'is_prov' => 0, 'kode_kabkota' => '3324', 'id_kab_kota' => '3324'],
            ['id_user' => 3325, 'nama' => 'BPS Kabupaten Batang', 'alamat_lengkap' => 'Jl. Pemuda No. 90, Batang 51215', 'is_prov' => 0, 'kode_kabkota' => '3325', 'id_kab_kota' => '3325'],
            ['id_user' => 3326, 'nama' => 'BPS Kabupaten Pekalongan', 'alamat_lengkap' => 'Jl. Wirata No. 17, Wiradesa, Pekalongan', 'is_prov' => 0, 'kode_kabkota' => '3326', 'id_kab_kota' => '3326'],
            ['id_user' => 3327, 'nama' => 'BPS Kabupaten Pemalang', 'alamat_lengkap' => 'Jl. Tentara Pelajar No. 16, Pemalang 52312', 'is_prov' => 0, 'kode_kabkota' => '3327', 'id_kab_kota' => '3327'],
            ['id_user' => 3328, 'nama' => 'BPS Kabupaten Tegal', 'alamat_lengkap' => 'Jl. Ade Irma Suryani No. 1, Slawi 52418', 'is_prov' => 0, 'kode_kabkota' => '3328', 'id_kab_kota' => '3328'],
            ['id_user' => 3329, 'nama' => 'BPS Kabupaten Brebes', 'alamat_lengkap' => 'Jl. Letjend MT Haryono No. 74, Brebes 52212', 'is_prov' => 0, 'kode_kabkota' => '3329', 'id_kab_kota' => '3329'],
            ['id_user' => 3371, 'nama' => 'BPS Kota Magelang', 'alamat_lengkap' => 'Jl. Gatot Subroto No. 54 D, Magelang 56123', 'is_prov' => 0, 'kode_kabkota' => '3371', 'id_kab_kota' => '3371'],
            ['id_user' => 3372, 'nama' => 'BPS Kota Surakarta', 'alamat_lengkap' => 'Jl. Dr. P. Lumban Tobing No. 6 ,Surakarta 57133', 'is_prov' => 0, 'kode_kabkota' => '3372', 'id_kab_kota' => '3372'],
            ['id_user' => 3373, 'nama' => 'BPS Kota Salatiga', 'alamat_lengkap' => 'Jl. Menur Komplek Perkantoran,Salatiga 50742', 'is_prov' => 0, 'kode_kabkota' => '3373', 'id_kab_kota' => '3373'],
            ['id_user' => 3374, 'nama' => 'BPS Kota Semarang', 'alamat_lengkap' => 'Jl. Pemuda No. 148, Semarang 50132', 'is_prov' => 0, 'kode_kabkota' => '3374', 'id_kab_kota' => '3374'],
            ['id_user' => 3375, 'nama' => 'BPS Kota Pekalongan', 'alamat_lengkap' => 'Jl. Pembangunan No. 4, Pekalongan 51117', 'is_prov' => 0, 'kode_kabkota' => '3375', 'id_kab_kota' => '3375'],
            ['id_user' => 3376, 'nama' => 'BPS Kota Tegal', 'alamat_lengkap' => 'Jl. Nakulo No. 36 A,Tegal 52124', 'is_prov' => 0, 'kode_kabkota' => '3376', 'id_kab_kota' => '3376'],
        ];

        foreach ($instansi as $data) {
            if ($data['is_prov'] == 1) {
                $email = $data['id_user'] . '@bps.go.id';
                $role = 'prov';
            } else {
                $email = $data['id_user'] . '@bps.go.id';
                $role = 'kabkota';
            }

            $password = 'pw' . $data["id_user"];

            $user = new User([
                'name' => $data['nama'],
                'email' => $email,
                'password' => bcrypt($password),
                'role' => $role
            ]);
            $user->save();
        }
    }
}
