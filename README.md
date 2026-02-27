Weather API Application
 
This is a Laravel-based backend API that provides weather information using the third-party **OpenWeatherMap API**.

   The application supports:
    - Real-time weather fetching
    - Cached weather responses
    - Input validation
    - Structured error handling
    - Automated feature testing


Requirements
- php 8.2+
- composer
- Git
- Postman (for API testing)

Installation & Setup
- Clone this repository run
    > git clone <repository-url>

- Go to project directory run
    > cd <project-directory>
- run "composer install"
- run the ff. to clear applicaiton cache
    > "php artisan optimize:clear"
    > "php artisan config:clear"
- start the application run
    > "php artisan serve"

- Postman setup 
    - in project root path find and import postman collection "be-weather-app.postman_collection.json"
    > set enviroment variable base_url with a value in which the laravel app serves e.g [http://127.0.0.1:8000]

- Configure Environment
    - Copy the example environment file
        > cp .env.example .env

    - Set your OpenWeather API key inside .env:
        - find and modify key value 
        > OPENWEATHER_API_KEY=your_api_key_here

        - You may register for a free API key at: https://openweathermap.org/

- Automated Testing
    > "php artisan test"


API Endpoints

    
- GET /weather/{city}
  - Fetch real-time weather data from the OpenWeatherMap API. 
          Refer to External References: City name ISO for valid city parameter value
  - Response body property data types
  

             
             {
                "city": "string",
                "temperature": "decimal",
                "weather_description": "string",
                "timestamp": "Y-m-d H:i:s",
                "source": "external"
             }

- GET /weather/{city}/cached
    - Fetch cache weather data or real-time weather data from the OpenWeatherMap API.
    - Response body property data types


          {
                "city": "string",
                "temperature": "decimal",
                "weather_description": "string",
                "timestamp": "Y-m-d H:i:s",
                "source": "external | cache"
          }


External References

- OpenWeatherMapp 
    - Site: https://api.openweathermap.org/
    - Documentation: https://openweathermap.org/current
- City name ISO
    - Site: https://www.iso.org/obp/ui/#search
        -  select country then use "subdivision name" as city name
