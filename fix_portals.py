
import os

file_path = r'c:\xampp\htdocs\EVN9\resources\views\welcome.blade.php'
tmp_portals = r'c:\xampp\htdocs\EVN9\portals_tmp.txt'

with open(tmp_portals, 'r', encoding='utf-8') as f:
    portals_content = f.read()

# Try reading with different encodings
encodings = ['utf-8', 'windows-1252', 'latin-1']
content = None
for enc in encodings:
    try:
        with open(file_path, 'r', encoding=enc) as f:
            content = f.read()
        print(f"Success with {enc}")
        break
    except Exception as e:
        print(f"Failed with {enc}: {e}")

if content:
    target = '<!-- Search Section -->'
    if target in content:
        new_content = content.replace(target, portals_content + '\n' + target)
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print("Replacement successful")
    else:
        print("Target not found")
else:
    print("Could not read file")
