$(document).ready(function() {
    $('#btnAppointments').click(function() {
        window.location.href = './userAppointments.php';
    });
    $('#btnOrders').click(function() {
        window.location.href = './orders.php';
    });

    // Helper to format time in 12-hour format
    function formatTime24to12(time24) {
        const [hour, minute] = time24.split(":");
        let h = parseInt(hour);
        const ampm = h >= 12 ? 'PM' : 'AM';
        h = h % 12;
        if (h === 0) h = 12;
        return `${h}:${minute} ${ampm}`;
    }

    // Generate all possible time slots (10:00 to 20:00, every 30 min)
    function generateTimeSlots() {
        const slots = [];
        let hour = 10;
        let minute = 0;
        while (hour < 20 || (hour === 20 && minute === 0)) {
            const hStr = hour.toString().padStart(2, '0');
            const mStr = minute.toString().padStart(2, '0');
            slots.push(`${hStr}:${mStr}`);
            minute += 60;
            if (minute === 60) {
                minute = 0;
                hour++;
            }
        }
        return slots;
    }

    // Fetch booked slots and update dropdown
    $('#dateInput').on('change', function() {
        const date = $(this).val();
        const dropdown = $('#timeDropdown');
        dropdown.html('<option value="">Select a time</option>');
        if (!date) return;
        axios.get('/skyhigh/admin_panel/controller/checkTimeSlots.php', { params: { date } })
            .then(function(response) {
                const booked = response.data.bookedSlots || [];
                const allSlots = generateTimeSlots();
                allSlots.forEach(function(slot) {
                    if (!booked.includes(slot)) {
                        dropdown.append(`<option value="${slot}">${formatTime24to12(slot)}</option>`);
                    }
                });
            })
            .catch(function() {
                dropdown.html('<option value="">Error loading times</option>');
            });
    });
});