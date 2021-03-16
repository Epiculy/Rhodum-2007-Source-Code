@echo off
if not exist "C:\Rhodum2009\Client\2009" exit
cd C:\Rhodum2009\Client\2009
set /p username="Enter username: "
set /p token="Enter connection token: "
set /p gameid="Enter game id: "
powershell -Command "(New-Object Net.WebClient).DownloadFile('http://rhodum.xyz/2009/auth.php?username=%username%&token=%token%', '1.txt')"
set /p response=<1.txt
if "%response%"=="ZXZlcnkgZGF5IEkgYmVhdCBteSBjb2NrIGNvY2ssIGxldCBpbiB0aGUgc29jayBzb2Nr" (
    del "C:\Rhodum2009\Client\2009\1.txt" /s /f /q
	cls
    Rhodum.exe -script "wait(); dofile('http://rhodum.xyz/2009/char.php?player=%username%') dofile('http://rhodum.xyz/2009/verify.php?id=%gameid%&pname=%username%')"
) else (
	del "C:\Rhodum2009\Client\2009\1.txt" /s /f /q
    cls
    @echo The connection token was incorrect. Please try again.
    pause
)
