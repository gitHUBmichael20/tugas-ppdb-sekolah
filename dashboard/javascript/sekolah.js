// kode search bar
const searchBar = document.querySelector(".search-bar input");
const tableRows = document.querySelectorAll(".table-container tbody tr");

searchBar.addEventListener("input", () => {
  const searchValue = searchBar.value.toLowerCase();

  tableRows.forEach((row) => {
    row.style.display = row.cells[0].textContent
      .toLowerCase()
      .includes(searchValue)
      ? ""
      : "none";
  });
});