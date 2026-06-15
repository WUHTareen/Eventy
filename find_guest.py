filepath = r'c:\xampp\htdocs\EVN9\resources\views\bookings\create.blade.php'
with open(filepath, 'r', encoding='utf-8') as f:
    lines = f.readlines()

for i, line in enumerate(lines, 1):
    if 'guest_count' in line:
        print(f'Line {i}: {repr(line.strip())}')
