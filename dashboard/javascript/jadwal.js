// logika untuk jadwal
const calendar = document.getElementById("calendar");

function generateCalendar(year, month) {
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDay = new Date(year, month, 1).getDay();
    const currentDate = new Date();
    const daysHeader = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    calendar.innerHTML = "";

    // Add header days
    daysHeader.forEach((day) => {
        const headerCell = document.createElement("div");
        headerCell.classList.add("header");
        headerCell.textContent = day;
        calendar.appendChild(headerCell);
    });

    // Add empty cells for days before the first day of the month
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement("div");
        emptyCell.classList.add("day", "empty");
        calendar.appendChild(emptyCell);
    }

    // Add days of the month
    for (let day = 1; day <= daysInMonth; day++) {
        const dayCell = document.createElement("div");
        dayCell.classList.add("day");
        dayCell.textContent = day;

        if (
            day === currentDate.getDate() &&
            month === currentDate.getMonth() &&
            year === currentDate.getFullYear()
        ) {
            dayCell.classList.add("current-day");
        }

        // Add event indicator (green line) for specific dates
        // This is just an example - you should modify based on your actual events
        if (day <= 9) {
            dayCell.style.borderBottom = "3px solid #10B981";
        }

        calendar.appendChild(dayCell);
    }
}

// Initialize calendar
const now = new Date();
generateCalendar(now.getFullYear(), now.getMonth());

// Add event listeners for navigation buttons
document.querySelector('.nav-btn.prev').addEventListener('click', () => {
    // Implement previous month navigation
});

document.querySelector('.nav-btn.next').addEventListener('click', () => {
    // Implement next month navigation
});