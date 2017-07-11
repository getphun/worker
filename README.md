# worker

System scheduler. Jalankan cron setiap 15 detik, atau lebih cepat untuk mengeksekusi
`php ./etc/worker/bin/cron.php`

Module ini menambahkan satu service pada aplikasi dengan nama `worker` yang memiliki
beberapa method seperti di bawah:

## add(name, url, time)

Menambahkan job schedule baru. Fungsi ini selalu mengembalikan `true`.

```php
...
    $this->worker->add('worker-unique-name', 'https://www.google.com/', time() + 20);
    // memanggil https://www.google.com/ 20 detik dari sekarang
...
```

## exists(name)

Mengecek jika job dengan suatu nama sudah ada, fungsi ini akan mengembalikan `true`
jika sudah ada, dan `false` jika belum ada.

## list

Mengambil semua jobs yang terdaftar. Fungsi in akan mengembalikan array.

## remove(name)

Menghapus job yang sudah pernah didaftarkan. Fungsi ini akan mengembalikan `true`
jika job berhasil di hapus, atau `false` jika gagal atau job tidak ada.

## get(name)

Mengambil detail suatu job berdasarkan nama, fungsi ini akan throw exception jika
target job tidak ditemukan. Pastikan gunakan fungsi `exists` sebelum meng-`get`.

```php
...
    $job = $this->worker->get('name');
    // stdClass Object
    // (
    //     [name] => dumba
    //     [time] => 1499155913
    //     [url] => http://google.com/
    // )
...
```