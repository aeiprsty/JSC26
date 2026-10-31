$ErrorActionPreference = "Stop"

$SqlitePath = "C:\sqlite\sqlite3.exe"
$DatabasePath = "C:\Projects\tps-liar\database\database.sqlite"
$BackupFolder = "C:\Projects\tps-liar\storage\backups"
$Timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$BackupPath = Join-Path $BackupFolder "jambibersih_auto_$Timestamp.sqlite"

# Pastikan file dan folder tersedia
if (!(Test-Path $SqlitePath)) {
    throw "sqlite3.exe tidak ditemukan: $SqlitePath"
}

if (!(Test-Path $DatabasePath)) {
    throw "Database tidak ditemukan: $DatabasePath"
}

New-Item -ItemType Directory -Force -Path $BackupFolder | Out-Null

# Buat backup menggunakan SQLite Online Backup API
& $SqlitePath $DatabasePath ".backup '$BackupPath'"

if ($LASTEXITCODE -ne 0 -or !(Test-Path $BackupPath)) {
    throw "Proses backup gagal."
}

# Periksa integritas file backup
$Check = & $SqlitePath -batch -noheader $BackupPath "PRAGMA integrity_check;"

if ($LASTEXITCODE -ne 0 -or $Check -ne "ok") {
    throw "Backup dibuat, tetapi pemeriksaan integritas gagal: $Check"
}

# Hapus backup otomatis yang lebih lama dari 30 hari
Get-ChildItem $BackupFolder -Filter "jambibersih_auto_*.sqlite" |
    Where-Object { $_.LastWriteTime -lt (Get-Date).AddDays(-30) } |
    Remove-Item -Force

Write-Host "Backup berhasil: $BackupPath"
Write-Host "Integritas: $Check"
