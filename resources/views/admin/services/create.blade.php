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
                                    <select id="category_id" name="category_id"
                                        class="w-full px-6 py-4 bg-gray-50 border border-gray-100 rounded-[1.5rem] focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold appearance-none">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                                </div>
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
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach(['Wedding', 'Corporate', 'Birthday', 'Party', 'Travel', 'General'] as $type)
                                    <label class="cursor-pointer group">
                                        <input type="checkbox" name="extra[event_types][]" value="{{ $type }}" class="peer sr-only">
                                        <div class="px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center text-sm font-bold text-gray-500 peer-checked:bg-purple-50 peer-checked:text-purple-600 peer-checked:border-purple-200 transition-all group-hover:bg-gray-100">
                                            {{ $type }}
                                        </div>
                                    </label>
                                @endforeach
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
                    <div class="space-y-6">
                        <h4 class="text-lg font-black text-gray-900 tracking-tight">Service Images</h4>
                        <div class="relative">
                            <input type="file" id="image-upload" accept="image/*" multiple class="hidden" @change="handleFiles($event)">
                            <label for="image-upload" class="block w-full rounded-[2rem] border-2 border-dashed border-gray-200 bg-gray-50/30 p-10 text-center transition-all hover:bg-white hover:border-indigo-400 cursor-pointer">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-lg flex items-center justify-center mx-auto mb-4">
                                    <i class="fa-solid fa-images text-indigo-500 text-xl"></i>
                                </div>
                                <h5 class="text-lg font-black text-gray-900 mb-1">Upload Gallery Images</h5>
                                <p class="text-gray-400 font-medium text-sm">Select multiple images. Choose one as the featured (main card) image.</p>
                            </label>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6" x-show="previews.length > 0">
                            <template x-for="(item, index) in previews" :key="index">
                                <div class="relative group aspect-square rounded-[1.5rem] overflow-hidden border-2"
                                     :class="featuredIndex === index ? 'border-indigo-500 shadow-xl' : 'border-gray-100'">
                                    <img :src="item.url" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-3">
                                        <div class="flex justify-end">
                                            <button type="button" @click="removeImage(index)" class="w-8 h-8 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                        </div>
                                        <button type="button" @click="setFeatured(index)"
                                                class="w-full py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
                                                :class="featuredIndex === index ? 'bg-indigo-500 text-white' : 'bg-white text-gray-900 hover:bg-indigo-50'">
                                            <span x-text="featuredIndex === index ? 'Featured' : 'Set Featured'"></span>
                                        </button>
                                    </div>
                                    <div x-show="featuredIndex === index" class="absolute top-3 left-3 bg-indigo-500 text-white w-7 h-7 rounded-xl flex items-center justify-center shadow-lg"><i class="fa-solid fa-star text-xs"></i></div>
                                </div>
                            </template>
                        </div>
                        <input type="hidden" name="featured_image_index" :value="featuredIndex">
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
                featuredIndex: 0,
                dataTransfer: new DataTransfer(),
                packages: [],
                addons: [],

                addPackage() { this.packages.push({ name: '', price: '', description: '' }); },
                removePackage(index) { this.packages.splice(index, 1); },
                addAddOn() { this.addons.push({ name: '', price: '' }); },
                removeAddOn(index) { this.addons.splice(index, 1); },

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
                    if (this.featuredIndex === index) this.featuredIndex = 0;
                    else if (this.featuredIndex > index) this.featuredIndex--;
                },
                setFeatured(index) { this.featuredIndex = index; },

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
