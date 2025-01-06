

// SIDE BAR functionality
document.addEventListener("DOMContentLoaded", () => {
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

  // Other code can go here...
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

//-----------------------------------------------------------------------------------
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

//-----------------------------------------------------------------------------------

// Function to toggle the card body visibility
function toggleCard(cardHeader) {
  const cardBody = cardHeader.nextElementSibling;
  cardBody.classList.toggle("open");
}

// Function to update the timeline based on the application status
function updateTimeline(statuses) {
  const statusClasses = ["pending", "completed", "rejected"];

  // Loop through each step and update its status
  for (let i = 0; i < statuses.length; i++) {
    const step = document.getElementById(`step${i + 1}`);
    const statusElement = document.getElementById(`status${i + 1}`);

    // Remove all status classes
    step.classList.remove(...statusClasses);
    
    // Add the new status class to the step
    step.classList.add(statuses[i]);
    
    // Update the status text
    statusElement.textContent = statuses[i].charAt(0).toUpperCase() + statuses[i].slice(1);
  }
}

// Example usage (You can replace with actual dynamic data)
const exampleStatuses = ["pending", "completed", "rejected"];
updateTimeline(exampleStatuses);


//-----------------------------------------------------------------------------------
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
      window.location.href = "/InternLink/Frontend/DashBoard/Candidate/candidate_dashboard.php";  // Redirect to the dashboard
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


//-----------------------------------------------------------------------------------
// Timeline
document.addEventListener("DOMContentLoaded", () => {
  fetch("../../../Backend/Candidate_Dashboard/view_application_status.php")
    .then((response) => response.json())
    .then((data) => {
      const container = document.querySelector("#post-internship-form");
      if (Array.isArray(data) && data.length > 0) {
        // Populate the timeline if there are applications
        populateTimeline(data);
      } else {
        // Show "Apply for an internship" message if no applications exist
        container.innerHTML = `
          <div class="no-applications">
            <h3>Apply for an internship to show the timeline.</h3>
            <p>Visit the <a href="../../Internships_Dashboard/internships_dashboard.php">Internships Page</a> to apply now!</p>
          </div>
        `;
      }
    })
    .catch((error) => {
      console.error("Error fetching applications:", error);
      const container = document.querySelector("#post-internship-form");
      container.innerHTML = `
        <div class="error-message">
          <h3>Something went wrong.</h3>
          <p>Unable to load applications. Please try again later.</p>
        </div>
      `;
    });
});

function populateTimeline(applications) {
  const container = document.querySelector("#post-internship-form");
  container.innerHTML = ''; // Clear existing content

  applications.forEach((application) => {
    const card = document.createElement("div");
    card.classList.add("card");

    // Card header with company details
    const cardHeader = document.createElement("div");
    cardHeader.classList.add("card-header");
    cardHeader.onclick = () => toggleCard(cardHeader);

    // Company Info Section
    const companyInfo = document.createElement("div");
    companyInfo.classList.add("company-info");

    const companyDetails = document.createElement("div");
    companyDetails.classList.add("company-details");
    companyDetails.innerHTML = `
      <div class="company-text">
        <h4 class="internship-name">${application.internship_title}</h4>
        <p class="company-name">${application.company_name}</p>
        <p class="deadline">Deadline: <span>${calculateDeadline(application.deadline, application.application_date)} days remaining</span></p>
      </div>
    `;

    companyInfo.appendChild(companyDetails);
    cardHeader.appendChild(companyInfo);

    // Set the background color of the card header based on the latest timeline status
    const latestStatusColor = getTimelineStatusColor(application.status);
    cardHeader.style.backgroundColor = latestStatusColor; // Apply color

    card.appendChild(cardHeader);

    // Card body with application timeline
    const cardBody = document.createElement("div");
    cardBody.classList.add("card-body");

    const timeline = document.createElement("div");
    timeline.classList.add("timeline");

    // Format the applied date
    const appliedDate = new Date(application.application_date);
    const formattedDate = appliedDate.toISOString().split('T')[0];

    let statusContent = '';

    // Timeline steps based on the status
    if (application.status === 'under review') {
      statusContent = `
        <div class="timeline-step completed">
          <div class="timeline-icon completed"></div>
          <div class="timeline-content">
            <h3>Application Submitted</h3>
            <p>Status: <span class="complete-status">Complete</span></p>
            <div class="date-status">
              <span class="status-left">Application Submitted</span>
              <span class="status-right">Applied Date: <span class="applied-date">${formattedDate}</span></span>
            </div>
          </div>
        </div>
        <div class="timeline-step ongoing">
          <div class="timeline-icon ongoing"></div>
          <div class="timeline-content">
            <h3>Under Review</h3>
            <p>Status: <span class="ongoing-status">Ongoing</span></p>
          </div>
        </div>
      `;
    } else if (application.status === 'short-listed') {
      statusContent = `
        <div class="timeline-step completed">
          <div class="timeline-icon completed"></div>
          <div class="timeline-content">
            <h3>Application Submitted</h3>
            <p>Status: <span class="complete-status">Complete</span></p>
            <div class="date-status">
              <span class="status-left">Application Submitted</span>
              <span class="status-right">Applied Date: <span class="applied-date">${formattedDate}</span></span>
            </div>
          </div>
        </div>
        <div class="timeline-step completed">
          <div class="timeline-icon completed"></div>
          <div class="timeline-content">
            <h3>Under Review</h3>
            <p>Status: <span class="completed-status">Completed</span></p>
          </div>
        </div>
        <div class="timeline-step shortlisted">
          <div class="timeline-icon shortlisted"></div>
          <div class="timeline-content">
            <h3>Selected</h3>
            <p>Status: <span class="shortlisted-status">Shortlisted</span></p>
            <p class="contact-email">Contact: <a href="mailto:tryaac1ss@gmail.com">tryaac1ss@gmail.com</a> for further information.</p>
          </div>
        </div>
      `;
    } else if (application.status === 'rejected') {
      statusContent = `
        <div class="timeline-step completed">
          <div class="timeline-icon completed"></div>
          <div class="timeline-content">
            <h3>Application Submitted</h3>
            <p>Status: <span class="complete-status">Complete</span></p>
            <div class="date-status">
              <span class="status-left">Application Submitted</span>
              <span class="status-right">Applied Date: <span class="applied-date">${formattedDate}</span></span>
            </div>
          </div>
        </div>
        <div class="timeline-step completed">
          <div class="timeline-icon completed"></div>
          <div class="timeline-content">
            <h3>Under Review</h3>
            <p>Status: <span class="completed-status">Completed</span></p>
          </div>
        </div>
        <div class="timeline-step rejected">
          <div class="timeline-icon rejected"></div>
          <div class="timeline-content">
            <h3>Rejected</h3>
            <p>Status: <span class="rejected-status">Keep Pushing Forward</span></p>
          </div>
        </div>
      `;
    }

    timeline.innerHTML = statusContent;
    cardBody.appendChild(timeline);
    card.appendChild(cardBody);
    container.appendChild(card);
  });
}

function toggleCard(cardHeader) {
  const cardBody = cardHeader.nextElementSibling;
  cardBody.style.display = cardBody.style.display === "none" ? "block" : "none";
}

// Function to calculate the remaining days
function calculateDeadline(deadline, createdAt) {
  const deadlineDate = new Date(deadline);
  const createdAtDate = new Date(createdAt);
  const timeRemaining = deadlineDate - createdAtDate;
  const daysRemaining = Math.floor(timeRemaining / (1000 * 3600 * 24)); // Convert ms to days
  return daysRemaining;
}

  // Function to determine the color of the latest status
function getTimelineStatusColor(status) {
  switch (status) {
    case 'under review':
      return '#ffe0b2'; // Orange for under review
    case 'short-listed':
      return '#d2ffd2'; // Green for shortlisted
    case 'rejected':
      return '#ffcccb'; // Red for rejected
    default:
      return '#c8e6ff'; // Blue as the default color
  }
}


//-----------------------------------------------------------------------------------
// View-Status
document.addEventListener("DOMContentLoaded", () => {
  fetch("../../../Backend/Candidate_Dashboard/view_application_status.php")
    .then((response) => response.json())
    .then((data) => {
      if (Array.isArray(data)) {
        populateApplications("#internship-list", data);
      } else {
        console.error("Error fetching applications:", data.error);
      }
    })
    .catch((error) => console.error("Error fetching applications:", error));
});

function populateApplications(tableSelector, applications) {
  const tableBody = document.querySelector(tableSelector);
  tableBody.innerHTML = ''; // Clear existing content

  applications.forEach((application) => {
    const row = document.createElement("tr");

  

    // Determine the color based on the status
    let statusStyle = "";
    switch (application.status.toLowerCase()) {
      case "under review":
        statusStyle = "background:rgb(255, 202, 41) ; box-shadow: 0 4px 8px rgba(255, 152, 0, 0.3);";
        break;
      case "short-listed":
        statusStyle = "background:rgb(32, 211, 76); color: #fff; box-shadow: 0 4px 8px rgba(76, 175, 80, 0.3);";
        break;
      case "rejected":
        statusStyle = "background:rgb(255, 31, 50); color: #fff; box-shadow: 0 4px 8px rgba(211, 47, 47, 0.3);";
        break;
      default:
        statusStyle = "background:rgb(218, 151, 255) ; color: #fff; box-shadow: 0 4px 8px rgba(117, 117, 117, 0.3);";
    }

    row.innerHTML = `
      <td>${application.internship_id}</td>
      <td>${application.company_name}</td>
      <td>${application.internship_title}</td>
      <td>${application.created_at}</td>
      <td>${application.remaining_days} days</td> <!-- Display Remaining Days -->
      <td>${application.application_date}</td>
      <td style="padding: 8px 15px; border-radius: 12px; font-weight: bold; ${statusStyle}">
        ${application.status}
      </td> <!-- Display Status with Gradient and Shadow -->
    `;

    tableBody.appendChild(row);
  });
}


//-----------------------------------------------------------------------------------
// Manage Application
document.addEventListener("DOMContentLoaded", () => {
  fetch("../../../Backend/Candidate_Dashboard/view_application_status.php")
    .then((response) => response.json())
    .then((data) => {
      populateTable(data);
    })
    .catch((error) => console.error("Error fetching applications:", error));
});

function populateTable(applications) {
  const tableBody = document.querySelector("#applicant-table-body");

  applications.forEach((application) => {
    const row = document.createElement("tr");

    row.innerHTML = `
      <td>${application.application_id}</td>
      <td>${application.company_name}</td>
      <td>${application.internship_title}</td>
      <td>${application.status}</td>
      <td>
        <button class="action-btn reject" onclick="confirmRetract('${application.application_id}')">Retract</button>
      </td>
    `;

    tableBody.appendChild(row);
  });
}

function confirmRetract(applicationId) {
  // Redirect to the retract_application.php with the application_id as a URL parameter
  const confirmAction = confirm("Are you sure you want to retract this application?");
  if (confirmAction) {
    window.location.href = `../../../Backend/Candidate_Dashboard/retract_application.php?application_id=${applicationId}`;
  }
}

window.onload = function() {
  const urlParams = new URLSearchParams(window.location.search);
  const message = urlParams.get('message');
  const error = urlParams.get('error');

  if (message) {
      alert(message);  // Show success message as an alert
  } 
  if (error) {
      alert(error);  // Show error message as an alert
  }

  // Clear the URL query parameters after showing the alert
  if (message || error) {
      history.replaceState(null, '', window.location.pathname);
  }
};






//-----------------------------------------------------------------------------------
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
