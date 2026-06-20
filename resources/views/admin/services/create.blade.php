<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.services') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center text-gray-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('Add New Service') }}</h2>
                <p class="text-gray-500 text-sm mt-1">Create a service and assign it to a vendor</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-8 text-white">
                    <h3 class="text-2xl font-bold">Create Service</h3>
                    <p class="text-indigo-100 mt-1">Admin can publish a service on behalf of any vendor.</p>
                </div>

                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-12"
                      x-data="serviceCreator()" @submit="handleSubmit($event)">
                    @csrf

                    <!-- Vendor + Core Info -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4 border-b border-gray-100 pb-4">
                            <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <h4 class="text-xl font-black text-gray-900 tracking-tight">Core Listing Details</h4>
                        </div>

                        <div>
                            <label for="user_id" class="block text-sm font-black text-gray-700 mb-3 ml-1">Assign to Vendor</label>
                            <div class="relative">
                                <select id="user_id" name="user_id" required
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold appearance-none">
                                    <option value="">Select Vendor</option>
                                    <option value="{{ auth()->id() }}" {{ old('user_id') == auth()->id() ? 'selected' : '' }}>
                                        Myself ({{ auth()->user()->name }}) — Admin Account
                                    </option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" {{ old('user_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }} ({{ $vendor->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-black text-gray-700 mb-3 ml-1">Service Title</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all text-lg font-bold placeholder-gray-300"
                                placeholder="e.g., Premium Wedding Photography">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-black text-gray-700 mb-3 ml-1">Description</label>
                            <textarea id="description" name="description" rows="5" required
                                class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-medium placeholder-gray-300"
                                placeholder="Describe the service, what's included, and what makes it unique...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="category_id" class="block text-sm font-black text-gray-700 mb-3 ml-1">Category</label>
                                <div class="relative">
                                    <select id="category_id" :name="categorySelection === '__new__' ? '' : 'category_id'" x-model="categorySelection"
                                        class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold appearance-none">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                        <option value="__new__">+ Add New Category…</option>
                                    </select>
                                    <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
                                <input type="text" x-show="categorySelection === '__new__'" x-cloak
                                    name="new_category_name" value="{{ old('new_category_name') }}" placeholder="New category name"
                                    class="w-full mt-3 px-6 py-4 bg-purple-50 border border-purple-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold">
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-black text-gray-700 mb-3 ml-1">Location</label>
                                <input type="text" id="location" name="location" value="{{ old('location') }}"
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold"
                                    placeholder="City, Area">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-black text-gray-700 mb-4 ml-1">Suitable for Event Types</label>
                            <p class="text-xs text-gray-400 font-medium mb-3 ml-1">Click a type to select it (highlighted = selected). Add custom ones using the input below.</p>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <template x-for="(item, index) in eventTypes" :key="item.name">
                                    <div @click="toggleEventType(index)"
                                        class="cursor-pointer px-4 py-3 rounded-2xl flex items-center justify-center gap-2 text-sm font-bold transition-all select-none"
                                        :class="item.selected ? 'bg-purple-50 border border-purple-200 text-purple-600' : 'bg-gray-50 border border-gray-100 text-gray-400 hover:bg-gray-100'">
                                        <i class="fa-solid fa-check text-[10px]" x-show="item.selected"></i>
                                        <input type="hidden" name="extra[event_types][]" :value="item.name" :disabled="!item.selected">
                                        <span x-text="item.name"></span>
                                    </div>
                                </template>
                            </div>
                            <div class="flex items-center gap-3 mt-4">
                                <input type="text" x-model="newEventType" @keydown.enter.prevent="addEventType()" placeholder="Add custom event type (e.g., Engagement)"
                                    class="flex-1 px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold text-sm">
                                <button type="button" @click="addEventType()" class="bg-purple-600 text-white px-5 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-purple-700 transition-all">+ Add</button>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="price" class="block text-sm font-black text-gray-700 mb-3 ml-1">Base Price (PKR)</label>
                            <input type="number" id="price" name="price" step="1" min="0" value="{{ old('price') }}" required
                                class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all text-lg font-black">
                        </div>
                        <div>
                            <label for="price_type" class="block text-sm font-black text-gray-700 mb-3 ml-1">Pricing Type</label>
                            <div class="relative">
                                <select id="price_type" name="price_type"
                                    class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold appearance-none">
                                    <option value="fixed">Fixed Rate</option>
                                    <option value="per_hour">Per Hour</option>
                                    <option value="per_event">Per Event</option>
                                    <option value="per_day">Per Day</option>
                                    <option value="per_person">Per Person</option>
                                    <option value="per_night">Per Night</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Tiered Packages -->
                    <div class="bg-indigo-50/50 rounded-[2rem] p-8 border border-indigo-100/50">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-black text-gray-900 tracking-tight">Tiered Packages <span class="text-indigo-600 text-xs ml-2 font-bold uppercase">(Optional)</span></h4>
                            <button type="button" @click="addPackage()" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all">+ Add Tier</button>
                        </div>
                        <div class="space-y-4">
                            <template x-for="(pkg, index) in packages" :key="index">
                                <div class="bg-white p-5 rounded-2xl border border-indigo-100 relative group">
                                    <button type="button" @click="removePackage(index)" class="absolute -top-3 -right-3 w-7 h-7 bg-black text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"><i class="fa-solid fa-xmark text-xs"></i></button>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <input type="text" :name="`packages[${index}][name]`" x-model="pkg.name" placeholder="Tier Name" class="px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-indigo-500 font-bold">
                                        <input type="number" :name="`packages[${index}][price]`" x-model="pkg.price" placeholder="Price" class="px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-indigo-500 font-bold">
                                        <input type="text" :name="`packages[${index}][description]`" x-model="pkg.description" placeholder="What's included?" class="px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-indigo-500 font-medium text-sm">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Add-ons -->
                    <div class="bg-rose-50/50 rounded-[2rem] p-8 border border-rose-100/50">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-black text-gray-900 tracking-tight">Service Add-ons <span class="text-rose-600 text-xs ml-2 font-bold uppercase">(Optional)</span></h4>
                            <button type="button" @click="addAddOn()" class="bg-rose-500 text-white px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all">+ Add Item</button>
                        </div>
                        <div class="space-y-4">
                            <template x-for="(addon, index) in addons" :key="index">
                                <div class="bg-white p-5 rounded-2xl border border-rose-100 relative group">
                                    <button type="button" @click="removeAddOn(index)" class="absolute -top-3 -right-3 w-7 h-7 bg-black text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"><i class="fa-solid fa-xmark text-xs"></i></button>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <input type="text" :name="`add_ons[${index}][name]`" x-model="addon.name" placeholder="Item Name" class="px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-rose-500 font-bold">
                                        <input type="number" :name="`add_ons[${index}][price]`" x-model="addon.price" placeholder="Extra Price" class="px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-rose-500 font-bold">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="space-y-10">
                        <h4 class="text-lg font-black text-gray-900 tracking-tight">Service Images</h4>

                        <!-- Featured Image -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-star text-indigo-500"></i>
                                <h5 class="text-sm font-black text-gray-800 uppercase tracking-widest">Featured Image <span class="text-gray-400 font-bold">(Main Card Image)</span></h5>
                            </div>
                            <div x-show="!featuredPreview" class="relative">
                                <input type="file" id="featured-upload" name="featured_image" accept="image/*" class="hidden" @change="handleFeaturedFile($event)">
                                <label for="featured-upload" class="block w-full rounded-[2rem] border-2 border-dashed border-indigo-200 bg-indigo-50/30 p-8 text-center transition-all hover:bg-white hover:border-indigo-400 cursor-pointer">
                                    <div class="w-14 h-14 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-star text-indigo-500 text-lg"></i>
                                    </div>
                                    <h5 class="text-base font-black text-gray-900 mb-1">Upload Featured Image</h5>
                                    <p class="text-gray-400 font-medium text-sm">This image is shown on the service card and listings.</p>
                                </label>
                            </div>
                            <div x-show="featuredPreview" class="relative w-48 aspect-square rounded-[1.5rem] overflow-hidden border-2 border-indigo-500 shadow-xl">
                                <img :src="featuredPreview" class="w-full h-full object-cover">
                                <button type="button" @click="removeFeaturedFile()" class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                <div class="absolute top-2 left-2 bg-indigo-500 text-white w-7 h-7 rounded-xl flex items-center justify-center shadow-lg"><i class="fa-solid fa-star text-xs"></i></div>
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-images text-rose-500"></i>
                                <h5 class="text-sm font-black text-gray-800 uppercase tracking-widest">Gallery Images <span class="text-gray-400 font-bold">(Optional, additional photos)</span></h5>
                            </div>
                            <div class="relative">
                                <input type="file" id="gallery-upload" accept="image/*" multiple class="hidden" @change="handleFiles($event)">
                                <label for="gallery-upload" class="block w-full rounded-[2rem] border-2 border-dashed border-gray-200 bg-gray-50/30 p-8 text-center transition-all hover:bg-white hover:border-rose-400 cursor-pointer">
                                    <div class="w-14 h-14 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-images text-rose-500 text-lg"></i>
                                    </div>
                                    <h5 class="text-base font-black text-gray-900 mb-1">Upload Gallery Images</h5>
                                    <p class="text-gray-400 font-medium text-sm">Select multiple images to show in the service gallery.</p>
                                </label>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6" x-show="previews.length > 0">
                                <template x-for="(item, index) in previews" :key="index">
                                    <div class="relative group aspect-square rounded-[1.5rem] overflow-hidden border-2 border-gray-100">
                                        <img :src="item.url" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex justify-end p-3">
                                            <button type="button" @click="removeImage(index)" class="w-8 h-8 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div class="pt-8 border-t border-gray-100 flex items-center justify-between gap-6">
                        <a href="{{ route('admin.services') }}" class="text-gray-400 hover:text-gray-900 font-black tracking-widest uppercase text-xs transition-colors">Cancel</a>
                        <button type="submit" :disabled="submitting"
                            class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-black rounded-[1.5rem] shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-3 disabled:opacity-70">
                            <span x-show="!submitting" class="flex items-center gap-3">Create Service <i class="fa-solid fa-check"></i></span>
                            <span x-show="submitting" class="flex items-center gap-3">Saving... <i class="fa-solid fa-circle-notch animate-spin"></i></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function serviceCreator() {
            return {
                submitting: false,
                previews: [],
                dataTransfer: new DataTransfer(),
                featuredPreview: null,
                featuredFile: null,
                packages: [],
                addons: [],
                categorySelection: '{{ old('category_id') }}',
                eventTypes: (function () {
                    const defaults = ['Wedding', 'Corporate', 'Birthday', 'Party', 'Travel', 'General'];
                    const selected = {!! json_encode(old('extra.event_types', [])) !!};
                    const list = defaults.map(name => ({ name, selected: selected.includes(name) }));
                    selected.forEach(name => {
                        if (!defaults.includes(name)) list.push({ name, selected: true });
                    });
                    return list;
                })(),
                newEventType: '',

                addPackage() { this.packages.push({ name: '', price: '', description: '' }); },
                removePackage(index) { this.packages.splice(index, 1); },
                addAddOn() { this.addons.push({ name: '', price: '' }); },
                removeAddOn(index) { this.addons.splice(index, 1); },

                addEventType() {
                    const type = this.newEventType.trim();
                    if (type && !this.eventTypes.some(t => t.name.toLowerCase() === type.toLowerCase())) {
                        this.eventTypes.push({ name: type, selected: true });
                    }
                    this.newEventType = '';
                },
                toggleEventType(index) { this.eventTypes[index].selected = !this.eventTypes[index].selected; },
                removeEventType(index) { this.eventTypes.splice(index, 1); },

                handleFeaturedFile(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    this.featuredFile = file;
                    this.featuredPreview = URL.createObjectURL(file);
                },
                removeFeaturedFile() {
                    if (this.featuredPreview) URL.revokeObjectURL(this.featuredPreview);
                    this.featuredPreview = null;
                    this.featuredFile = null;
                    document.getElementById('featured-upload').value = '';
                },

                handleFiles(event) {
                    const files = Array.from(event.target.files);
                    files.forEach(file => {
                        this.dataTransfer.items.add(file);
                        this.previews.push({ file, url: URL.createObjectURL(file) });
                    });
                    event.target.value = '';
                },
                removeImage(index) {
                    const item = this.previews[index];
                    if (item.url) URL.revokeObjectURL(item.url);
                    this.previews.splice(index, 1);
                    const newDT = new DataTransfer();
                    this.previews.forEach(p => newDT.items.add(p.file));
                    this.dataTransfer = newDT;
                },

                handleSubmit(event) {
                    this.submitting = true;
                    const form = event.target;
                    const finalInput = document.createElement('input');
                    finalInput.type = 'file';
                    finalInput.name = 'images[]';
                    finalInput.multiple = true;
                    finalInput.files = this.dataTransfer.files;
                    finalInput.style.display = 'none';
                    form.appendChild(finalInput);
                }
            }
        }
    </script>
</x-app-layout>
