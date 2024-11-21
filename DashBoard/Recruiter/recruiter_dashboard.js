// For Navigation //
document.querySelectorAll(".sidebar-nav a").forEach((link) => {
  link.addEventListener("click", function () {
    document.querySelectorAll(".section").forEach((section) => {
      section.style.display = "none";
    });
    const target = document.querySelector(this.getAttribute("href"));
    target.style.display = "block";

    document
      .querySelectorAll(".sidebar-nav a")
      .forEach((link) => link.classList.remove("active"));
    this.classList.add("active");
  });
});

// Dropdown toggle functionality
document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
  toggle.addEventListener("click", function (event) {
    event.preventDefault();
    const parent = this.closest(".dropdown");
    parent.classList.toggle("open");

    // Close other dropdowns if open
    document.querySelectorAll(".dropdown").forEach((dropdown) => {
      if (dropdown !== parent) dropdown.classList.remove("open");
    });
  });
});

// Close dropdowns when clicking outside
document.addEventListener("click", (event) => {
  if (!event.target.closest(".dropdown")) {
    document.querySelectorAll(".dropdown").forEach((dropdown) => {
      dropdown.classList.remove("open");
    });
  }
});

//Pop UP
function showPaymentPopup(planName, planPrice) {
  document.getElementById("payment-popup").style.display = "flex";
  document.getElementById("plan-name").innerText = planName;
  document.getElementById("plan-price").innerText = planPrice;
}

function closePaymentPopup() {
  document.getElementById("payment-popup").style.display = "none";
}

document
  .querySelector(".payment-form")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    alert("Payment successful!");
    closePaymentPopup();
  });
