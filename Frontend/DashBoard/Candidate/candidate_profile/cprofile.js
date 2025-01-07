// cprofile.js

// Toggle resume visibility
function toggleResume() {
    const resumeContainer = document.getElementById('resume-container');
    const button = document.getElementById('view-resume');
    
    if (resumeContainer.style.display === 'block') {
        resumeContainer.style.display = 'none';
        button.textContent = 'View Resume';
    } else {
        resumeContainer.style.display = 'block';
        button.textContent = 'Hide Resume';
    }
}
