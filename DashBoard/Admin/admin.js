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
