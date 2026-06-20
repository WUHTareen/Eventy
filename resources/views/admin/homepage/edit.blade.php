<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 rounded-xl flex items-center justify-center text-gray-600 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight"><i class="fa-solid fa-house-laptop text-indigo-600 mr-2"></i>{{ __('Homepage Content') }}</h2>
                <p class="text-gray-500 text-sm mt-1">Control the hero, sections, steps and visibility of your landing page</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gradient-to-b from-gray-50 to-white min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('admin.testimonials.index') }}" class="bg-white border border-gray-200 hover:border-indigo-300 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-comment-dots text-indigo-500"></i> Manage Testimonials
                </a>
                <a href="{{ route('admin.features.index') }}" class="bg-white border border-gray-200 hover:border-indigo-300 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-star text-amber-500"></i> Manage Feature Cards
                </a>
                <a href="{{ route('admin.settings.index') }}" class="bg-white border border-gray-200 hover:border-indigo-300 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-gear text-gray-500"></i> Site Settings
                </a>
                <a href="{{ route('home') }}" target="_blank" class="bg-white border border-gray-200 hover:border-indigo-300 text-gray-700 font-bold py-2.5 px-5 rounded-xl transition-all flex items-center gap-2 text-sm">
                    <i class="fa-solid fa-up-right-from-square text-green-600"></i> Preview Homepage
                </a>
            </div>

            <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data"
                  x-data="homepageEditor()" class="space-y-8">
                @csrf

                @php
                    $labelCls = 'block text-sm font-black text-gray-700 mb-2 ml-1';
                    $inputCls = 'w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:bg-white focus:border-indigo-500 transition-all font-bold';
                @endphp

                <!-- HERO -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-6 text-white">
                        <h3 class="text-xl font-bold"><i class="fa-solid fa-bolt mr-2"></i>Hero Section</h3>
                        <p class="text-indigo-100 text-sm mt-1">The top banner of the homepage.</p>
                    </div>
                    <div class="p-8 space-y-6">
                        <div>
                            <label class="{{ $labelCls }}">Badge Text</label>
                            <input type="text" name="hp_hero_badge" value="{{ old('hp_hero_badge', $hp['hp_hero_badge']) }}" class="{{ $inputCls }}">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="{{ $labelCls }}">Heading Line 1</label>
                                <input type="text" name="hp_hero_title_1" value="{{ old('hp_hero_title_1', $hp['hp_hero_title_1']) }}" class="{{ $inputCls }}">
                            </div>
                            <div>
                                <label class="{{ $labelCls }}">Heading Line 2 (highlighted)</label>
                                <input type="text" name="hp_hero_title_2" value="{{ old('hp_hero_title_2', $hp['hp_hero_title_2']) }}" class="{{ $inputCls }}">
                            </div>
                            <div>
                                <label class="{{ $labelCls }}">Heading Line 3 (highlighted)</label>
                                <input type="text" name="hp_hero_title_3" value="{{ old('hp_hero_title_3', $hp['hp_hero_title_3']) }}" class="{{ $inputCls }}">
                            </div>
                        </div>
                        <div>
                            <label class="{{ $labelCls }}">Subtitle</label>
                            <textarea name="hp_hero_subtitle" rows="2" class="{{ $inputCls }}">{{ old('hp_hero_subtitle', $hp['hp_hero_subtitle']) }}</textarea>
                        </div>
                        <div>
                            <label class="{{ $labelCls }}">Background Image <span class="text-gray-400 font-bold">(optional, shown faded behind the hero)</span></label>
                            @if(!empty($hp['hp_hero_image']))
                                <div class="flex items-center gap-4 mb-3">
                                    <img src="{{ asset('storage/' . $hp['hp_hero_image']) }}" class="w-32 h-20 object-cover rounded-xl border border-gray-200">
                                    <label class="flex items-center gap-2 text-sm font-bold text-red-600 cursor-pointer">
                                        <input type="checkbox" name="remove_hero_image" value="1" class="rounded"> Remove current image
                                    </label>
                                </div>
                            @endif
                            <input type="file" name="hp_hero_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>

                <!-- FEATURED ASSETS -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-fire text-rose-500 mr-2"></i>Featured Assets Section</h3>
                            <p class="text-gray-500 text-sm">Section that lists your featured services.</p>
                        </div>
                        <label class="flex items-center gap-2 text-sm font-bold text-gray-600 cursor-pointer">
                            <input type="checkbox" name="hp_featured_show" value="1" @checked(old('hp_featured_show', $hp['hp_featured_show']) === '1') class="rounded"> Show
                        </label>
                    </div>
                    <div class="p-8 space-y-5">
                        <div><label class="{{ $labelCls }}">Badge</label><input type="text" name="hp_featured_badge" value="{{ old('hp_featured_badge', $hp['hp_featured_badge']) }}" class="{{ $inputCls }}"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div><label class="{{ $labelCls }}">Heading</label><input type="text" name="hp_featured_title" value="{{ old('hp_featured_title', $hp['hp_featured_title']) }}" class="{{ $inputCls }}"></div>
                            <div><label class="{{ $labelCls }}">Heading (highlighted)</label><input type="text" name="hp_featured_title_hl" value="{{ old('hp_featured_title_hl', $hp['hp_featured_title_hl']) }}" class="{{ $inputCls }}"></div>
                        </div>
                        <div><label class="{{ $labelCls }}">Subtitle</label><textarea name="hp_featured_subtitle" rows="2" class="{{ $inputCls }}">{{ old('hp_featured_subtitle', $hp['hp_featured_subtitle']) }}</textarea></div>
                    </div>
                </div>

                <!-- HOW IT WORKS -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-diagram-project text-blue-500 mr-2"></i>How It Works Section</h3>
                            <p class="text-gray-500 text-sm">Heading plus the process steps.</p>
                        </div>
                        <label class="flex items-center gap-2 text-sm font-bold text-gray-600 cursor-pointer">
                            <input type="checkbox" name="hp_how_show" value="1" @checked(old('hp_how_show', $hp['hp_how_show']) === '1') class="rounded"> Show
                        </label>
                    </div>
                    <div class="p-8 space-y-5">
                        <div><label class="{{ $labelCls }}">Badge</label><input type="text" name="hp_how_badge" value="{{ old('hp_how_badge', $hp['hp_how_badge']) }}" class="{{ $inputCls }}"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div><label class="{{ $labelCls }}">Heading</label><input type="text" name="hp_how_title" value="{{ old('hp_how_title', $hp['hp_how_title']) }}" class="{{ $inputCls }}"></div>
                            <div><label class="{{ $labelCls }}">Heading (highlighted)</label><input type="text" name="hp_how_title_hl" value="{{ old('hp_how_title_hl', $hp['hp_how_title_hl']) }}" class="{{ $inputCls }}"></div>
                        </div>

                        <div class="pt-2">
                            <div class="flex items-center justify-between mb-4">
                                <label class="{{ $labelCls }} mb-0">Process Steps</label>
                                <button type="button" @click="addStep()" class="bg-blue-600 text-white px-4 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all">+ Add Step</button>
                            </div>
                            <div class="space-y-4">
                                <template x-for="(step, index) in steps" :key="index">
                                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 relative">
                                        <button type="button" @click="removeStep(index)" class="absolute -top-3 -right-3 w-7 h-7 bg-black text-white rounded-full flex items-center justify-center hover:bg-red-600"><i class="fa-solid fa-xmark text-xs"></i></button>
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                            <input type="text" :name="`steps[${index}][id]`" x-model="step.id" placeholder="No. (e.g. 01)" class="px-4 py-2.5 bg-white border border-gray-100 rounded-xl font-bold text-sm">
                                            <input type="text" :name="`steps[${index}][title]`" x-model="step.title" placeholder="Title" class="px-4 py-2.5 bg-white border border-gray-100 rounded-xl font-bold text-sm md:col-span-1">
                                            <input type="text" :name="`steps[${index}][icon]`" x-model="step.icon" placeholder="Icon (e.g. fa-database)" class="px-4 py-2.5 bg-white border border-gray-100 rounded-xl font-bold text-sm">
                                            <input type="text" :name="`steps[${index}][desc]`" x-model="step.desc" placeholder="Description" class="px-4 py-2.5 bg-white border border-gray-100 rounded-xl font-medium text-sm">
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <p class="text-xs text-gray-400 mt-2 ml-1">Icons use <a href="https://fontawesome.com/search?o=r&m=free" target="_blank" class="text-indigo-600 underline">Font Awesome</a> names, e.g. <code>fa-shield-halved</code>.</p>
                        </div>
                    </div>
                </div>

                <!-- CORPORATE CTA -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-building text-[#0A192F] mr-2"></i>Corporate CTA Banner</h3>
                        <p class="text-gray-500 text-sm">The dark call-to-action banner below the steps.</p>
                    </div>
                    <div class="p-8 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div><label class="{{ $labelCls }}">Heading</label><input type="text" name="hp_cta_title" value="{{ old('hp_cta_title', $hp['hp_cta_title']) }}" class="{{ $inputCls }}"></div>
                            <div><label class="{{ $labelCls }}">Heading (highlighted)</label><input type="text" name="hp_cta_title_hl" value="{{ old('hp_cta_title_hl', $hp['hp_cta_title_hl']) }}" class="{{ $inputCls }}"></div>
                        </div>
                        <div><label class="{{ $labelCls }}">Subtitle</label><textarea name="hp_cta_subtitle" rows="2" class="{{ $inputCls }}">{{ old('hp_cta_subtitle', $hp['hp_cta_subtitle']) }}</textarea></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div><label class="{{ $labelCls }}">Button 1 Label</label><input type="text" name="hp_cta_btn1" value="{{ old('hp_cta_btn1', $hp['hp_cta_btn1']) }}" class="{{ $inputCls }}"></div>
                            <div><label class="{{ $labelCls }}">Button 2 Label</label><input type="text" name="hp_cta_btn2" value="{{ old('hp_cta_btn2', $hp['hp_cta_btn2']) }}" class="{{ $inputCls }}"></div>
                        </div>
                    </div>
                </div>

                <!-- TESTIMONIALS -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800"><i class="fa-solid fa-quote-right text-purple-500 mr-2"></i>Testimonials Section</h3>
                            <p class="text-gray-500 text-sm">Heading only. Manage the actual testimonials from <a href="{{ route('admin.testimonials.index') }}" class="text-indigo-600 underline">Testimonials</a>.</p>
                        </div>
                        <label class="flex items-center gap-2 text-sm font-bold text-gray-600 cursor-pointer">
                            <input type="checkbox" name="hp_testi_show" value="1" @checked(old('hp_testi_show', $hp['hp_testi_show']) === '1') class="rounded"> Show
                        </label>
                    </div>
                    <div class="p-8 space-y-5">
                        <div><label class="{{ $labelCls }}">Badge</label><input type="text" name="hp_testi_badge" value="{{ old('hp_testi_badge', $hp['hp_testi_badge']) }}" class="{{ $inputCls }}"></div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div><label class="{{ $labelCls }}">Heading</label><input type="text" name="hp_testi_title" value="{{ old('hp_testi_title', $hp['hp_testi_title']) }}" class="{{ $inputCls }}"></div>
                            <div><label class="{{ $labelCls }}">Heading (highlighted)</label><input type="text" name="hp_testi_title_hl" value="{{ old('hp_testi_title_hl', $hp['hp_testi_title_hl']) }}" class="{{ $inputCls }}"></div>
                        </div>
                        <div><label class="{{ $labelCls }}">Subtitle</label><textarea name="hp_testi_subtitle" rows="2" class="{{ $inputCls }}">{{ old('hp_testi_subtitle', $hp['hp_testi_subtitle']) }}</textarea></div>
                    </div>
                </div>

                <div class="sticky bottom-4 bg-white/80 backdrop-blur border border-gray-100 rounded-2xl shadow-lg px-6 py-4 flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-900 font-black tracking-widest uppercase text-xs">Cancel</a>
                    <button type="submit" class="px-10 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-black rounded-2xl shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-3">
                        Save Changes <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function homepageEditor() {
            return {
                steps: @json(old('steps', $hp['hp_steps'])),
                addStep() { this.steps.push({ id: '', title: '', icon: 'fa-circle', desc: '' }); },
                removeStep(index) { this.steps.splice(index, 1); },
            }
        }
    </script>
</x-app-layout>
