@echo off
title ANDRA JB - High Performance Online Launcher
echo ===================================================================
echo             ANDRA JB - HIGH PERFORMANCE LAUNCHER
echo ===================================================================
echo.
cd /d "%~dp0"

echo [1/5] Menyiapkan port 8080 dan port 8000...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :8080 ^| findstr LISTENING') do (
    taskkill /F /PID %%a >nul 2>&1
)
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :8000 ^| findstr LISTENING') do (
    taskkill /F /PID %%a >nul 2>&1
)
taskkill /F /IM nginx.exe >nul 2>&1
ping 127.0.0.1 -n 2 >nul

echo [2/5] Mengoptimalkan cache Laravel (Routes, Views, Config)...
call php artisan optimize >nul 2>&1

echo [3/5] Memulai PHP Backend Engine di Port 8000...
start "LaravelBackend" /min php -S 127.0.0.1:8000 -t public vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php
ping 127.0.0.1 -n 3 >nul

echo [4/5] Memulai Nginx High-Performance Reverse Proxy & Asset Cache di Port 8080...
start "NginxServer" /min "C:\laragon\bin\nginx\nginx-1.22.0\nginx.exe" -p "C:\laragon\bin\nginx\nginx-1.22.0" -c "conf\jbgame.conf"
ping 127.0.0.1 -n 2 >nul

echo Web Server Nginx + PHP Backend Berjalan Sangat Cepat.
echo.
echo [5/5] Menghubungkan ke Cloudflare Tunnel Protocol HTTP/2...
echo Link publik Anda akan muncul di bawah ini - salin link trycloudflare:
echo ===================================================================
echo.

"C:\Program Files (x86)\cloudflared\cloudflared.exe" tunnel --protocol http2 --url http://127.0.0.1:8080

echo.
echo Menutup server latar belakang...
taskkill /F /IM nginx.exe >nul 2>&1
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :8000 ^| findstr LISTENING') do (
    taskkill /F /PID %%a >nul 2>&1
)
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :8080 ^| findstr LISTENING') do (
    taskkill /F /PID %%a >nul 2>&1
)
call php artisan optimize:clear >nul 2>&1
echo Selesai.
pause
