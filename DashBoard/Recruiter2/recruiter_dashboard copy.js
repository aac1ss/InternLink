// Sidebar navigation functionality
document.querySelectorAll(".sidebar-nav a").forEach((link) => {
    link.addEventListener("click", function () {
      document.querySelectorAll(".section").forEach((section) => {
        section.style.display = "none";
      });
      const target = document.querySelector(this.getAttribute("href"));
      if (target) target.style.display = "block";
  
      document
        .querySelectorAll(".sidebar-nav a")
        .forEach((link) => link.classList.remove("active"));
      this.classList.add("active");
    });
  });
  
  
  