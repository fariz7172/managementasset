import json
import re
import os

log_file = r"C:\Users\Fariz\.gemini\antigravity-ide\brain\eb5f8cb6-9284-44ac-ba8d-78898f4601be\.system_generated\logs\transcript_full.jsonl"
out_file = r"d:\program file\Project Kantor\System-sudin-jakarta-utara\resources\views\welcome.blade.php"

content_str = None
with open(log_file, 'r', encoding='utf-8') as f:
    for line in f:
        data = json.loads(line)
        if data.get('step_index') == 9 and data.get('type') == 'VIEW_FILE':
            content_str = data.get('content')
            break

if content_str:
    # content_str contains line numbers like "1: <?php\n2: ..."
    # We need to extract just the lines.
    lines = content_str.split('\n')
    
    # Find where the actual file content starts (after "The following code has been modified...")
    start_idx = 0
    for i, l in enumerate(lines):
        if "The following code has been modified to include a line number" in l:
            start_idx = i + 1
            break
            
    # Find where it ends ("The above content shows the entire, complete file contents of the requested file.")
    end_idx = len(lines)
    for i, l in enumerate(lines):
        if "The above content shows the entire, complete file contents" in l:
            end_idx = i
            break
            
    file_lines = lines[start_idx:end_idx]
    
    # Remove the "line_number: " prefix
    cleaned_lines = []
    for l in file_lines:
        # Regex to match "^[0-9]+: "
        match = re.match(r'^\d+: (.*)', l)
        if match:
            cleaned_lines.append(match.group(1))
        else:
            cleaned_lines.append(l) # fallback
            
    with open(out_file, 'w', encoding='utf-8') as f:
        f.write('\n'.join(cleaned_lines))
    print("File recovered successfully!")
else:
    print("Could not find step 9.")
