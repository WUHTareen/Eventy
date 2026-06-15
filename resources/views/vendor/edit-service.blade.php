<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('vendor.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center text-gray-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    {{ __('Edit Service') }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Update your service details</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-primary-500 to-indigo-600 px-8 py-10 text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-4 backdrop-blur-sm">
                            <i class="fa-solid fa-pen-to-square text-3xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold">Edit: {{ $service->name }}</h3>
                        <p class="text-blue-100 mt-2">Make changes to your service listing</p>
                    </div>
                </div>

                <!-- Form Body -->
                <form action="{{ route('vendor.update-service', $service) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8"
                      x-data="serviceEditor({ 
                          existing: {{ json_encode($service->images ?? ($service->image ? [$service->image] : [])) }},
                          featured: {{ $service->featured_image_index ?? 0 }},
                          storage_url: '{{ asset('storage') }}',
                          packages: {{ json_encode($service->packages ?? []) }},
                          addons: {{ json_encode($service->add_ons ?? []) }}
                      })" @submit="handleSubmit($event)">
                    @csrf
                    @method('PUT')
                    
                    <!-- Service Title -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fa-solid fa-heading text-indigo-500 mr-2"></i>Service Name
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}"
                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:border-transparent transition-all text-lg placeholder-gray-400"
                            placeholder="e.g., Professional Home Cleaning Service" required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div x-data="{ isOptimizing: false }">
                        <div class="flex justify-between items-center mb-2">
                            <label for="description" class="block text-sm font-bold text-gray-700">
                                <i class="fa-solid fa-align-left text-indigo-500 mr-2"></i>Description
                            </label>
                            <button type="button" @click="optimizeWithAI" 
                                    class="text-[10px] font-black uppercase tracking-widest px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-all flex items-center gap-2 border border-indigo-100"
                                    :disabled="isOptimizing">
                                <i class="fa-solid fa-wand-magic-sparkles" :class="{ 'animate-pulse': isOptimizing }"></i>
                                <span x-text="isOptimizing ? 'AI OPTIMIZING...' : 'AI ASSIST'"></span>
                            </button>
                        </div>
                        <textarea id="description" name="description" rows="5" x-ref="descriptionField"
                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:bg-white focus:border-transparent transition-all placeholder-gray-400"
                            placeholder="Describe your service..." required>{{ old('description', $service->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                        </div>
                    </div>

                    <!-- Pricing Section (Enhanced) -->
                    <div class="space-y-12">
                        <div class="bg-gray-900 rounded-[2.5rem] p-8 md:p-12 text-white relative overflow-hidden shadow-2xl">
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
                            <div class="relative space-y-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center text-primary-400 backdrop-blur-md">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <h4 class="text-xl font-black tracking-tight">Financial Model</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label for="price" class="block text-sm font-black text-gray-400 mb-3 ml-1">Base Price (PKR)</label>
                                        <div class="relative">
                                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-primary-500 font-black">Rs.</span>
                                            <input type="number" id="price" name="price" step="1" min="0" value="{{ old('price', $service->price) }}"
                                                class="w-full pl-16 pr-6 py-5 bg-white/5 border border-white/10 rounded-[1.5rem] focus:ring-4 focus:ring-primary-500/20 focus:bg-white/10 focus:border-primary-500 transition-all text-2xl font-black text-white" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="price_type" class="block text-sm font-black text-gray-400 mb-3 ml-1">Pricing Logic</label>
                                        <div class="relative">
                                            <select id="price_type" name="price_type"
                                                class="w-full px-6 py-5 bg-white/5 border border-white/10 rounded-[1.5rem] focus:ring-4 focus:ring-primary-500/20 focus:bg-white/10 focus:border-primary-500 transition-all font-black text-white appearance-none">
                                                <option value="fixed" {{ old('price_type', $service->price_type) == 'fixed' ? 'selected' : '' }}>Fixed Rate</option>
                                                <option value="per_hour" {{ old('price_type', $service->price_type) == 'per_hour' ? 'selected' : '' }}>Hourly Rate</option>
                                                <option value="per_event" {{ old('price_type', $service->price_type) == 'per_event' ? 'selected' : '' }}>Event Based</option>
                                                <option value="per_night" {{ old('price_type', $service->price_type) == 'per_night' ? 'selected' : '' }}>Per Night</option>
                                                <option value="per_person" {{ old('price_type', $service->price_type) == 'per_person' ? 'selected' : '' }}>Per Person</option>
                                            </select>
                                            <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tiered Packages Section -->
                        <div class="bg-indigo-50/50 rounded-[2.5rem] p-8 md:p-12 border border-indigo-100/50">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </div>
                                    <h4 class="text-xl font-black text-gray-900 tracking-tight">Tiered Packages <span class="text-indigo-600 text-sm ml-2 font-bold uppercase">(Optional)</span></h4>
                                </div>
                                <button type="button" @click="addPackage()" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                                    + Add Tier
                                </button>
                            </div>

                            <div class="space-y-6">
                                <template x-for="(pkg, index) in packages" :key="index">
                                    <div class="bg-white p-6 rounded-3xl border border-indigo-100 shadow-sm relative group">
                                        <button type="button" @click="removePackage(index)" class="absolute -top-3 -right-3 w-8 h-8 bg-black text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <div class="md:col-span-1">
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tier Name</label>
                                                <input type="text" :name="`packages[${index}][name]`" x-model="pkg.name" placeholder="e.g., Gold Package" 
                                                    class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-indigo-500 transition-all font-bold">
                                            </div>
                                            <div class="md:col-span-1">
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Price (PKR)</label>
                                                <input type="number" :name="`packages[${index}][price]`" x-model="pkg.price" placeholder="Price" 
                                                    class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-indigo-500 transition-all font-bold">
                                            </div>
                                            <div class="md:col-span-1">
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Description</label>
                                                <input type="text" :name="`packages[${index}][description]`" x-model="pkg.description" placeholder="What's included?" 
                                                    class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-indigo-500 transition-all font-medium text-sm">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Service Add-ons Section -->
                        <div class="bg-rose-50/50 rounded-[2.5rem] p-8 md:p-12 border border-rose-100/50">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-rose-500 rounded-xl flex items-center justify-center text-white">
                                        <i class="fa-solid fa-plus-circle"></i>
                                    </div>
                                    <h4 class="text-xl font-black text-gray-900 tracking-tight">Service Add-ons <span class="text-rose-600 text-sm ml-2 font-bold uppercase">(Upsell)</span></h4>
                                </div>
                                <button type="button" @click="addAddOn()" class="bg-rose-500 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-600 transition-all shadow-lg shadow-rose-200">
                                    + Add Item
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(addon, index) in addons" :key="index">
                                    <div class="bg-white p-6 rounded-3xl border border-rose-100 shadow-sm relative group">
                                        <button type="button" @click="removeAddOn(index)" class="absolute -top-3 -right-3 w-8 h-8 bg-black text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                            <i class="fa-solid fa-xmark text-xs"></i>
                                        </button>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Item Name</label>
                                                <input type="text" :name="`add_ons[${index}][name]`" x-model="addon.name" placeholder="e.g., Drone Shots" 
                                                    class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-rose-500 transition-all font-bold">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Extra Price (PKR)</label>
                                                <input type="number" :name="`add_ons[${index}][price]`" x-model="addon.price" placeholder="Extra charge" 
                                                    class="w-full px-4 py-3 bg-gray-50 border border-transparent rounded-xl focus:border-rose-500 transition-all font-bold">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                    <!-- Event Suitability -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-4 ml-1">
                            <i class="fa-solid fa-list-check text-indigo-500 mr-2"></i>Suitable for Event Types
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach(['Wedding', 'Corporate', 'Birthday', 'Party', 'Travel', 'General'] as $type)
                                <label class="cursor-pointer group">
                                    <input type="checkbox" name="extra[event_types][]" value="{{ $type }}" 
                                           class="peer sr-only"
                                           {{ in_array($type, $service->extra_data['event_types'] ?? []) ? 'checked' : '' }}>
                                    <div class="px-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl flex items-center justify-center text-sm font-bold text-gray-500 peer-checked:bg-purple-50 peer-checked:text-purple-600 peer-checked:border-purple-200 transition-all group-hover:bg-gray-100">
                                        {{ $type }}
                                    </div>
                                </label>
                            @endforeach
                        </div>

                    <!-- Visual Assets Section -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between border-b border-gray-50 pb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-images"></i>
                                </div>
                                <h4 class="text-xl font-black text-gray-900 tracking-tight">Media Portfolio Management</h4>
                            </div>
                            <button type="button" @click="suggestImageIdeas"
                                    class="text-[10px] font-black uppercase tracking-widest px-4 py-2 bg-purple-50 text-purple-600 rounded-xl hover:bg-purple-100 transition-all flex items-center gap-2 border border-purple-100"
                                    :disabled="isGettingSuggestions">
                                <i class="fa-solid fa-lightbulb" :class="{ 'animate-yellow-pulse': isGettingSuggestions }"></i>
                                <span x-text="isGettingSuggestions ? 'ANALYZING...' : 'AI PHOTO IDEAS'"></span>
                            </button>
                        </div>

                        <!-- AI Suggestions Modal/Box -->
                        <div x-show="imageSuggestions" x-transition class="bg-indigo-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-2xl mt-4">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-3">
                                        <i class="fa-solid fa-wand-magic-sparkles text-indigo-400"></i>
                                        <h5 class="text-sm font-black uppercase tracking-[0.2em]">AI Creative Suggestions</h5>
                                    </div>
                                    <button type="button" @click="imageSuggestions = null" class="text-white/50 hover:text-white transition-colors">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                <div class="prose prose-invert prose-sm max-w-none text-indigo-100 font-medium ai-suggestions-list" x-html="imageSuggestions"></div>
                            </div>
                        </div>
                        
                        <!-- Main Upload Zone -->
                        <div class="relative group/upload cursor-pointer">
                            <input type="file" id="image-upload" accept="image/*" multiple class="hidden" @change="handleNewFiles($event)">
                            <label for="image-upload" class="block relative z-10 w-full rounded-[2.5rem] border-2 border-dashed border-gray-200 bg-gray-50/30 p-12 text-center transition-all hover:bg-white hover:border-indigo-400 cursor-pointer">
                                <div class="w-20 h-20 bg-white rounded-3xl shadow-xl flex items-center justify-center mx-auto mb-6 group-hover/upload:scale-110 transition-transform">
                                    <i class="fa-solid fa-cloud-arrow-up text-indigo-500 text-2xl"></i>
                                </div>
                                <h5 class="text-lg font-black text-gray-900 mb-2">Append New Visuals</h5>
                                <p class="text-gray-400 text-sm font-medium">Add more images to your gallery. Your previous images are preserved below.</p>
                            </label>
                        </div>

                        <!-- Image Management Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                            <!-- Existing Images -->
                            <template x-for="(img, index) in existingImages" :key="'existing-'+index">
                                <div class="relative group aspect-square rounded-[2rem] overflow-hidden border-2 transition-all duration-500" 
                                     :class="[
                                        featuredIndex === index ? 'border-primary-500 shadow-xl shadow-primary-500/10' : 'border-gray-100',
                                        removedIndices.includes(index) ? 'opacity-20 grayscale scale-90' : 'opacity-100'
                                     ]">
                                    
                                    <img :src="storageUrl + '/' + img" class="w-full h-full object-cover">
                                    
                                    <!-- Management Overlay -->
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-3" x-show="!removedIndices.includes(index)">
                                        <div class="flex justify-end">
                                            <button type="button" @click="toggleRemove(index)" class="w-8 h-8 bg-black/50 hover:bg-red-500 text-white rounded-lg flex items-center justify-center transition-all">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </div>
                                        <button type="button" @click="setFeatured(index)" 
                                                class="w-full py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
                                                :class="featuredIndex === index ? 'bg-primary-500 text-white' : 'bg-white text-gray-900 hover:bg-indigo-50'">
                                            <span x-text="featuredIndex === index ? '? Featured' : 'Set Featured'"></span>
                                        </button>
                                    </div>

                                    <!-- Removal Alert -->
                                    <div x-show="removedIndices.includes(index)" class="absolute inset-0 flex items-center justify-center bg-red-500/10 backdrop-blur-[1px]">
                                        <button type="button" @click="toggleRemove(index)" class="bg-white text-red-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-tight shadow-lg">
                                            Restore
                                        </button>
                                    </div>

                                    <!-- Featured Badge -->
                                    <div x-show="featuredIndex === index && !removedIndices.includes(index)" class="absolute top-3 left-3 bg-primary-500 text-white w-7 h-7 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fa-solid fa-star text-xs"></i>
                                    </div>
                                    
                                    <!-- Hidden input for removed images -->
                                    <template x-if="removedIndices.includes(index)">
                                        <input type="hidden" name="removed_indices[]" :value="index">
                                    </template>
                                </div>
                            </template>

                            <!-- New Previews -->
                            <template x-for="(preview, idx) in previews" :key="'new-'+idx">
                                <div class="relative group aspect-square rounded-[2rem] overflow-hidden border-2 border-indigo-200">
                                    <img :src="preview.url" class="w-full h-full object-cover text-xs" alt="Preview">
                                    <div class="absolute inset-0 bg-black/40 flex flex-col justify-between p-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <div class="flex justify-end">
                                            <button type="button" @click="removeNewImage(idx)" class="w-8 h-8 bg-red-500 text-white rounded-lg flex items-center justify-center">
                                                <i class="fa-solid fa-times text-xs"></i>
                                            </button>
                                        </div>
                                        <div class="bg-indigo-500 text-white text-[10px] font-black text-center py-2 rounded-xl uppercase tracking-widest">New Upload</div>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Hidden featured index input -->
                        <input type="hidden" name="featured_image_index" :value="featuredIndex">
                        
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    </div>

                    <!-- Hidden container for actual files -->
                    <div class="hidden" id="file-container"></div>

                    <!-- Submit Button -->
                    <div class="pt-8 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ route('vendor.dashboard') }}" class="text-gray-400 hover:text-gray-700 font-black uppercase tracking-[0.2em] text-[10px] transition-colors">
                            Discard Changes
                        </a>
                        <button type="submit" :disabled="submitting"
                                class="bg-gradient-to-r from-primary-600 to-indigo-600 hover:from-primary-700 hover:to-indigo-700 text-white font-black py-4 px-12 rounded-[1.5rem] shadow-xl shadow-primary-500/20 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center gap-3 text-lg disabled:opacity-70 disabled:grayscale">
                            <span x-show="!submitting" class="flex items-center gap-2">Save Changes <i class="fa-solid fa-save"></i></span>
                            <span x-show="submitting" class="flex items-center gap-2">Syncing Data... <i class="fa-solid fa-circle-notch animate-spin"></i></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Service -->
            <div class="mt-12 bg-white rounded-[2.5rem] p-8 border border-red-50 shadow-sm overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-red-50/50 rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-700"></div>
                <div class="flex flex-col md:flex-row items-center justify-between gap-6 relative">
                    <div class="text-center md:text-left">
                        <h4 class="font-black text-red-900 uppercase tracking-widest text-sm mb-1">Permanent Removal</h4>
                        <p class="text-gray-500 text-xs">Careful: All bookings and gallery data for this service will be wiped.</p>
                    </div>
                    <form action="{{ route('vendor.destroy-service', $service) }}" method="POST" onsubmit="return confirm('?? IRREVERSIBLE ACTION: Are you absolutely sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-black py-4 px-8 rounded-2xl transition-all flex items-center gap-2 text-xs uppercase tracking-widest shadow-sm">
                            <i class="fa-solid fa-trash-can"></i> Terminate Service
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function serviceEditor(data) {
            return {
                submitting: false,
                existingImages: data.existing,
                removedIndices: [],
                previews: [], // Array of {file, url}
                featuredIndex: data.featured,
                storageUrl: data.storage_url,
                packages: data.packages,
                addons: data.addons,
                dataTransfer: new DataTransfer(),
                isOptimizing: false,
                isGettingSuggestions: false,
                imageSuggestions: null,

                suggestImageIdeas() {
                    const name = document.getElementById('name').value;
                    const catSelect = document.getElementById('category_id');
                    const category = catSelect.options[catSelect.selectedIndex].text;

                    if (!name || catSelect.selectedIndex === 0 || catSelect.value === "") {
                        alert('Please enter a service title and select a category first.');
                        return;
                    }

                    this.isGettingSuggestions = true;
                    this.imageSuggestions = null;
                    
                    fetch('{{ route("ai.suggest-images") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name, category })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.imageSuggestions = data.suggestions;
                        } else {
                            alert(data.message || 'AI Suggestions failed.');
                        }
                    })
                    .catch(e => {
                        alert('An error occurred during AI analysis.');
                    })
                    .finally(() => {
                        this.isGettingSuggestions = false;
                    });
                },

                optimizeWithAI() {
                    const name = document.getElementById('name').value;
                    const catSelect = document.getElementById('category_id');
                    const category = catSelect.options[catSelect.selectedIndex].text;
                    const description = this.$refs.descriptionField.value;

                    if (!name || catSelect.selectedIndex === 0 || catSelect.value === "") {
                        alert('Please enter a service title and select a category first.');
                        return;
                    }

                    this.isOptimizing = true;
                    
                    fetch('{{ route("ai.optimize-description") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ name, category, description })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.$refs.descriptionField.value = data.optimized_text;
                        } else {
                            alert(data.message || 'AI Optimization failed.');
                        }
                    })
                    .catch(e => {
                        alert('An error occurred during AI optimization.');
                    })
                    .finally(() => {
                        this.isOptimizing = false;
                    });
                },

                addPackage() {
                    this.packages.push({ name: '', price: '', description: '' });
                },

                removePackage(index) {
                    this.packages.splice(index, 1);
                },

                addAddOn() {
                    this.addons.push({ name: '', price: '' });
                },

                removeAddOn(index) {
                    this.addons.splice(index, 1);
                },
                
                handleNewFiles(event) {
                    const files = Array.from(event.target.files);
                    files.forEach(file => {
                        this.dataTransfer.items.add(file);
                        const url = URL.createObjectURL(file);
                        this.previews.push({ file, url });
                    });
                    // Reset input so change triggers again for same files
                    event.target.value = '';
                },
                
                removeNewImage(index) {
                    const item = this.previews[index];
                    if (item.url) URL.revokeObjectURL(item.url);
                    
                    this.previews.splice(index, 1);
                    
                    // Rebuild DataTransfer
                    const newDT = new DataTransfer();
                    this.previews.forEach(p => newDT.items.add(p.file));
                    this.dataTransfer = newDT;
                },
                
                toggleRemove(index) {
                    if (this.removedIndices.includes(index)) {
                        this.removedIndices = this.removedIndices.filter(i => i !== index);
                    } else {
                        this.removedIndices.push(index);
                        if (this.featuredIndex === index) {
                            this.featuredIndex = 0;
                        }
                    }
                },
                
                setFeatured(index) {
                    this.featuredIndex = index;
                },

                handleSubmit(event) {
                    this.submitting = true;
                    
                    // Manually append the files to the form before submission
                    // We need a named input to match Laravel's expected field
                    const form = event.target;
                    
                    // Create multiple hidden file inputs or use a single one
                    // The easiest: put the files back into a dynamic input
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

