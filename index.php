<?php
// ==========================================
// YAYASAN HARMONI ABADI SEJATI - FULL SYSTEM
// ==========================================

$db_file = __DIR__ . '/database.json';

// Inisialisasi Storage JSON jika belum ada
if (!file_exists($db_file)) {
    $initial_data = [
        "artikels" => [
            [
                "id" => 1,
                "judul" => "Pelantikan Pengurus dan Pengawas Yayasan Harmoni Abadi Sejati",
                "tanggal" => "05 Februari 2026",
                "konten" => "Acara pelantikan khidmat di Bima Restaurant Surabaya yang dihadiri oleh anggota Komisi D DPRD Kota Surabaya Dr. Imam Syafii, SH, MH dan Kadinsos Surabaya Mia Santi Dewi, SH, M.Si."
            ],
            [
                "id" => 2,
                "judul" => "Dinsos Surabaya Terima 275 Kain Kafan dari Yayasan",
                "tanggal" => "Agustus 2026",
                "konten" => "Wujud nyata kepedulian sosial kemasyarakatan dalam penyerahan bantuan kain kafan untuk jenazah warga tanpa keluarga."
            ]
        ],
        "pesan" => []
    ];
    file_put_contents($db_file, json_encode($initial_data, JSON_PRETTY_PRINT));
}

// Handle Aksi Form Kontak
$pesan_status = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim_pesan'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $isi = htmlspecialchars($_POST['pesan']);

    $data = json_decode(file_get_contents($db_file), true);
    $data['pesan'][] = [
        "id" => time(),
        "nama" => $nama,
        "email" => $email,
        "pesan" => $isi,
        "tanggal" => date('Y-m-d H:i:s')
    ];
    file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT));
    $pesan_status = "Terima kasih, pesan Anda berhasil dikirim kepada pengurus yayasan.";
}

