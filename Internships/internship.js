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
