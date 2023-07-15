<x-filament::page>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <script>

        document.addEventListener('DOMContentLoaded', function()
        {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridFourDay',
                views: {
                    timeGridFourDay: {
                        type: 'timeGrid',
                        duration: { days: 4 }
                    }
                },
                locale: 'fa',                // initialView: 'timeGridWeek',
                // initialView: 'dayGridMonth',
                // events: [
                //     { // this object will be "parsed" into an Event Object
                //         title: 'The Title', // a property!
                //         start: '2023-07-15', // a property!
                //         end: '2023-07-15' // a property! ** see important note below about 'end' **
                //     }
                // ]
                events: @json($meeting)
            });
            calendar.render();
        });

    </script>

    <div id='calendar' class="bg-white p-3 rounded-md"></div>
</x-filament::page>
