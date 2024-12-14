
## Настраиваем

1. Запустить композер `compose install`
2. Поднять докера `docker compose up -d`
3. В контейнере приложения выполнить `php artisan migrate`

Доступен роут `http://localhost:8080/api/bypass`

Если флаг proxy = false то будет попытка парсинга без использования прокси

По дефолту прокси включены
Они читаются из файлика storage/app/private/proxy_list.txt

Добавлять в формате `{scheme://[user:pass]@host:port}`
Юзер и пароль опциональные

При использовании прокси куки используются серверные, из запроса игнорируются

Пример body 
```
{
  "url": "https://skylots.org/search.php?seller_id=45360143",
  //"url": "https://violity.com/ru/vi21233/item",
  "method":"GET",
  "cookies" : {
    "cf_clearance": "wEHdtYqBhefmvoTnvhhaqFQckFGijM0BY8Ge7OYNR0Q-1733676250-1.2.1.1-h_16_dfDi4TBoVH7Hgd65bY6SEuFSXO2dKgUIVKUsTnmF6Yrjv7WWnXqP9dNi3uXmr._I26Lq59WFakSqUnjumPQANQHhfbET.8DZaIhx_HXFTj7C92zVdBi8vHLSTpNRnEctCa4V91seEOtZ_1eeSUDEpVK_P.W3bjpnakLXc7RC1nXpvFswhB0n1GStc5os2W0UuoJExsAWXyUJ56bMQul_yROtiT8yknCsq6Ucb0AxZ4tlI9gST5Q29E0HZqHz6669XdZvt9Kv0llmFsG4E7pxXKhhfWmKJutLLlnavZBR_nt4f47BDPA0HRIS.jbGV.T0qujFShuiSFXRYjMLaF3cn.ZwlBqwjlO6sFzYuJmDowgfnBylXh97iSPFArwSWNWX_sVQEtoQsEIUaaHhJzU.nqnOdwyFu8QIcam8y4"
  },
  "proxy": true
}
```

Пример ответа
```
{
    "status": "ok",
    "cookies": [
        {
            "domain": ".skylots.org",
            "expiry": 1765226449,
            "httpOnly": false,
            "name": "FCNEC",
            "path": "/",
            "sameSite": "Lax",
            "secure": false,
            "value": "%5B%5B%22AKsRol9KHYFEGVEAGF9_CpnFjk1U932-_YJ0YFjQvNmAoDjeGbPHsMYFn6bgDvd6OkKK0Ret4Zjt4Gj6Fryzva3zQelzE7F-Q_VamkVH-v0zqEIvPelIDKA0cL9-6T5_wJS5M27C9fjJFNz7ZKWkaM9lImdOG99lzQ%3D%3D%22%5D%5D"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1767375645,
            "httpOnly": false,
            "name": "__gpi",
            "path": "/",
            "sameSite": "None",
            "secure": true,
            "value": "UID=00000f670b181946:T=1733679645:RT=1733679645:S=ALNI_MYiuQ8hm0bm_7M0S_eK0FheluLJDw"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1767375645,
            "httpOnly": false,
            "name": "__gads",
            "path": "/",
            "sameSite": "None",
            "secure": true,
            "value": "ID=1059f304a396c488:T=1733679645:RT=1733679645:S=ALNI_MaAtC-5vW-vwkgLiZjpMI1wkg3J7Q"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1749231645,
            "httpOnly": false,
            "name": "__eoi",
            "path": "/",
            "sameSite": "None",
            "secure": true,
            "value": "ID=51d059e76efd7bea:T=1733679645:RT=1733679645:S=AA-AfjZN8VLyvw9p6uEa_SaHtKiv"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1768250448,
            "httpOnly": false,
            "name": "_ga_EYSW2HT585",
            "path": "/",
            "sameSite": "Lax",
            "secure": false,
            "value": "GS1.2.1733690448.1.0.1733690448.0.0.0"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1741466448,
            "httpOnly": false,
            "name": "_gcl_au",
            "path": "/",
            "sameSite": "Lax",
            "secure": false,
            "value": "1.1.1655705727.1733690448"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1733776848,
            "httpOnly": false,
            "name": "_gid",
            "path": "/",
            "sameSite": "Lax",
            "secure": false,
            "value": "GA1.2.1173237178.1733690448"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1768250448,
            "httpOnly": false,
            "name": "_ga",
            "path": "/",
            "sameSite": "Lax",
            "secure": false,
            "value": "GA1.2.27080270.1733690448"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1733690508,
            "httpOnly": false,
            "name": "_gat",
            "path": "/",
            "sameSite": "Lax",
            "secure": false,
            "value": "1"
        },
        {
            "domain": ".skylots.org",
            "expiry": 1765226447,
            "httpOnly": true,
            "name": "cf_clearance",
            "path": "/",
            "sameSite": "None",
            "secure": true,
            "value": "KL0TAr3FA_rkokmlwVjWSnbxjLaRVWgVL6X7kyQRtBQ-1733679642-1.2.1.1-RlUo8BLBg5JLEoLWnBxLa8249swV1ZfF8u9qpqEiXCYUcsaZSHWlC_rHhdZdH6sfEfBawotZgc2Fq1vTcGvhHslCjRbA8jTLAB5yY0fZoGrPatj_syHaDuifuOrIiuYNuToRo4G.DrwgbCvHu2T0.ZGsH3MGmfvRh2txg29Bcuo0URYbUGeiB7EZnJcDAkl15.BHsRoW0Pry35RkD5kXWU_3FYBsuUTzUEbMjLyn2pulNcMiVTw2wd0YmuZ1nPGOZJU5hIyCRwjRmWuxosk7eFH9JSJOpCDQ5KzM.00qGv_hFTQCk0PkEK8.Em6iIe3bzDkE0gPo4GquZ2EHR7yfF1fkGmTJAFHqlWO3Q_dYUwgykDwHZfG31iMEU2bvKLaYI1egNSQ4Kln8qfH9iuGjy6v3GQiHVvugjefNxSt3CTY"
        }
    ],
    "response":"<escaped html>"
}
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
