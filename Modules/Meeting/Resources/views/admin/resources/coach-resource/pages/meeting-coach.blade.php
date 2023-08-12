<x-filament::page>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'fa',
                // initialView: 'dayGridWeek',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                events: @json($meeting)
            });
            calendar.render();
        });

    </script>

    <h3 class="font-bold text-2xl" style="direction: ltr; text-align: right">{{ $record->name }}جلسات </h3>

    <div class="bg-white p-3 rounded-md">
        <div id='calendar'></div>
    </div>
</x-filament::page>
