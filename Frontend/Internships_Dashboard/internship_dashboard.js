
function openModal(data) {
    try {
        // If data is a string, parse it into an object
        if (typeof data === 'string') {
            data = data.replace(/[\x00-\x1F\x7F]/g, ""); 
            data = JSON.parse(data);
        }

        // Populate modal fields with internship data
        document.getElementById('modal-job-title').textContent = data.internship_title || 'No Title Provided';
        document.getElementById('modal-company-name').textContent = data.company_name || 'No Company Name Provided';
        document.getElementById('modal-stipend').textContent = data.stipend_amount || 'Unpaid';
        document.getElementById('modal-location').textContent = data.location || 'Not Specified';
        document.getElementById('modal-duration').textContent = data.duration || 'Not Specified';
        document.getElementById('modal-type').textContent = data.type || 'Not Specified';
        document.getElementById('modal-description').textContent = data.job_description || 'No Description Provided';

        // Helper function to generate a styled bullet list
        function generateBulletList(content) {
            return content
                .split('.')
                .filter(item => item.trim() !== '') // Remove empty entries
                .map(item => `<li>${item.trim()}</li>`)
                .join('');
        }

        // Format responsibilities, requirements, and perks as bullet points
        const responsibilities = data.responsibility || 'No Responsibilities Provided';
        document.getElementById('modal-responsibilities').innerHTML = `<ul class="styled-bullets">${generateBulletList(responsibilities)}</ul>`;

        const requirements = data.requirements || 'No Requirements Provided';
        document.getElementById('modal-requirements').innerHTML = `<ul class="styled-bullets">${generateBulletList(requirements)}</ul>`;

        const perks = data.perks || 'No Perks Listed';
        document.getElementById('modal-perks').innerHTML = `<ul class="styled-bullets">${generateBulletList(perks)}</ul>`;

        // Show the modal
        const modal = document.getElementById('internshipModal');
        modal.style.display = 'flex'; // Show modal
        document.body.style.overflow = 'hidden'; // Disable background scroll
    } catch (e) {
        console.error("Error processing data:", e);
    }
}




// Close the modal and restore background scrolling
function closeModal() {
    const modal = document.getElementById('internshipModal');
    modal.style.display = 'none'; // Hide modal
    document.body.style.overflow = 'auto'; // Enable background scrolling
}


//Apply now functionality
// function applyForInternship(internship_id) {
//     // Set the internship_id in the hidden input field in the modal form
//     document.getElementById('internship_id').value = internship_id;

//     // Open the modal (optional, if you want to show more details)
//     document.getElementById('internshipModal').style.display = 'block';
// }

// function closeModal() {
//     document.getElementById('internshipModal').style.display = 'none';
// }
// function openModalWithDetails(internshipId, internshipTitle) {
//     // Set the hidden input fields in the form
//     document.querySelector("input[name='internship-id']").value = internshipId;
//     document.querySelector("input[name='internship_title']").value = internshipTitle;

//     // Open the modal
//     document.getElementById("internshipModal").style.display = "block";
// }

// function closeModal() {
//     document.getElementById("internshipModal").style.display = "none";
// }


function openModalWithDetails(internship) {
    // Ensure all required internship details are available
    if (!internship || !internship.internship_id || !internship.internship_title || !internship.company_name) {
        alert("Internship details are not fully provided.");
        return;
    }

    // Populate modal fields with internship details
    document.getElementById('modal-internship-title').value = internship.internship_title;
    document.getElementById('modal-internship-id').value = internship.internship_id;
    document.getElementById('modal-created-at').value = internship.created_at;
    document.getElementById('modal-company-name-input').value = internship.company_name;

    // Update modal content
    document.getElementById('modal-job-title').textContent = internship.internship_title;
    document.getElementById('modal-company-name').textContent = internship.company_name;
    document.getElementById('modal-stipend').textContent = internship.stipend_amount || 'Unpaid';
    document.getElementById('modal-location').textContent = internship.location || 'Not Specified';
    document.getElementById('modal-duration').textContent = internship.duration || 'Not Specified';
    document.getElementById('modal-type').textContent = internship.type || 'Not Specified';
    document.getElementById('modal-description').textContent = internship.job_description || 'No Description Provided';

    // Helper function to generate a styled bullet list
    function generateBulletList(content) {
        return content
            .split('.')
            .filter(item => item.trim() !== '') // Remove empty entries
            .map(item => `<li>${item.trim()}</li>`)
            .join('');
    }

    // Format responsibilities, requirements, and perks as bullet points
    const responsibilities = internship.responsibility || 'No Responsibilities Provided';
    document.getElementById('modal-responsibilities').innerHTML = `<ul class="styled-bullets">${generateBulletList(responsibilities)}</ul>`;

    const requirements = internship.requirements || 'No Requirements Provided';
    document.getElementById('modal-requirements').innerHTML = `<ul class="styled-bullets">${generateBulletList(requirements)}</ul>`;

    const perks = internship.perks || 'No Perks Listed';
    document.getElementById('modal-perks').innerHTML = `<ul class="styled-bullets">${generateBulletList(perks)}</ul>`;

    // Show the modal
    const modal = document.getElementById('internshipModal');
    modal.style.display = 'flex'; // Show modal
    document.body.style.overflow = 'hidden'; // Disable background scroll
    console.log(internship);

}



