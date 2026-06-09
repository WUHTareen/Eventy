<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Social & Professional Profile') }}
        </h2>
    </x-slot>
<div class="p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-[#0A3A7A] tracking-tighter uppercase">Profile <span class="text-[#ED1C24]">Management</span></h1>
        <p class="text-gray-500 font-medium">Configure your professional portfolio and business settings.</p>
    </div>

    <form action="{{ route('vendor.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Basic Info & Identity -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm shadow-blue-900/5 text-center">
                    <h3 class="text-lg font-black text-[#0A3A7A] mb-6 tracking-tight uppercase">Public <span class="text-[#ED1C24]">Identity</span></h3>
                    
                    <div class="relative inline-block mb-6 group">
                        <div class="w-40 h-40 rounded-[2.5rem] border-4 border-gray-50 overflow-hidden shadow-xl mx-auto shadow-blue-900/10">
                            <img src="{{ $user->getAvatarUrl() }}" id="avatar-preview" class="w-full h-full object-cover">
                        </div>
                        <label for="avatar" class="absolute bottom-0 right-0 w-12 h-12 bg-[#0A3A7A] rounded-2xl flex items-center justify-center text-white cursor-pointer shadow-lg hover:bg-[#0D4E9A] transition-all transform hover:scale-110">
                            <i class="fa-solid fa-camera text-sm"></i>
                            <input type="file" name="avatar" id="avatar" class="hidden" onchange="previewImage(event)">
                        </label>
                    </div>
                    
                    <h4 class="text-xl font-black text-gray-800 tracking-tight">{{ $user->name }}</h4>
                    <p class="text-gray-400 font-bold uppercase tracking-widest text-[10px] mb-4">{{ $user->category->name ?? 'Professional Vendor' }}</p>
                    
                    <div class="flex flex-wrap justify-center gap-2">
                        @if($user->is_verified)
                            <span class="bg-blue-100 text-blue-600 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-200">
                                <i class="fa-solid fa-circle-check"></i> Verified
                            </span>
                        @endif
                        <a href="{{ route('vendors.show', $user) }}" target="_blank" class="bg-gray-100 text-gray-600 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-gray-200 hover:bg-[#0A3A7A] hover:text-white transition-all">
                            <i class="fa-solid fa-eye"></i> View Portfolio
                        </a>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm shadow-blue-900/5">
                    <h3 class="text-lg font-black text-[#0A3A7A] mb-6 tracking-tight uppercase">Social <span class="text-[#ED1C24]">Connect</span></h3>
                    
                    <div class="space-y-4">
                        @foreach(['facebook', 'instagram', 'linkedin', 'tiktok', 'youtube'] as $platform)
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">{{ ucfirst($platform) }} URL</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                        <i class="fa-brands fa-{{ $platform === 'facebook' ? 'facebook-f' : ($platform === 'linkedin' ? 'linkedin-in' : $platform) }}"></i>
                                    </span>
                                    <input type="url" name="social_links[{{ $platform }}]" value="{{ $user->social_links[$platform] ?? '' }}" 
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#0A3A7A] focus:bg-white transition-all text-sm font-bold"
                                        placeholder="https://...">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Content & Operations -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Bio -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm shadow-blue-900/5">
                    <h3 class="text-xl font-black text-[#0A3A7A] mb-6 tracking-tight uppercase">Professional <span class="text-[#ED1C24]">Bio</span></h3>
                    <textarea name="bio" rows="6" class="w-full px-6 py-4 bg-gray-50 border-gray-100 rounded-[1.5rem] focus:ring-2 focus:ring-[#0A3A7A] focus:bg-white transition-all font-medium text-gray-600  font-serif leading-relaxed" 
                        placeholder="Tell your clients about your expertise, experience, and the premium quality you deliver...">{{ $user->bio }}</textarea>
                    <p class="text-xs text-gray-400 mt-4 font-medium ">This will be displayed prominently on your public portfolio page.</p>
                </div>

                <!-- Business Hours -->
                <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm shadow-blue-900/5">
                    <h3 class="text-xl font-black text-[#0A3A7A] mb-6 tracking-tight uppercase">Business <span class="text-[#ED1C24]">Hours</span></h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <div class="flex items-center gap-4">
                                <div class="w-24 shrink-0">
                                    <span class="text-sm font-black text-gray-600 uppercase tracking-widest">{{ $day }}</span>
                                </div>
                                <input type="text" name="business_hours[{{ $day }}]" value="{{ $user->business_hours[$day] ?? '09:00 AM - 06:00 PM' }}" 
                                    class="w-full px-4 py-3 bg-gray-50 border-gray-100 rounded-xl focus:ring-2 focus:ring-[#0A3A7A] focus:bg-white transition-all text-sm font-bold"
                                    placeholder="Closed or 00:00 - 00:00">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-12 py-5 bg-[#0A3A7A] hover:bg-[#0D4E9A] text-white rounded-[1.5rem] font-black uppercase tracking-widest shadow-xl shadow-blue-900/20 transition-all hover:-translate-y-1 active:scale-95">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('avatar-preview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
</x-app-layout>

