$(document).ready(function () {
    function updateSidebarContent() {
        if ($(window).width() < 992) {
            $('#settings-content').html(`
                <div class="search-container no-margin">
                    <input type="text" class="form-control search-input" placeholder="Search...">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <div class="nav flex-column nav-pills mt-2">
                    <button class="nav-link active" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                        <span class="ms-3">Profile</span>
                    </button>
                    <button class="nav-link" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-controls="v-pills-account" aria-selected="false">
                        <span class="ms-3">Account</span>
                    </button>
                    <button class="nav-link" id="v-pills-preferences-tab" data-bs-toggle="pill" data-bs-target="#v-pills-preferences" type="button" role="tab" aria-controls="v-pills-preferences" aria-selected="false">
                        <span class="ms-3">Preferences</span>
                    </button>
                    <button class="nav-link" id="v-pills-privacy-tab" data-bs-toggle="pill" data-bs-target="#v-pills-privacy" type="button" role="tab" aria-controls="v-pills-privacy" aria-selected="false">
                        <span class="ms-3">Privacy and Security</span>
                    </button>
                </div>
            `);
            $('.main-content').css('margin-left', '0'); // Reset margin for smaller screens
        } else {
            $('#settings-content').html('');
            $('.main-content').css('margin-left', '320px'); // Reset margin when sidebar is visible
        }
    }

    updateSidebarContent();
    $(window).resize(updateSidebarContent);

    let sidebarVisible = true; // Track sidebar state

    $('#nav-toggler').click(function () {
        if ($(window).width() >= 992) {
            if (sidebarVisible) {
                $('#sidebarCollapse').removeClass('show'); // Hide sidebar
                $('.main-content').css('margin-left', '0'); // Expand content
            } else {
                $('#sidebarCollapse').addClass('show'); // Show sidebar
                $('.main-content').css('margin-left', '320px'); // Restore margin
            }
            sidebarVisible = !sidebarVisible; // Toggle state
        }
    });
});
