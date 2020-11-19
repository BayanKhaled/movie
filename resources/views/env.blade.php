 <p> Mail Driver: {{ env('APP_NAME')}} </p>
 {{ putenv("APP_NAME=hero") }}
 <p> Mail Driver: {{ env('APP_NAME') }}</p>
  <br>
  <p> Mail Domain: {{ env('MAIL_HOST') }}</p>
  <br>
  <p> Mail Secret: {{ env('APP_URL') }}</p>
  <br>
  <p> DB Host: {{ env('DB_HOST') }}</p>

<!-- 
TO WORK MUST :
php artisan config:clear
 -->