// Handle Login / Admin Sederhana jika parameter ?page=admin diakses
$page = $_GET['page'] ?? 'home';
$data_db = json_decode(file_get_contents($db_file), true);
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YAYASAN HARMONI ABADI SEJATI | Surabaya</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .text-gold {
            color: #D4AF37;
        }

        .bg-gold {
            background-color: #D4AF37;
        }

        .border-gold {
            border-color: #D4AF37;
        }

        .gold-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #C5A059 100%);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- TOPBAR -->
    <div class="bg-slate-900 text-gray-300 text-xs py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fas fa-map-marker-alt text-gold mr-1"></i> Vila Taman Telaga 2 blok TJ 11 no 1 Citraland, Surabaya</span>
                <span><i class="fas fa-phone text-gold mr-1"></i> +62 813-5767-0968</span>
            </div>
            <div>
                <a href="?page=admin" class="text-gold hover:underline font-semibold"><i class="fas fa-lock mr-1"></i> Admin Dashboard</a>
            </div>
        </div>
    </div>

    <?php if ($page === 'admin'): ?>
        <!-- HALAMAN ADMIN DASHBOARD -->
        <div class="max-w-4xl mx-auto px-4 py-12">
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">
                <div class="flex justify-between items-center mb-6 border-b pb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">Panel Admin Yayasan</h2>
                        <p class="text-xs text-gray-500">Kelola Pesan Masuk & Data Website</p>
                    </div>
                    <a href="index.php" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gold hover:text-slate-900 transition">Kembali ke Website</a>
                </div>

                <h3 class="font-bold text-slate-800 text-lg mb-4"><i class="fas fa-envelope text-gold mr-2"></i> Daftar Pesan Masuk Pengunjung</h3>
                <?php if (!empty($data_db['pesan'])): ?>
                    <div class="space-y-4">
                        <?php foreach (array_reverse($data_db['pesan']) as $p): ?>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <strong class="text-slate-900"><?= htmlspecialchars($p['nama']) ?> (<?= htmlspecialchars($p['email']) ?>)</strong>
                                    <span><?= $p['tanggal'] ?></span>
                                </div>
                                <p class="text-gray-700 text-sm mt-1"><?= htmlspecialchars($p['pesan']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-sm italic">Belum ada pesan masuk dari pengunjung.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- HALAMAN UTAMA FRONT-END -->

        <!-- NAVBAR -->
        <header class="sticky top-0 z-50 bg-white/95 backdrop-blur shadow-sm border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-full bg-amber-500/10 border border-gold flex items-center justify-center font-bold text-gold">
                        <img src="/img/logos.png" alt="">
                    </div>
                    <div>
                        <span class="block font-bold text-slate-900 tracking-wide text-xs sm:text-sm">YAYASAN HARMONI ABADI SEJATI</span>
                        <span class="block text-xs text-gold font-medium tracking-wider">SURABAYA, JAWA TIMUR</span>
                    </div>
                </div>
                <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-700">
                    <a href="#home" class="hover:text-gold transition">Home</a>
                    <a href="#tentang" class="hover:text-gold transition">Tentang Kami</a>
                    <a href="#visimisi" class="hover:text-gold transition">Visi-Misi</a>
                    <a href="#kegiatan" class="hover:text-gold transition">Kegiatan & Media</a>
                    <a href="#artikel" class="hover:text-gold transition">Artikel</a>
                    <a href="#kontak" class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-gold hover:text-slate-900 transition shadow">Kontak</a>
                </nav>
            </div>
        </header>

        <!-- HERO SECTION -->
        <section id="home" class="relative h-[85vh] flex items-center justify-center overflow-hidden bg-slate-900">
            <div class="absolute inset-0 z-0">
                <!-- Gambar hero -->
                <img src="/img/img.jpg" alt="Hero" class="w-full h-full object-cover opacity-30">
                <!-- Gradient kuning dari bawah -->
                <div class="absolute inset-0 z-10 bg-gradient-to-t from-yellow-500/80 via-yellow-600/30 to-transparent"></div>
            </div>

            <div class="relative z-20 max-w-5xl mx-auto text-center px-4 space-y-6">
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-wider uppercase drop-shadow-lg">
                    YAYASAN HARMONI ABADI SEJATI
                </h1>
                <p class="text-lg sm:text-2xl text-gray-200 font-light max-w-2xl mx-auto leading-relaxed">
                    WADAH KEPEDULIAN, JEMBATAN PENGABDIAN, SEKALIGUS RUANG KOLABORASI UNTUK MENGHADIRKAN MANFAAT NYATA BAGI MASYARAKAT.
                </p>
                <div class="pt-4 flex flex-wrap justify-center gap-4">
                    <a href="#tentang" class="gold-gradient text-slate-900 px-8 py-3 rounded-xl font-bold shadow-lg hover:opacity-95 transition">
                        Kenali Kami Lebih Dekat
                    </a>
                    <a href="#kontak" class="bg-white/10 backdrop-blur border border-white/30 text-white px-8 py-3 rounded-xl font-bold hover:bg-white/20 transition">
                        Hubungi Pengurus
                    </a>
                </div>
            </div>
        </section>

        <!-- TENTANG KAMI & KETUA YAYASAN -->
        <section id="tentang" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-gold font-bold uppercase tracking-widest text-xs">PROFIL YAYASAN</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-2">Wujud Kepedulian Sosial di Surabaya</h2>
                    <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-6 text-gray-600 text-base leading-relaxed">
                        <p>
                            Pelantikan pengurus dan pengawas Yayasan Harmoni Abadi Sejati digelar di Bima Restaurant, Surabaya, dihadiri oleh anggota Komisi D DPRD Kota Surabaya Dr. Imam Syafii, SH, MH serta Kepala Dinas Sosial Kota Surabaya Mia Santi Dewi, SH, M.Si.
                        </p>
                        <p>
                            Yayasan ini dibentuk sebagai wadah kepedulian, jembatan pengabdian, sekaligus ruang kolaborasi untuk menghadirkan manfaat nyata di tengah masyarakat yang menghadapi keterbatasan dalam bidang pendidikan, sosial, dan kesejahteraan.
                        </p>
                        <blockquote class="border-l-4 border-gold pl-4 italic text-slate-900 font-medium">
                            “Kehidupan yang bermakna lahir dari niat baik, kerja nyata, hubungan yang sehat, serta kepedulian sosial yang diwujudkan dalam tindakan.”
                        </blockquote>
                    </div>

                    <!-- Card Profil Ketua -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-6 shadow-xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-gold text-slate-900 text-xs px-3 py-1 rounded-bl-xl font-bold">PEMBINA / KETUA</div>
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <div class="w-32 h-32 rounded-2xl bg-slate-200 overflow-hidden border-2 border-gold flex items-center justify-center font-bold text-slate-500">
                                <img src="/img/ketua.jpeg" alt="">
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-slate-900">Neck Inkiriwang</h3>
                                <p class="text-gold font-medium text-sm">Ketua Yayasan Harmoni Abadi Sejati</p>
                                <p class="text-gray-500 text-sm mt-2">
                                    Memimpin pengabdian sosial dengan komitmen moral, integritas, dan semangat membangun peradaban yang unggul.
                                </p>
                                <button onclick="openModal()" class="mt-4 inline-flex items-center gap-2 text-xs font-bold text-slate-900 bg-gold/20 hover:bg-gold px-4 py-2 rounded-lg transition">
                                    <i class="fas fa-quote-left"></i> Lihat Quotes Utama
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VISI & MISI -->
        <section id="visimisi" class="py-20 bg-slate-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-gold font-bold uppercase tracking-widest text-xs">LANDASAN & ARAH GERAK</span>
                    <h2 class="text-3xl font-bold mt-2">Visi & Misi Yayasan</h2>
                    <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-slate-800/80 border border-slate-700 rounded-2xl p-8 shadow-xl">
                        <h3 class="text-xl font-bold mb-4 text-gold"><i class="fas fa-bullseye mr-2"></i> Visi & Misi Utama</h3>
                        <div class="space-y-3 text-gray-300 text-sm">
                            <p><strong>VISI:</strong> Menjadikan katalisator peradaban yang unggul melalui penguatan aspek kemanusiaan, kesehatan, pendidikan, dan kelestarian lingkungan.</p>
                            <p><strong>MISI:</strong> Menyelenggarakan bantuan sosial, memfasilitasi layanan kesehatan & pendidikan, konservasi lingkungan, serta pemberdayaan potensi anggota.</p>
                        </div>
                    </div>
                    <div class="bg-slate-800/80 border border-slate-700 rounded-2xl p-8 shadow-xl">
                        <h3 class="text-xl font-bold mb-4 text-gold"><i class="fas fa-balance-scale mr-2"></i> Visi & Misi Divisi Hukum</h3>
                        <div class="space-y-3 text-gray-300 text-sm">
                            <p><strong>VISI HUKUM:</strong> Mewujudkan masyarakat berpendidikan, sehat, mandiri, dan berbudaya serta komunitas pengusaha yang solid, inovatif, dan berdampak positif.</p>
                            <p><strong>MISI HUKUM:</strong> Dukungan medis/psikologis, santunan anak terlantar/disabilitas, serta membangun jaringan kerjasama strategis multi-pihak.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- KEGIATAN & YOUTUBE -->
        <section id="kegiatan" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-gold font-bold uppercase tracking-widest text-xs">DOKUMENTASI & MEDIA</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-2">Video & Liputan Media</h2>
                    <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <div class="bg-gray-50 p-4 rounded-2xl border">
                        <p class="font-bold text-sm text-slate-800 mb-3"><i class="fab fa-youtube text-red-600"></i> Pelantikan Pengurus Yayasan</p>
                        <div class="aspect-video rounded-xl overflow-hidden shadow">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/OXLuE6ZQj70" title="Video 1" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border">
                        <p class="font-bold text-sm text-slate-800 mb-3"><i class="fab fa-youtube text-red-600"></i> Aksi Sosial Kemasyarakatan</p>
                        <div class="aspect-video rounded-xl overflow-hidden shadow">
                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/P_8WyO7_7PU" title="Video 2" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <!-- Berita Eksternal -->
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6">
                    <span class="bg-red-600 text-white text-xs px-3 py-1 rounded-full font-bold">Liputan Nasional</span>
                    <h3 class="text-lg font-bold text-slate-900 mt-3">Dinsos Surabaya Terima 275 Kain Kafan untuk Jenazah Warga Tanpa Keluarga</h3>
                    <p class="text-gray-600 text-sm mt-2">Bantuan diserahkan langsung oleh Yayasan Harmoni Abadi Sejati sebagai wujud kepedulian sosial di Kota Surabaya.</p>
                    <a href="https://www.tvonenews.com/daerah/jatim/458586-dinsos-surabaya-terima-275-kain-kafan-untuk-jenazah-warga-tanpa-keluarga" target="_blank" class="inline-block mt-4 text-xs font-bold text-red-600 hover:underline">Baca selengkapnya di tvOneNews &rarr;</a>
                </div>
            </div>
        </section>

        <!-- ARTIKEL -->
        <section id="artikel" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-gold font-bold uppercase tracking-widest text-xs">WARTA</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-2">Artikel Kegiatan Internal</h2>
                    <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($data_db['artikels'] as $art): ?>
                        <div class="bg-white p-6 rounded-2xl shadow border">
                            <span class="text-xs font-bold text-gold"><?= $art['tanggal'] ?></span>
                            <h3 class="font-bold text-slate-900 text-lg mt-1 mb-2"><?= htmlspecialchars($art['judul']) ?></h3>
                            <p class="text-gray-600 text-sm"><?= htmlspecialchars($art['konten']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- KONTAK -->
        <section id="kontak" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-gold font-bold uppercase tracking-widest text-xs">SEKRETARIAT</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-2">Hubungi Kami</h2>
                    <div class="w-20 h-1 bg-gold mx-auto mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div class="space-y-6 bg-gray-50 p-8 rounded-2xl border">
                        <h3 class="text-xl font-bold text-slate-900">Yayasan Harmoni Abadi Sejati</h3>
                        <p class="text-sm text-gray-600"><i class="fas fa-map-marker-alt text-gold mr-2"></i> Vila Taman Telaga 2 blok TJ 11 no 1 Citraland, Surabaya, Jawa Timur 60211</p>
                        <p class="text-sm text-gray-600"><i class="fas fa-phone text-gold mr-2"></i> +62 813-5767-0968 / +62 81234531969</p>
                        <p class="text-sm text-gray-600"><i class="fas fa-envelope text-gold mr-2"></i> harmoniabadisejati@gmail.com</p>
                    </div>

                    <div class="bg-slate-900 text-white p-8 rounded-2xl shadow-xl">
                        <h3 class="text-xl font-bold mb-4">Kirim Pesan / Donasi</h3>
                        <?php if (!empty($pesan_status)): ?>
                            <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-300 p-3 rounded-lg text-xs mb-4">
                                <?= $pesan_status ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-300 mb-1">Nama Lengkap</label>
                                <input type="text" name="nama" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-300 mb-1">Email / WhatsApp</label>
                                <input type="text" name="email" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-300 mb-1">Pesan</label>
                                <textarea name="pesan" rows="3" required class="w-full bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-gold"></textarea>
                            </div>
                            <button type="submit" name="kirim_pesan" class="w-full gold-gradient text-slate-900 font-bold py-2.5 rounded-lg hover:opacity-95 transition text-sm">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-slate-950 text-gray-400 py-8 text-center text-xs">
            <p>&copy; <?= date('Y') ?> Yayasan Harmoni Abadi Sejati Surabaya. All Rights Reserved.</p>
        </footer>

        <!-- MODAL QUOTES KETUA -->
        <div id="ketuaModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 relative shadow-2xl">
                <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-slate-900 font-bold text-xl"><i class="fas fa-times"></i></button>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Neck Inkiriwang</h3>
                <p class="text-gold text-xs font-bold uppercase mb-4">Ketua Yayasan Harmoni Abadi Sejati</p>
                <div class="bg-amber-50 border-l-4 border-gold p-4 rounded-r-lg mb-4">
                    <p class="text-slate-800 italic text-sm font-medium">“Kehidupan yang bermakna lahir dari niat baik, kerja nyata, hubungan yang sehat, serta kepedulian sosial yang diwujudkan dalam tindakan.”</p>
                </div>
                <button onclick="closeModal()" class="w-full bg-slate-900 text-white font-bold py-2.5 rounded-xl text-sm hover:bg-gold hover:text-slate-900 transition">Tutup</button>
            </div>
        </div>

        <script>
            function openModal() {
                document.getElementById('ketuaModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('ketuaModal').classList.add('hidden');
            }
        </script>
    <?php endif; ?>
</body>

</html>