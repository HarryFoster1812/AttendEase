document.addEventListener('DOMContentLoaded', function () {
    const expandAllButton = document.getElementById('expandAllButton');
    const additionalCourses = document.getElementById('additionalCourses');
    const expandButtons = document.querySelectorAll('.expand-button');
    
    // Remove initial collapsed class addition
    expandAllButton.querySelector('.fa-chevron-down').style.transition = 'none';
    
    // Remove initial collapsed class from individual buttons
    expandButtons.forEach(button => {
        button.querySelector('.fa-chevron-down').style.transition = 'none';
    });
    
    // Force reflow
    void document.body.offsetHeight;
    
    // Re-enable transitions after a brief delay
    setTimeout(() => {
        expandAllButton.querySelector('.fa-chevron-down').style.transition = 'transform 0.3s ease';
        expandButtons.forEach(button => {
            button.querySelector('.fa-chevron-down').style.transition = 'transform 0.3s ease';
        });
    }, 100);
    
    // Handle expand all button clicks
    expandAllButton.addEventListener('click', function() {
        this.classList.toggle('collapsed');
    });

    // Handle individual expand buttons
    expandButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.toggle('collapsed');
        });
    });
});