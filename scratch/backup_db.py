import paramiko
import time
import os
from datetime import datetime

# ==== PENGATURAN SERVER ====
hostname = '145.79.14.233'
port = 65002
username = 'u674511048'
password = '!FarizAhmad123456'

target_dir = "/home/u674511048/domains/farizahmad.com/public_html/managementasset"

# Tempat menyimpan file backup di laptop Anda
# Default akan disimpan di folder yang sama dengan script ini
local_backup_dir = os.path.dirname(os.path.abspath(__file__))

def execute_command(ssh, command):
    stdin, stdout, stderr = ssh.exec_command(command)
    output = stdout.read().decode('utf-8')
    error = stderr.read().decode('utf-8')
    return output, error

try:
    print("Mencoba terhubung ke server SSH...")
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(hostname, port, username, password)
    print("Berhasil login ke server!\n")
    
    print("1. Mengambil kredensial database dari file .env di server...")
    # Baca file .env untuk mendapatkan kredensial DB
    env_output, _ = execute_command(ssh, f"cat {target_dir}/.env | grep -E '^DB_(DATABASE|USERNAME|PASSWORD)='")
    
    db_name = ""
    db_user = ""
    db_pass = ""
    
    for line in env_output.splitlines():
        if line.startswith('DB_DATABASE='): db_name = line.split('=')[1].strip()
        if line.startswith('DB_USERNAME='): db_user = line.split('=')[1].strip()
        if line.startswith('DB_PASSWORD='): db_pass = line.split('=')[1].strip()
        
    if not db_name or not db_user:
        raise Exception("Gagal membaca kredensial database dari .env")
        
    print(f"   Database ditemukan: {db_name}")
    
    # Generate nama file backup
    timestamp = datetime.now().strftime('%Y-%m-%d_%H-%M-%S')
    remote_backup_path = f"/home/u674511048/backup_{db_name}_{timestamp}.sql"
    local_backup_path = os.path.join(local_backup_dir, f"backup_{db_name}_{timestamp}.sql")
    
    print(f"\n2. Membuat backup database di server (harap tunggu)...")
    # Jalankan mysqldump
    dump_cmd = f"mysqldump -u {db_user} -p'{db_pass}' {db_name} > {remote_backup_path}"
    out, err = execute_command(ssh, dump_cmd)
    
    if err and "Warning: Using a password on the command line interface can be insecure" not in err:
        print("   Info dari mysqldump:", err.strip())
        
    print("   Backup berhasil dibuat di server.")
    
    print(f"\n3. Mengunduh file backup ke laptop Anda (SFTP)...")
    sftp = ssh.open_sftp()
    sftp.get(remote_backup_path, local_backup_path)
    sftp.close()
    print(f"   Berhasil diunduh! File tersimpan di: {local_backup_path}")
    
    print(f"\n4. Menghapus file backup sementara di server untuk menghemat ruang...")
    execute_command(ssh, f"rm {remote_backup_path}")
    print("   Pembersihan selesai.")
    
    print("\n✅ PROSES BACKUP DATABASE SELESAI!")

except Exception as e:
    print(f"Terjadi kesalahan: {str(e)}")
finally:
    ssh.close()
