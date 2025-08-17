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

## Penggunaan

```php
<?php

use LibSmsZenziva\Library\Library\Sender;
use LibSms\Library\Sms;

// Get Balance
$balance = Sender::balance();

// Send OTP Text
$message = 'Gunakan OTP: 121212';
$result = Sender::otp($phone, $message);

// Send Text
$message = 'Hallo promo';
$result = Sender::send($phone, $message);
$result = Sms::send($phone, $message);

// Send Voice
$message = 'Hallo Promo';
$result = Sender::voice($phone, $message);

// Send WA
$otp = '121212';
$brand = 'MyBrand';
$result = Sender::wa($phone, $otp, $brand);
```

## Development

Tambahkan file `zenziva-text.txt` di folder aplikasi untuk melewati proses pengiriman
sms selama masa development.
