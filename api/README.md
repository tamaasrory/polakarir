## Documentation API

### 1. Membuat Migration untuk membuat tabel
<p>command dibawah ini akan membuat sebuah class migration untuk import table ke database</p>

```shell
php artisan make:migration CreateJenisSuratTable
```

### 2. Run Migration untuk membuat tabel
<p>command dibawah ini akan membuat table di database</p>

```shell
php artisan migrate --path=/database/migrations/2021_06_16_085044_create_jenis_surat_table.php
```

### 3. Membuat Model berdasarkan tabel
<p>command dibawah ini akan membuat class model secara lengkap (property, attribute)</p>

```shell
php artisan make:model JenisSurat --table-name=jenis_surat
```

### 4. Membuat Controller
<p>command dibawah ini akan membuat controller secara lengkap (role di middleware, method, model yang akan digunakan dan title)</p>

```shell
php artisan make:controller JenisSuratController --resource --role=jenis-surat --title="Jenis Surat" --model=JenisSurat --force
```
