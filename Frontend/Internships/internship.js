// Open modal with smooth transition
function openModal() {
    const modal = document.getElementById('internshipModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevents background scrolling
}

// Close modal and reset body overflow
function closeModal() {
    const modal = document.getElementById('internshipModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}
// Open modal with internship details
function openModal(data) {
    const internship = JSON.parse(data);

    // Populate modal fields with internship data
    document.getElementById('modal-job-title').textContent = internship.internship_title || 'No Title Provided';
    document.getElementById('modal-company-name').textContent = internship.company_name || 'No Company Name Provided';
    document.getElementById('modal-stipend').textContent = internship.stipend_amount || 'Unpaid';
    document.getElementById('modal-location').textContent = internship.location || 'Not Specified';
    document.getElementById('modal-duration').textContent = internship.duration || 'Not Specified';
    document.getElementById('modal-type').textContent = internship.type || 'Not Specified';
    document.getElementById('modal-description').textContent = internship.job_description || 'No Description Provided';
    document.getElementById('modal-responsibilities').textContent = internship.responsibility || 'No Responsibilities Provided';
    document.getElementById('modal-requirements').textContent = internship.requirements || 'No Requirements Provided';
    document.getElementById('modal-perks').textContent = internship.perks || 'No Perks Listed';

    // Show the modal
    const modal = document.getElementById('internshipModal');
    modal.style.display = 'flex'; // Show modal
    document.body.style.overflow = 'hidden'; // Disable background scrolling
}

// Close the modal and restore background scrolling
function closeModal() {
    const modal = document.getElementById('internshipModal');
    modal.style.display = 'none'; // Hide modal
    document.body.style.overflow = 'auto'; // Enable background scrolling
}
