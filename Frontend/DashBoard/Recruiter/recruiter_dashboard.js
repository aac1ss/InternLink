

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

//---------------------------------------------------------------------------------------------------------------------------
// Post an internship

//validation


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

//---------------------------------------------------------------------------------------------------------------------------
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

// ----------------------------------------------------------------------------------------

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
      <td class="applications">${internship.total_applicants}</td> <!-- New column for total applicants -->
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
  if (confirm("Are you sure you want to delete this internship?")) {
    // Send POST request to delete the internship
    fetch("../../../Backend/Recruiter_DashBoard/View-Status.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `action=delete_internship&internship_id=${internshipId}`,
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
      console.error("Error deleting internship:", error);
      alert("Error deleting internship.");
    });
  }
}



// ----------------------------------------------------------------------------------------
// Manage Applicants
document.addEventListener("DOMContentLoaded", () => {
  fetch('manage_applicants.php') // Fetch applicants data
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        console.error(data.error);
        return;
      }

      const container = document.getElementById("dropdown-container");

      for (const [internshipTitle, applicants] of Object.entries(data)) {
        // Create dropdown container
        const dropdown = document.createElement("div");
        dropdown.classList.add("dropdown-container");

        // Dropdown title
        const title = document.createElement("div");
        title.classList.add("dropdown-title");
        title.innerHTML = `${internshipTitle} <i class="fas fa-chevron-down"></i>`;
        dropdown.appendChild(title);

        // Dropdown content
        const content = document.createElement("div");
        content.classList.add("dropdown-content");

        // Create table for applicants
        const table = document.createElement("table");
        table.classList.add("applicants-table");
        table.innerHTML = `
          <thead>
            <tr>
              <th>Application No</th>
              <th>Applicant Name</th>
              <th>Position Applied</th>
              <th>View Profile</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            ${applicants.map(applicant => {
              return `
                <tr>
                  <td>${applicant.application_id}</td>
                  <td>${applicant.full_name}</td>
                  <td>${applicant.internship_title}</td>
                  <td>
                    <a href="../Candidate/candidate_profile/cprofile.php?c_id=${applicant.c_id}" target="_blank" class="view-profile-btn">
                      View Resume
                    </a>
                  </td>
                  <td class="status-cell" data-status="${applicant.status}">${applicant.status}</td>
                  <td>
                    <button class="action-btn approve" data-id="${applicant.application_id}" data-action="Shortlisted">Shortlist</button>
                    <button class="action-btn reject" data-id="${applicant.application_id}" data-action="Rejected">Reject</button>
                  </td>
                </tr>
              `;
            }).join("")}
          </tbody>
        `;
        content.appendChild(table);
        dropdown.appendChild(content);
        container.appendChild(dropdown);

        // Add event listener for toggling dropdown
        title.addEventListener("click", () => {
          content.classList.toggle("open");
        });
      }

      // Add event listeners to the action buttons after populating
      document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', handleAction);
      });

      // Apply color tint based on status
      document.querySelectorAll('.status-cell').forEach(cell => {
        const status = cell.getAttribute('data-status');
        if (status === "Under Review") {
          cell.classList.add('under-review');
        } else if (status === "short-listed") {
          cell.classList.add('short-listed');
        } else if (status === "Rejected") {
          cell.classList.add('rejected');
        }
      });
    })
    .catch(error => console.error("Error fetching applicants:", error));
});
function handleAction(event) {
  const button = event.target;
  const applicationId = button.getAttribute('data-id');
  let status = button.getAttribute('data-action').toLowerCase().replace(/\s+/g, '-'); // Format status as "short-listed" or "rejected"
  const applicantName = button.closest('tr').querySelector('td:nth-child(2)').textContent;

  // Log status to check its value
  console.log("Status before sending to backend:", status);

  // Ensure correct status format
  if (status === 'shortlisted') {
    status = 'short-listed'; // Fix the status if it's "shortlisted"
  }

  // Log the corrected status
  console.log("Corrected status:", status);

  // Ask for confirmation before taking action
  const confirmed = confirm(`Are you sure you want to ${status} ${applicantName}?`);
  if (!confirmed) {
    return; // Do nothing if user cancels the action
  }

  // Lock the selected button
  button.classList.add("locked");
  button.classList.add("selected"); // Highlight the selected button

  // Disable the other button and lock it
  const row = button.closest('tr');
  const otherButton = row.querySelector(`.action-btn:not(.${status.toLowerCase()})`);

  if (otherButton) {
    otherButton.classList.add("locked");
    otherButton.classList.add("disabled"); // Disable the other button
    otherButton.disabled = true; // Make the other button unclickable
  }

  // Send the update request to the server with the exact status value
  fetch('update_status.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ application_id: applicationId, status: status }) // Send status in the exact format
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(`${applicantName}'s status has been updated to ${status}.`);
        // Update the status text in the DOM
        const statusCell = button.closest('tr').querySelector('td:nth-child(5)');
        statusCell.textContent = status.charAt(0).toUpperCase() + status.slice(1).replace('-', ' '); // Capitalize the first letter and replace hyphen with space
      } else {
        alert(data.message);
        // Re-enable buttons if there's an error
        button.classList.remove("locked");
        button.classList.remove("selected");
        if (otherButton) {
          otherButton.classList.remove("locked");
          otherButton.classList.remove("disabled");
          otherButton.disabled = false; // Re-enable the other button
        }
      }
    })
    .catch(error => {
      console.error('Error updating status:', error);
      button.classList.remove("locked");
      button.classList.remove("selected");
      if (otherButton) {
        otherButton.classList.remove("locked");
        otherButton.classList.remove("disabled");
        otherButton.disabled = false; // Re-enable the other button
      }
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
