<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                    <i class="fa-solid fa-calendar-days text-[#0A3A7A] mr-2"></i>{{ __('Availability: ') . $service->name }}
                </h2>
                <p class="text-gray-500 text-sm mt-1">Click a date to block it. Click a blocked date to unblock.</p>
            </div>
            <a href="{{ route('vendor.dashboard') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-200 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden p-6 border border-slate-100">
                <!-- Calendar Container -->
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Block Date Modal -->
    <div x-data="{ open: false, date: '', reason: '' }"
         @open-block-modal.window="open = true; date = $event.detail.date; reason = ''"
         x-show="open" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="open = false"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Block Date: <span x-text="date" class="font-bold text-[#0A3A7A]"></span>
                    </h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reason (Optional)</label>
                        <input type="text" x-model="reason" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="e.g. Vacation, Maintenance">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <button type="button" 
                            @click="$dispatch('confirm-block', { date: date, reason: reason }); open = false"
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Block Date
                    </button>
                    <button type="button" 
                            @click="open = false"
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                events: '{{ route("vendor.services.availability.fetch", $service) }}',
                dateClick: function(info) {
                    // Open modal using Alpine
                    window.dispatchEvent(new CustomEvent('open-block-modal', { detail: { date: info.dateStr } }));
                },
                eventClick: function(info) {
                    if (info.event.extendedProps.type === 'blocked') {
                        if (confirm('Are you sure you want to unblock this date?')) {
                            // Delete availability
                            fetch(`/vendor/availability/${info.event.id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                info.event.remove();
                                alert(data.message);
                            });
                        }
                    } else if (info.event.url) {
                        // Let default behavior happen (redirect)
                    }
                }
            });
            calendar.render();

            // Listen for Alpine modal confirmation
            window.addEventListener('confirm-block', function(e) {
                fetch('{{ route("vendor.services.availability.store", $service) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        date: e.detail.date,
                        reason: e.detail.reason
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Date unavailable');
                    return response.json();
                })
                .then(data => {
                    calendar.refetchEvents();
                    // alert(data.message);
                })
                .catch(error => {
                    alert('Cannot block this date: It may be in the past or already booked.');
                });
            });
        });
    </script>
    @endpush
</x-app-layout>

