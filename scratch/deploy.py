import paramiko

hostname = '145.79.14.233'
port = 65002
username = 'u674511048'
password = '!FarizAhmad123456'

def execute_command(ssh, command):
    print(f"Executing: {command}")
    stdin, stdout, stderr = ssh.exec_command(command)
    output = stdout.read().decode('utf-8')
    error = stderr.read().decode('utf-8')
    if output: print(output)
    if error: print("ERROR:", error)

try:
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(hostname, port, username, password)
    
    target_dir = "/home/u674511048/domains/farizahmad.com/public_html/managementasset"
    
    commands = f"""
    cd {target_dir}
    git fetch --all
    git reset --hard origin/farizahmad.github.io
    php artisan view:clear
    php artisan cache:clear
    php artisan config:clear
    """
    
    execute_command(ssh, commands)
    print("Deployment to managementasset completed successfully!")

except Exception as e:
    print(f"Connection failed: {str(e)}")
finally:
    ssh.close()
