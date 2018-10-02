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

```json
{
	"name":"Матансас"
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
