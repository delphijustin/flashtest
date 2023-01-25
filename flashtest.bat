@echo off
set exedir=x86
if exist %windir%\SYSWOW64\kernel32.dll set exedir=x64
cd %exedir%
if not exist %Windir%\system32\vcruntime140.dll goto noruntime
php ..\flashtest.php
if errorlevel 1 pause
goto done
:noruntime
echo Visual C++ Runtime DLL VCRUNTIME140.DLL was not found,download it?
pause
start https://aka.ms/vs/16/release/VC_redist.%exedir%.exe
:done