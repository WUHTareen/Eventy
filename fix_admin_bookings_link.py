#!/usr/bin/env python3
# Adds an "All Bookings" link button to the admin dashboard header.
import sys

PATH = "resources/views/admin/dashboard.blade.php"

OLD = '''            <div class="flex items-center gap-3">
                <a href="{{ route('admin.custom-packages') }}" class="flex items-center gap-2 bg-[#0A3A7A] text-white px-4 py-2 rounded-xl border border-[#0A3A7A] hover:bg-[#0D4E9A] transition-colors shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-layer-group text-yellow-400"></i>
                    <span class="font-bold text-sm">Custom Ensembles</span>
                </a>'''

NEW = '''            <div class="flex items-center gap-3">
                <a href="{{ route('admin.bookings') }}" class="flex items-center gap-2 bg-[#0A3A7A] text-white px-4 py-2 rounded-xl border border-[#0A3A7A] hover:bg-[#0D4E9A] transition-colors shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-calendar-check text-yellow-400"></i>
                    <span class="font-bold text-sm">All Bookings</span>
                </a>
                <a href="{{ route('admin.custom-packages') }}" class="flex items-center gap-2 bg-[#0A3A7A] text-white px-4 py-2 rounded-xl border border-[#0A3A7A] hover:bg-[#0D4E9A] transition-colors shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-layer-group text-yellow-400"></i>
                    <span class="font-bold text-sm">Custom Ensembles</span>
                </a>'''

with open(PATH, "r", encoding="utf-8") as f:
    content = f.read()

if 'route(\'admin.bookings\')' in content:
    print("ALREADY PATCHED: 'All Bookings' link already present. Nothing to do.")
    sys.exit(0)

if OLD not in content:
    print("ERROR: expected block not found. File may have changed. No edits made.")
    sys.exit(1)

content = content.replace(OLD, NEW, 1)

with open(PATH, "w", encoding="utf-8") as f:
    f.write(content)

print("SUCCESS: admin dashboard 'All Bookings' link added.")
