filepath = r'c:\xampp\htdocs\EVN9\resources\views\bookings\create.blade.php'
with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

old = 'x-show="form.duration_days > 1 || (isLodging && form.duration_days)) && (isTransport || isLodging || isVendor || isMega)"'
new = 'x-show="(form.duration_days > 1 || (isLodging && form.duration_days)) && (isTransport || isLodging || isVendor || isMega)"'

if old in content:
    content = content.replace(old, new)
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print('Fixed successfully!')
else:
    print('Pattern not found - checking manually...')
    idx = content.find('form.duration_days > 1')
    if idx != -1:
        print(repr(content[max(0,idx-20):idx+120]))
