@echo off
@break off
@title Create folder with batch but only if it doesn't already exist - D3F4ULT
@color 0a
@cls

setlocal EnableDelayedExpansion

if not exist "D:\backupDataSql" (
  mkdir "D:\backupDataSql\"
  if "!errorlevel!" EQU "0" (
    echo Folder created successfully
  ) else (
    echo Error while creating folder
  )
) else (
  echo Folder already exists
)
D:\xampp\mysql\bin\mysqldump.exe -u root --databases cellar > D:\backupDataSql\callar.sql

pause
exit