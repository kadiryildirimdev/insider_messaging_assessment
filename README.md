# Insider Messaging Assessment

Bu proje Laravel 10.48 tabanlı, PostgreSQL 17 ve Redis kullanan bir mesajlaşma uygulamasıdır.

## Kullanılan Teknolojiler

- Laravel Framework 10.48
- PostgreSQL 17
- Redis

## Veritabanı Konfigürasyonu

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=insider_messaging_assessment
DB_USERNAME={veritabanı_kullanıcı_adı}
DB_PASSWORD={veritabanı_kullanıcı_şifresi}
```
## Redis Konfigürasyonu
```
REDIS_CLIENT=predis
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6380
```

## Artisan Komutları

## Otomatik Mesaj Gönderimi

Proje deploy edildikten sonra, veritabanındaki gönderilmemiş mesajlar için otomatik mesaj gönderimi başlatılmalıdır. Bunun için manuel olarak aşağıdaki komut çalıştırılır:

````bash
php artisan message:send-pending
````

### ReadMessage

ID ile mesaj görüntüleme işlemini gerçekleştirir.

Kullanımı;

Terminal üzerinden "php artisan message:read {id}" şeklinde kullanılır.

Örnek; 
````bash
php artisan message:read "9f9e09d2-df95-4f7c-9909-64ef508d10c6"
````

### SendPendingMessages

Gönderilmemiş mesajları kuyrukta işleme işlemini gerçekleştirir.

Kullanımı;

Terminal üzerinden "php artisan message:send-pending" şeklinde kullanılır.

Örnek;
````bash
php artisan message:send-pending
````

## Route Tanımlamaları

Gönderilen mesajların listesini getiriren bir API End-point'te sunulmuştur.  
````
Route::get('/messages/list', [MessageController::class, 'list']);
````


Ayrıca tekli ve toplu mesaj gönderimi, mesaj görüntüleme içinde API End-point'i sunulmuştur.
````
Route::post('/messages/createBulk', [MessageController::class, 'createBulk']);
Route::post('/messages/create', [MessageController::class, 'create']);
Route::get('/messages/read', [MessageController::class, 'read']);
````

## API Dokümantasyonu (Swagger)

API endpointleri Swagger/OpenAPI ile dokümante edilmiştir. Dokümana aşağıdaki URL’den erişebilirsiniz:
````
{url}/api/documentation
````

## Birim ve Entegrasyon Testleri

Birim ve Entegrasyon testlerini çalıştırmak için:
````bash
php artisan test
````

## Veritabanı Migration ve Seed

Veritabanı tabloları migration ile oluşturulmaktadır. Migration çalıştırmak için:
````bash
php artisan migrate --seed
````
