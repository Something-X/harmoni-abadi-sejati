# Perubahan kecil di index.html (3 langkah)

Taruh `admin.html` satu folder dengan `index.html`.

## 1. Arahkan tombol Admin Dashboard ke halaman baru
Cari baris ini di bagian TOPBAR:

```html
<a href="#" onclick="showAdmin(); return false;" class="text-navy-900 font-bold hover:underline">
```

Ganti menjadi:

```html
<a href="admin.html" class="text-navy-900 font-bold hover:underline">
```

(Blok `#adminPage` yang lama boleh dibiarkan atau dihapus.)

## 2. Tambahkan fungsi pembaca data, tepat sebelum `</head>`

```html
<script>
    function yhData(k, cadangan) {
        try {
            const d = JSON.parse(localStorage.getItem('yayasan_harmoni_db')) || {};
            if (Array.isArray(d[k]) && d[k].length) return d[k];
        } catch (e) { }
        return cadangan;
    }
</script>
```

## 3. Hubungkan video dan artikel ke data admin

Di script video, ubah `const VIDEOS = [` menjadi `const VIDEOS = yhData('videos', [`
dan ubah `];` penutupnya menjadi `]);`.

Di script artikel, ubah `const WARTA = [` menjadi `const WARTA = yhData('warta', [`
dan ubah `];` penutupnya menjadi `]);`.

Selesai. Isi array lama tidak perlu dihapus, ia menjadi data cadangan.
