@echo off
setlocal EnableDelayedExpansion

:: Ambil IPv4 lokal
for /f "tokens=2 delims=:" %%A in ('ipconfig ^| findstr "IPv4"') do (
    set "ip=%%A"
    set "ip=!ip:~1!"
    if not "!ip:~0,3!"=="169" (
        goto found
    )
)

:found
echo IP Ditemukan: %ip%

:: Path file
set "ENV_PATH=C:\laragon\www\kesra\.env"
set "NGINX_CONF=C:\laragon\etc\nginx\sites-enabled\auto.kesra.test.conf"

:: Perbarui .env
(
    for /f "usebackq delims=" %%A in ("%ENV_PATH%") do (
        set "line=%%A"
        setlocal EnableDelayedExpansion
        echo !line! | findstr /i "app.baseURL" >nul
        if !errorlevel! == 0 (
            echo app.baseURL = http://%ip%:8080/
        ) else (
            echo !line!
        )
        endlocal
    )
) > "%ENV_PATH%.tmp"
move /Y "%ENV_PATH%.tmp" "%ENV_PATH%" >nul

:: Perbarui nginx conf
(
    for /f "usebackq delims=" %%A in ("%NGINX_CONF%") do (
        set "line=%%A"
        setlocal EnableDelayedExpansion
        echo !line! | findstr /i "server_name" >nul
        if !errorlevel! == 0 (
            echo     server_name %ip%;
        ) else (
            echo !line!
        )
        endlocal
    )
) > "%NGINX_CONF%.tmp"
move /Y "%NGINX_CONF%.tmp" "%NGINX_CONF%" >nul

:: Restart Nginx
start "" "C:\laragon\laragon.exe" reload

echo ================================
echo ADBIRA siap diakses:
echo http://%ip%:8080
echo ================================

pause
