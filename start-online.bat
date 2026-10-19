@echo off
title ANDRA JB - Online Launcher (Cloudflare)
echo ===================================================================
echo             ANDRA JB - LAUNCHER CLOUDFLARE TUNNEL
echo ===================================================================
echo.
cd /d "%~dp0"

echo [1/4] Menyiapkan port 8080...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :8080 ^| findstr LISTENING') do (
    echo Menghentikan proses lama di Port 8080 - PID %%a...
    taskkill /F /PID %%a >nul 2>&1
)
ping 127.0.0.1 -n 2 >nul

echo [2/4] Mengoptimalkan cache performa (Routes, Views, Config)...
call php artisan optimize >nul 2>&1

echo [3/4] Memulai server Laravel Backend di Port 8080...
start "LaravelBackend" /min php artisan serve --port=8080
ping 127.0.0.1 -n 4 >nul

echo Server Laravel berjalan di latar belakang Port 8080.
echo.
echo [4/4] Menghubungkan ke Cloudflare Tunnel Protocol HTTP/2...
echo Link publik Anda akan muncul di bawah ini - salin link trycloudflare:
echo ===================================================================
echo.

"C:\Program Files (x86)\cloudflared\cloudflared.exe" tunnel --protocol http2 --url http://127.0.0.1:8080

echo.
echo Menutup server Laravel latar belakang...
for /f "tokens=5" %%a in ('netstat -aon ^| findstr :8080 ^| findstr LISTENING') do (
    taskkill /F /PID %%a >nul 2>&1
)
call php artisan optimize:clear >nul 2>&1
echo Selesai.
pause
