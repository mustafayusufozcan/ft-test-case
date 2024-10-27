# FT TEST CASE

## Kurulum
Projeyi indirdikten sonra `.env.example` dosyasının adını `.env` olarak değiştirin.

`.env` dosyası içindeki `DB_` önekli ayarları kendi veritabanı bilgilerinizle değiştirin. Daha sonra aynı dosya içindeki `REDIS_` önekli ayarları kontrol edin, gerekirse değiştirin.

Bu işlemlerden sonra aşağıdaki komutları sırasıyla çalıştırın.

```
php artisan key:generate
php artisan migrate
```

## Kullanım
`php artisan app:fetch-news-command` komutu ile haber sağlayıcılarından veriler çekilip veritabanına kaydedilir.

Proje ana sayfasında veriler listelenmektedir.