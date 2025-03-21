$(document).ready(function () {
    let lastClickedTab = 'v-pills-profile-tab'; // Default to profile tab

    function updateSidebarContent() {
        if ($(window).width() < 992) {
            // Always update the content for small screens, regardless of previous state
            $('#settings-content').html(`
                <div class="nav flex-column nav-pills mt-2">
                    <button class="nav-link ${lastClickedTab === 'v-pills-profile-tab' ? 'active' : ''}" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                        <span class="ms-3">Profile</span>
                    </button>
                    <button class="nav-link ${lastClickedTab === 'v-pills-account-tab' ? 'active' : ''}" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab" aria-controls="v-pills-account" aria-selected="false">
                        <span class="ms-3">Account</span>
                    </button>
                    <button class="nav-link ${lastClickedTab === 'v-pills-preferences-tab' ? 'active' : ''}" id="v-pills-preferences-tab" data-bs-toggle="pill" data-bs-target="#v-pills-preferences" type="button" role="tab" aria-controls="v-pills-preferences" aria-selected="false">
                        <span class="ms-3">Preferences</span>
                    </button>
                    <button class="nav-link ${lastClickedTab === 'v-pills-privacy-tab' ? 'active' : ''}" id="v-pills-privacy-tab" data-bs-toggle="pill" data-bs-target="#v-pills-privacy" type="button" role="tab" aria-controls="v-pills-privacy" aria-selected="false">
                        <span class="ms-3">Privacy and Security</span>
                    </button>
                </div>
            `);
            $('#settings-content').addClass('show');
            $('.main-content').css('margin-left', '0');
            
            // Force show the content in mobile view if Settings is expanded
            if ($('#attendnav').hasClass('show')) {
                $('#settings-content').show();
            }
        } else {
            $('#settings-content').removeClass('show');
            $('#settings-content').html('');
            $('.main-content').css('margin-left', '320px');
        }
        addNavLinkEventListeners();
        showContentBasedOnLastClickedTab();
    }

    function addNavLinkEventListeners() {
        $('.nav-link').off('click').on('click', function () {
            const clickedTabId = $(this).attr('id');
            if (clickedTabId.startsWith('v-pills-')) { // Check if the clicked button is a sidebar button
                lastClickedTab = clickedTabId; // Store the last clicked tab's ID
                $('.main-content').addClass('d-none'); // Hide all main content sections
                if (lastClickedTab === 'v-pills-profile-tab') {
                    $('#profile-content').removeClass('d-none');
                } else if (lastClickedTab === 'v-pills-account-tab') {
                    $('#account-content').removeClass('d-none');
                } else if (lastClickedTab === 'v-pills-preferences-tab') {
                    $('#preferences-content').removeClass('d-none');
                } else if (lastClickedTab === 'v-pills-privacy-tab') {
                    $('#privacy-content').removeClass('d-none');
                }
            }
        });
    }

    function showContentBasedOnLastClickedTab() {
        $('.main-content').addClass('d-none'); // Hide all main content sections
        if (lastClickedTab === 'v-pills-profile-tab') {
            $('#profile-content').removeClass('d-none');
        } else if (lastClickedTab === 'v-pills-account-tab') {
            $('#account-content').removeClass('d-none');
        } else if (lastClickedTab === 'v-pills-preferences-tab') {
            $('#preferences-content').removeClass('d-none');
        } else if (lastClickedTab === 'v-pills-privacy-tab') {
            $('#privacy-content').removeClass('d-none');
        }
        $(`#${lastClickedTab}`).addClass('active').siblings().removeClass('active');
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

    // Add event listeners to the buttons
    addNavLinkEventListeners();
});
