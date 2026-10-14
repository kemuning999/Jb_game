@echo off
title ANDRA JB - Online Launcher (Cloudflare)
echo ===================================================================
echo             ANDRA JB - LAUNCHER CLOUDFLARE TUNNEL
echo ===================================================================
echo.
cd /d "%~dp0"

echo [1/2] Memastikan server Laravel berjalan di Port 8080...
netstat -ano | findstr :8080 >nul
if %errorlevel% neq 0 (
    start "Laravel Backend (Port 8080)" /min php artisan serve --port=8080
    timeout /t 3 /nobreak >nul
    echo Server Laravel berhasil dimulai di latar belakang.
) else (
    echo Server Laravel di Port 8080 sudah aktif.
)

echo.
echo [2/2] Menghubungkan ke Cloudflare Tunnel (Protocol HTTP/2)...
echo Link publik Anda akan muncul di bawah ini (salin link .trycloudflare.com):
echo ===================================================================
echo.
"C:\Program Files (x86)\cloudflared\cloudflared.exe" tunnel --protocol http2 --url http://127.0.0.1:8080
pause
