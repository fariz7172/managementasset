import os
import re

base_path = r"d:\program file\Project Kantor\Management Asset"

# 1. Update routes/web.php
routes_path = os.path.join(base_path, "routes", "web.php")
with open(routes_path, "r", encoding="utf-8") as f:
    routes_content = f.read()

if "admin/backup-db" not in routes_content:
    new_route = "    Route::get('/admin/backup-db', [DashboardController::class, 'backupDb'])->name('admin.backup');"
    routes_content = routes_content.replace(
        "Route::get('/admin/akses', [DashboardController::class, 'akses']);",
        "Route::get('/admin/akses', [DashboardController::class, 'akses']);\n" + new_route
    )
    with open(routes_path, "w", encoding="utf-8") as f:
        f.write(routes_content)

# 2. Update DashboardController.php
controller_path = os.path.join(base_path, "app", "Http", "Controllers", "DashboardController.php")
with open(controller_path, "r", encoding="utf-8") as f:
    controller_content = f.read()

if "Ifsnop\\Mysqldump" not in controller_content:
    # Add namespace
    controller_content = controller_content.replace(
        "namespace App\\Http\\Controllers;",
        "namespace App\\Http\\Controllers;\n\nuse Ifsnop\\Mysqldump as IMysqldump;"
    )

if "function backupDb" not in controller_content:
    backup_method = """
    public function backupDb()
    {
        try {
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $dbHost = env('DB_HOST', '127.0.0.1');

            $fileName = 'backup_' . $dbName . '_' . date('Y-m-d_H-i-s') . '.sql';
            $filePath = storage_path('app/' . $fileName);

            $dump = new IMysqldump\Mysqldump("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
            $dump->start($filePath);

            return response()->download($filePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal backup database: ' . $e->getMessage());
        }
    }
"""
    # Insert before the last closing brace
    controller_content = controller_content[:controller_content.rfind('}')] + backup_method + "\n}\n"
    with open(controller_path, "w", encoding="utf-8") as f:
        f.write(controller_content)

# 3. Update admin.blade.php sidebar
sidebar_path = os.path.join(base_path, "resources", "views", "layouts", "admin.blade.php")
with open(sidebar_path, "r", encoding="utf-8") as f:
    sidebar_content = f.read()

if "admin/backup-db" not in sidebar_content:
    new_sidebar_menu = """
                <div style="margin: 24px 20px 10px 20px; font-size: 0.75rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Sistem
                </div>
                <a href="{{ route('admin.backup') }}" class="nav-item" onclick="return confirm('Mulai proses backup database? File SQL akan diunduh ke komputer Anda.')">
                    <i class="fa-solid fa-database"></i> Backup Database
                </a>
"""
    sidebar_content = sidebar_content.replace(
        """                <div style="margin: 24px 20px 10px 20px; font-size: 0.75rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Master Data
                </div>""",
        new_sidebar_menu + """                <div style="margin: 24px 20px 10px 20px; font-size: 0.75rem; color: var(--color-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    Master Data
                </div>"""
    )
    with open(sidebar_path, "w", encoding="utf-8") as f:
        f.write(sidebar_content)

print("Web backup feature added successfully!")
