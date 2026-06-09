filepath = r'c:\xampp\htdocs\EVN9\resources\views\bookings\create.blade.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

import re
match = re.search(r'guest_count:\s*\d+', content)
if match:
    found = match.group()
    content = content.replace(found, 'guest_count: 1', 1)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print('Fixed:', found, '-> guest_count: 1')
else:
    print('Not found')
