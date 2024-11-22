document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll("tbody tr");
    const maxRows = 5;
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / maxRows);
    const pagination = document.querySelector(".pagination");
    let currentPage = 1;

    function showPage(page) {
        const start = (page - 1) * maxRows;
        const end = start + maxRows;

        rows.forEach((row, index) => {
            row.style.display = index >= start && index < end ? "" : "none";
        });
    }

    function renderPagination() {
        pagination.innerHTML = "";

    
        const prevButton = createPageButton("Previous", currentPage > 1, () => goToPage(currentPage - 1));
        pagination.appendChild(prevButton);

    
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = createPageButton(i, true, () => goToPage(i));
            if (i === currentPage) pageButton.classList.add("active");
            pagination.appendChild(pageButton);
        }
    
        const nextButton = createPageButton("Next", currentPage < totalPages, () => goToPage(currentPage + 1));
        pagination.appendChild(nextButton);
    }

    function createPageButton(text, enabled, onClick) {
        const button = document.createElement("button");
        button.textContent = text;
        button.className = "page-btn";
        button.disabled = !enabled;
        if (enabled) button.addEventListener("click", onClick);
        return button;
    }

    function goToPage(page) {
        currentPage = page;
        showPage(page);
        renderPagination();
    }

    goToPage(1);
});
