## Порядок деплоя

**_git clone https://github.com/MrDreek/cuba-ai-bot.git_**

**_composer install --no-dev_** установка зависимостей без require-dev

**_php -r "file_exists('.env') || copy('.env.example', '.env');"_**

**_php artisan key:generate_**

Указать необходимые данные в файле .env (Подключение к базе, настройки прокси, ключи от АПИ)

_**php artisan config:cache**_  // команда для кеширования настроек окружения

_**php artisan migrate**_  // Применение миграций 

## Endpoint

POST /api/weather/get-weather

Запрос:
```json
{
	"name":"Матансас"
}
```

Ответ:
```json
{
    "temp": 24,
    "feels_like": 27,
    "temp_water": 29,
    "icon": "bkn_n",
    "condition": "малооблачно",
    "wind_speed": 3.1,
    "wind_gust": 8.3,
    "wind_dir": "восточное",
    "pressure_mm": 753,
    "pressure_pa": 1004,
    "humidity": 94,
    "uv_index": 0,
    "soil_temp": 24,
    "soil_moisture": 0.47,
    "daytime": "темное время суток",
    "polar": false,
    "season": "осень",
    "obs_time": 1538987766,
    "source": "station"
}
```


GET /api/money/get-rate

Ответ:
```json
{
"CUP_RUB": 2.468985,
"CUC_RUB": 65.462301,
"CUP_USD": 0.037736,
"CUC_USD": 1
}
```


POST /api/ticket/search

Запрос:
```json
{
	"departure_city": "Санкт-Петербург",
	"arrival_city": "Гавана",
	"departure_date": "10.10.2018",
	"return_date": "20.10.2018",
	"AD": "2", 
	"CN": "4",
	"IN": "2",
	"SC": "Эконом"
}
```

AC - Количество взрослых (от 1 до 6)
CN - Количество детей в возрасте от 2х месяцев до 12 лет (от 0 до 4)
IN  - Количетсво детей в возрасте от 2х недель до 2х лет (От 0 до 2)

Общее количество человек не должно привышать 8 человек


Ответ:
```json
{
    "Id": "41658830442170"
}
```

Id - номер запроса

POST /api/ticket/check

Запрос:
```json
{
	"requestId": 41658830442170
}
```

Ответ:
```json
{
    "percentage": "100",
    "message": "Готов к получению результатов"
}
```

precentage - процент выполнения поиска результата
message - сообщение( Готов к получению результатов или результат ещё не готов)

Рекомендуется опрашивать метод не более чем раз в 2 секунды

POST /api/ticket/get-result

Запрос:
```json
{
	"requestId": 41658830442170
}
```

Ответ:
```json
{
    "link": "https://www.anywayanyday.com/avia/offers/1010LEDHAV2010HAVLEDAD2CN4IN2SCE/?R=41658830442170&Language=RU&Currency=RUB",
    "results": {
        "current_page": 1,
        "data": [
            {
                "AC": "Air France",
                "AT": "367777",
                "to": {
                    "department_time": "09:10",
                    "department_date": "10.10.2018",
                    "flight_time": "17:55",
                    "route": "CDG"
                },
                "from": {
                    "department_time": "22:25",
                    "department_date": "10.10.2018",
                    "flight_time": "32:25",
                    "route": "CDG"
                }
            },
            {
                "AC": "KLM",
                "AT": "376265",
                "to": {
                    "department_time": "05:45",
                    "department_date": "10.10.2018",
                    "flight_time": "21:20",
                    "route": "AMS;CDG"
                },
                "from": {
                    "department_time": "22:25",
                    "department_date": "10.10.2018",
                    "flight_time": "32:25",
                    "route": "CDG"
                }
            },
            {
                "AC": "KLM",
                "AT": "376265",
                "to": {
                    "department_time": "05:45",
                    "department_date": "10.10.2018",
                    "flight_time": "21:20",
                    "route": "AMS;CDG"
                },
                "from": {
                    "department_time": "22:25",
                    "department_date": "10.10.2018",
                    "flight_time": "32:25",
                    "route": "CDG"
                }
            },
            {
                "AC": "KLM",
                "AT": "376265",
                "to": {
                    "department_time": "05:45",
                    "department_date": "10.10.2018",
                    "flight_time": "21:20",
                    "route": "AMS;CDG"
                },
                "from": {
                    "department_time": "22:25",
                    "department_date": "10.10.2018",
                    "flight_time": "32:25",
                    "route": "CDG"
                }
            },
            {
                "AC": "KLM",
                "AT": "376265",
                "to": {
                    "department_time": "05:45",
                    "department_date": "10.10.2018",
                    "flight_time": "21:20",
                    "route": "AMS;CDG"
                },
                "from": {
                    "department_time": "22:25",
                    "department_date": "10.10.2018",
                    "flight_time": "32:25",
                    "route": "CDG"
                }
            }
        ],
        "first_page_url": "http://192.168.42.135/api/ticket/get-result?page=1",
        "from": 1,
        "last_page": 24,
        "last_page_url": "http://192.168.42.135/api/ticket/get-result?page=24",
        "next_page_url": "http://192.168.42.135/api/ticket/get-result?page=2",
        "path": "http://192.168.42.135/api/ticket/get-result",
        "per_page": 5,
        "prev_page_url": null,
        "to": 5,
        "total": 116
    }
}
```

link - ссылка на страницу покупки билетов
results - массив билетов, отсортированных по цене
path - url метода
first_page_url - ссылка пагинации, на первую страницу
last_page_url - ссылка пагинации, на последную страницу
next_page_url - ссылка пагинации, на следующую страницу
prev_page_url - ссылка пагинации, на предыдущую страницу

last_page - номер последней страницы
per_page - количество элементов на странице
from - номер первого элемента на странице
to - номер последнего элемента на странице
total - общее количество элементов на странице
