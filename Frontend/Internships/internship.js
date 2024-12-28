
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
