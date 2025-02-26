function sortTable() {
  const select = document.getElementById("sortSelect");
  const value = select.value;
  if (!value) return;

  const tbody = document.getElementById("tableBody");
  const rows = Array.from(tbody.getElementsByTagName("tr"));

  // Don't sort if there's no data or only the "no data" message
  if (rows.length === 1 && rows[0].cells.length === 6) return;

  const [sortBy, direction] = value.split("_");
  let columnIndex;

  switch (sortBy) {
    case "id":
      columnIndex = 0;
      break;
    case "name":
      columnIndex = 1;
      break;
    case "type":
      columnIndex = 2;
      break;
    case "quota":
      columnIndex = 4;
      break;
    default:
      return;
  }

  rows.sort((a, b) => {
    let aValue = a.cells[columnIndex].textContent;
    let bValue = b.cells[columnIndex].textContent;

    // Convert to number for quota sorting
    if (sortBy === "quota") {
      aValue = parseFloat(aValue) || 0;
      bValue = parseFloat(bValue) || 0;
    }

    if (direction === "asc") {
      return aValue > bValue ? 1 : -1;
    } else {
      return aValue < bValue ? 1 : -1;
    }
  });

  // Clear and re-append sorted rows
  while (tbody.firstChild) {
    tbody.removeChild(tbody.firstChild);
  }
  rows.forEach((row) => tbody.appendChild(row));
}
