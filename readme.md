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


POST /api/tour/search

Запрос:
```json
{
	"from_city":"Санкт-Петербург",
	"to_city": "Гавана",
	"nights": 7,
	"adults": 2,
	"start_date": "18.10.2018",
	"stars_from": 1,
	"stars_to": 5
}
```
Обязательные:
from_city - Город отправления
nights - количество ночей прибывания
adults - Количетсво взрослых
start_date - Дата начала

to_city - Город прибытия
stars_from - Количество звёзд "с"
stars_to - Количество звёзд "до"
hotel_ids - ид отелей через запятую
kids - колчество детей
kids_ages - возраст детей через запятую, обязательный, если указано количество детей



Ответ:
```json
{
    "message": "Поиск начат",
    "requestId": "MnwyMjV8MTAxMzd8MTAwMTd8fDIwMTgtMTAtMTgsMjAxOC0xMC0xOHwwfDcsN3wyfDB8fHww"
}
```

requestId - id запроса на поиск туров

POST /api/tour/check

Запрос:
```json
{
	"requestId":"MnwyMjV8MTAxMzd8MTAwMTd8fDIwMTgtMTAtMTgsMjAxOC0xMC0xOHwwfDcsN3wyfDB8fHww"
}
```
Обязательный:
requestId - Id запроса на поиск тура

Ответ:
```json
{
    "message": "Результат не готов!",
    "error": "Request expired"
}
```

POST /api/tour/get-result

Запрос:
```json
{
	"requestId":"MnwyMjV8MTAxMzd8MTAwMTd8fDIwMTgtMTAtMTgsMjAxOC0xMC0xOHwwfDcsN3wyfDB8fHww"
}
```
Обязательный:
requestId - Id запроса на поиск тура

Ответ:
```json
[
    {
        "name": "Lincoln Hotel",
        "desc": "Отель в центре Гаваны для экономных невзыскательных туристов. Простые номера и минимальный набор услуг.",
        "stars": 2,
        "min_price": 170420,
        "max_price": 170420,
        "food": [
            {
                "FB": "Полный пансион"
            },
            {
                "BB": "Завтрак"
            },
            {
                "HB": "Полупансион"
            }
        ],
        "link": "https://level.travel/hotels/9061507-Lincoln_Hotel"
    },
    {
        "name": "St. John's & Vedado (Ex Gran Caribe)",
        "desc": "Отель находится в очень оживленном районе, рядом много клубов, кафе, ресторанов. В отеле маленькие номера, скудное меню в ресторане. Для непритязательных туристов и экономичного отдыха.",
        "stars": 3,
        "min_price": 181777,
        "max_price": 181777,
        "food": [
            {
                "HB": "Полупансион"
            },
            {
                "FB": "Полный пансион"
            },
            {
                "BB": "Завтрак"
            }
        ],
        "link": "https://level.travel/hotels/39900-St__Johns_And_Vedado_Ex_Gran_Caribe"
    },
    {
        "name": "St' John",
        "desc": "Приют спокойствия в центре большого города, но в то же время прекрасный выбор для тех, кто ищет близость к развлечениям столицы. Рекомендуем как вариант эконом-отдыха для активных туристов.",
        "stars": 3,
        "min_price": 181777,
        "max_price": 181777,
        "food": [
            {
                "BB": "Завтрак"
            },
            {
                "HB": "Полупансион"
            }
        ],
        "link": "https://level.travel/hotels/9015953-St_John"
    },
    {
        "name": "Nacional",
        "desc": "Самый знаменитый отель Гаваны, где останавливались известные политики, актеры и снимались многие голливудские фильмы о мафии. В отеле сохранены интерьеры, атрибутика и форма обслуживающего персонала 30-х годов прошлого века.",
        "stars": 5,
        "min_price": 227204,
        "max_price": 320898,
        "food": [
            {
                "BB": "Завтрак"
            },
            {
                "HB": "Полупансион"
            }
        ],
        "link": "https://level.travel/hotels/39884-Nacional"
    },
    {
        "name": "Melia Habana",
        "desc": "Отель расположился в деловом районе Мирамар, достаточно близко к историческому центру. Условия размещения и сервис – на высоком уровне, хороший район, есть где погулять вечером. Достойный отель для спокойного или романтического отдыха.",
        "stars": 5,
        "min_price": 232882,
        "max_price": 366798,
        "food": [
            {
                "BB": "Завтрак"
            }
        ],
        "link": "https://level.travel/hotels/39909-Melia_Habana"
    },
    {
        "name": "Iberostar Parque Central",
        "desc": "Отель расположен в историческом центре Гаваны, напротив центрального парка. Рядом с отелем находятся знаменитый Большой театр, Капитолий, Музей искусств, дом Баккарди. В непосредственной близости начинается главная пешеходная улица старой части Гаваны - Obispo. До набережной Малекон можно дойти за 10-15 минут по тенистому бульвару Прадо.",
        "stars": 5,
        "min_price": 249444,
        "max_price": 355441,
        "food": [
            {
                "HB": "Полупансион"
            },
            {
                "BB": "Завтрак"
            }
        ],
        "link": "https://level.travel/hotels/53775-Iberostar_Parque_Central"
    },
    {
        "name": "Melia Cohiba",
        "desc": "Отель находится в районе Ведадо, в некотором удалении от достопримечательностей старой части Гаваны. Просторные номера. В главном ресторане есть комната для молодоженов. В отеле находятся самый оригинальный клуб Habana Cafe и Дом сигар (бар и магазин). Можно рекомендовать взыскательным туристам, деловым людям, а также для проведения конференций.",
        "stars": 5,
        "min_price": 277363,
        "max_price": 420134,
        "food": [
            {
                "BB": "Завтрак"
            },
            {
                "HB": "Полупансион"
            }
        ],
        "link": "https://level.travel/hotels/39912-Melia_Cohiba"
    }
]
```

