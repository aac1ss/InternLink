// SIDE BAR functionality
document.querySelectorAll(".sidebar-nav a").forEach((link) => {
  link.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default anchor behavior

    // Hide all sections
    document.querySelectorAll(".section").forEach((section) => {
      section.style.display = "none";
    });

    // Show the targeted section
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.style.display = "block";
    }

    // Update active state for navigation links
    document
      .querySelectorAll(".sidebar-nav a")
      .forEach((navLink) => navLink.classList.remove("active"));
    this.classList.add("active");

    // Save the current active section in localStorage
    localStorage.setItem("activeSection", this.getAttribute("href"));
  });
});

// Load the active section from localStorage on page load ( REeload garda bela jun page ma cha tei reload huncha)
document.addEventListener("DOMContentLoaded", () => {
  const activeSection = localStorage.getItem("activeSection");

  if (activeSection) {
    // Hide all sections
    document.querySelectorAll(".section").forEach((section) => {
      section.style.display = "none";
    });

    // Show the previously active section
    const target = document.querySelector(activeSection);
    if (target) {
      target.style.display = "block";
    }

    // Update the active link in the sidebar
    document
      .querySelectorAll(".sidebar-nav a")
      .forEach((navLink) => navLink.classList.remove("active"));
    const activeLink = document.querySelector(
      `.sidebar-nav a[href="${activeSection}"]`
    );
    if (activeLink) {
      activeLink.classList.add("active");
    }
  }
});

// Close dropdowns when clicking outside
document.addEventListener("click", (event) => {
  if (!event.target.closest(".dropdown")) {
    document.querySelectorAll(".dropdown").forEach((dropdown) => {
      dropdown.classList.remove("open");
    });
  }
});

// INTERNSHIP Functionalities
// Dropdown toggle functionality( IN INTERNSHIPs tab)
document.querySelectorAll(".dropdown-toggle").forEach((toggle) => {
  toggle.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default behavior
    const parent = this.closest(".dropdown");
    parent.classList.toggle("open");

    // Close other dropdowns
    document.querySelectorAll(".dropdown").forEach((dropdown) => {
      if (dropdown !== parent) dropdown.classList.remove("open");
    });
  });
});

// Ensure the "Post Internship" form displays fully
document.querySelectorAll(".dropdown-content a[href='#post-internship']").forEach((link) => {
  link.addEventListener("click", function () {
    const formSection = document.querySelector("#post-internship");
    if (formSection) {
      formSection.style.display = "block"; // Ensure form visibility
    }
  });
});



// Toggle visibility for stipend field
function toggleStipendField(value) {
  const stipendAmountField = document.getElementById("stipend-amount-container");
  const paidButton = document.getElementById("btn-paid");
  const unpaidButton = document.getElementById("btn-unpaid");

  if (value === "paid") {
    stipendAmountField.style.display = "block";
    paidButton.classList.add("active");
    unpaidButton.classList.remove("active");
  } else {
    stipendAmountField.style.display = "none";
    unpaidButton.classList.add("active");
    paidButton.classList.remove("active");
  }
}

// Toggle active state for type buttons
function setType(value) {
  const buttons = document.querySelectorAll(".type-toggle-btn");
  buttons.forEach((button) => button.classList.remove("active"));

  document.getElementById(`type-${value}`).classList.add("active");
  document.getElementById("type-hidden-input").value = value;
}




// For View-Status
document.addEventListener("DOMContentLoaded", () => {
  // Fetch data from the backend
  fetch("fetch_internships.php")
    .then((response) => response.json())
    .then((data) => {
      populateInternships("#internships tbody", data);
    })
    .catch((error) => console.error("Error fetching internships:", error));
});

// Populate the internships table
function populateInternships(tableSelector, internships) {
  const tableBody = document.querySelector(tableSelector);
  tableBody.innerHTML = ""; // Clear existing rows

  internships.forEach((internship) => {
    const row = `
      <tr>
        <td>${internship.internship_id}</td>
        <td>${internship.position}</td>
        <td class="status ${internship.status === "Active" ? "active" : "closed"}">${internship.status}</td>
        <td>${internship.posted_date.split(" ")[0]}</td>
        <td>${internship.deadline}</td>
        <td>${internship.applications || "0"}</td>
        <td>${internship.duration} months</td>
        <td>
          <button class="extend-btn">Extend Deadline</button>
          <button class="remove-btn">Remove Listing</button>
          <button class="view-applicants-btn">View Applicants</button>
        </td>
      </tr>
    `;
    tableBody.insertAdjacentHTML("beforeend", row);
  });
}

// MEMBERSHIP
// Popup functionality for membership plans
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
