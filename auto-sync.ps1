# ============================================
# 🔄 Auto Sync Script - Har 1 minute per
# ============================================

$projectPath = "C:\Users\satyam\stripe-course"
$logFile = "$projectPath\logs\sync.log"

# Log directory create करो अगर नहीं है
if (-not (Test-Path "$projectPath\logs")) {
    New-Item -ItemType Directory -Path "$projectPath\logs" | Out-Null
}

Write-Host "🚀 Starting Auto-Sync Service..." -ForegroundColor Green
Write-Host "📁 Project: $projectPath" -ForegroundColor Cyan
Write-Host "📝 Logs: $logFile" -ForegroundColor Cyan
Write-Host "⏰ Syncing every 1 minute..." -ForegroundColor Yellow
Write-Host ""

while ($true) {
    $timestamp = Get-Date -Format "yyyy-MM-dd HH:mm:ss"
    Write-Host "[$timestamp] Running sync..." -ForegroundColor Gray
    
    try {
        Push-Location $projectPath
        & php artisan sync:pull 2>&1 | Add-Content -Path $logFile
        Pop-Location
        Write-Host "[$timestamp] ✅ Sync completed" -ForegroundColor Green
    }
    catch {
        Write-Host "[$timestamp] ❌ Sync failed: $_" -ForegroundColor Red
        "[$timestamp] ❌ Error: $_" | Add-Content -Path $logFile
    }
    
    # 60 seconds wait करो
    Start-Sleep -Seconds 60
}
