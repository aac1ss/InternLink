

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

//internship-type-toggle
function setType(type) {
  // Set the value of the hidden input to the selected type
  const hiddenInput = document.getElementById('type-hidden-input');
  hiddenInput.value = type.toLowerCase(); // Set to lowercase ('remote', 'hybrid', 'onsite')

  // Update the active class for buttons
  document.querySelectorAll('.type-toggle-btn').forEach(button => {
      button.classList.remove('active');
  });

  // Mark the clicked button as active
  const activeButton = document.getElementById('type-' + type.toLowerCase());
  activeButton.classList.add('active');
}

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


//Edit-Profile
document.addEventListener('DOMContentLoaded', () => {
  // Check if the URL contains a success parameter
  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');

  if (status === 'success') {
    // Show success pop-up
    alert("Profile saved successfully!");

    // Redirect to the dashboard after 1 second
    setTimeout(() => {
      window.location.href = "recruiter_dashboard.php";  // Redirect to the dashboard
    }, 1000);  // 1 second delay before redirect
  }

  const editBtn = document.getElementById("edit-profile-btn");
  const form = document.getElementById("company-profile-form");
  const inputs = form.querySelectorAll("input, textarea, select");
  const saveBtn = form.querySelector(".btn");

  // Initially disable fields if profile exists
  if (editBtn) {
      toggleFormState(false);
  }


  
  // Handle "Edit Profile" button click
  if (editBtn) {
      editBtn.addEventListener("click", () => {
          toggleFormState(true); // Enable fields
          editBtn.style.display = "none"; // Hide "Edit Profile" button
      });
  }

  // Smooth transitions for enabling/disabling form
  function toggleFormState(isEditable) {
      inputs.forEach((input) => {
          input.disabled = !isEditable;
          input.style.transition = "background-color 0.3s ease, border 0.3s ease";
      });
  }

  // Client-side validation feedback
  saveBtn.addEventListener("click", (event) => {
      const requiredFields = form.querySelectorAll("input[required], textarea[required]");
      let isValid = true;

      requiredFields.forEach((field) => {
          if (!field.value.trim()) {
              isValid = false;
              field.style.border = "2px solid red";
              setTimeout(() => (field.style.border = ""), 2000);
          }
      });

      if (!isValid) {
          event.preventDefault(); // Prevent form submission if validation fails
          alert("Please fill out all required fields.");
      }
  });
});

// View-Status
document.addEventListener("DOMContentLoaded", () => {
  fetch("../../../Backend/Recruiter_DashBoard/View-Status.php")  // Correct path as necessary
    .then((response) => response.text()) // Get response as text
    .then((data) => {
      console.log("Raw response:", data);  // Log the raw response from the PHP script
      try {
        const jsonData = JSON.parse(data);  // Try to parse it as JSON
        if (jsonData.error) {
          console.error(jsonData.error);  // Handle JSON error
          return;
        }
        populateInternships("#internships tbody", jsonData);  // Populate the table
      } catch (e) {
        console.error("Error parsing JSON:", e);  // Log any parsing errors
      }
    })
    .catch((error) => console.error("Error fetching internships:", error));
});

function populateInternships(tableSelector, internships) {
  const tableBody = document.querySelector(tableSelector);
  tableBody.innerHTML = ''; // Clear any existing data

  internships.forEach((internship) => {
    const row = document.createElement("tr");

    // Determine the status class based on the status
    const statusClass = internship.status === 'on' ? 'status-on' : 'status-off';

    // Add internship details to the row
    row.innerHTML = `
      <td>${internship.internship_id}</td>
      <td>${internship.internship_title}</td>
      <td>${internship.created_at}</td>
      <td>${internship.deadline}</td>
      <td>${internship.deadline}</td>
      <td>${internship.duration} months</td>
       <td class="status ${statusClass}">${internship.status}</td>
      <td class="action-buttons">
        <button class="extend-btn" onclick="extendDeadline(${internship.internship_id})">Extend Deadline</button>
        <button class="end-btn" onclick="endPosting(${internship.internship_id})">End Posting</button>
      </td>
     
    `;

    tableBody.appendChild(row);
  });
}



// Extend Deadline function
function extendDeadline(internshipId) {
  const newDeadline = prompt("Enter new deadline (YYYY-MM-DD):");

  if (newDeadline) {
    // Send POST request to extend the deadline
    fetch("../../../Backend/Recruiter_DashBoard/View-Status.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `action=extend_deadline&internship_id=${internshipId}&new_deadline=${newDeadline}`,
    })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert(data.message);
        location.reload(); // Reload the page to reflect the changes
      } else {
        alert(data.error);
      }
    })
    .catch((error) => {
      console.error("Error extending deadline:", error);
      alert("Error extending deadline.");
    });
  }
}

// End Posting function
function endPosting(internshipId) {
  if (confirm("Are you sure you want to end this posting?")) {
    // Send POST request to end the posting
    fetch("../../../Backend/Recruiter_DashBoard/View-Status.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `action=end_posting&internship_id=${internshipId}`,
    })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert(data.message);
        location.reload(); // Reload the page to reflect the changes
      } else {
        alert(data.error);
      }
    })
    .catch((error) => {
      console.error("Error ending posting:", error);
      alert("Error ending posting.");
    });
  }
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
