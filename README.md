# lib-sms-zenziva

Library sender untuk module `lib-sms` menggunakan service zenziva.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-sms-zenziva
```

## Konfigurasi

Pastikan menambahkan informasi koneksi ke zenziva seperti di bawah pada konfigurasi aplikasi:

```php
return [
    'libSmsZenziva' => [
        'userkey' => '...',
        'passkey' => '...'
    ]
];
```