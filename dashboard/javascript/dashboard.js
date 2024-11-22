// sidebar process
const navItems = document.querySelectorAll(".nav-item");
const sections = document.querySelectorAll(".section");
const sidebar = document.querySelector(".sidebar");
const menuToggle = document.getElementById("menuToggle");

navItems.forEach((item) => {
  item.addEventListener("click", (e) => {
    e.preventDefault();


    navItems.forEach((nav) => nav.classList.remove("active"));
    sections.forEach((section) => section.classList.remove("active"));


    item.classList.add("active");


    const sectionClass = item.getAttribute("data-section");
    document.querySelector(`.${sectionClass}`).classList.add("active");


    if (window.innerWidth <= 768) {
      sidebar.classList.remove("active");
    }
  });
});

menuToggle.addEventListener("click", () => {
  sidebar.classList.toggle("active");
});

document.addEventListener("click", (e) => {
  if (
    window.innerWidth <= 768 &&
    !sidebar.contains(e.target) &&
    !menuToggle.contains(e.target)
  ) {
    sidebar.classList.remove("active");
  }
});

window.addEventListener("resize", () => {
  if (window.innerWidth > 768) {
    sidebar.classList.remove("active");
  }
});



