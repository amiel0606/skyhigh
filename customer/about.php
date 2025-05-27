<?php
include_once './includes/header.php';
?>
<style>
    .content {
        width: 1200px;
    }
    
    .about-content {
        line-height: 1.6;
    }
    
    .about-content h1, .about-content h2, .about-content h3, .about-content h4, .about-content h5, .about-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .about-content p {
        margin-bottom: 1rem;
    }
    
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<p class="is-size-2 has-text-weight-bold">About Us.</p>
<div id="aboutUsContent" class="ml-6 is-size-5 about-content">
    <div class="loading-spinner"></div> Loading content...
</div>

<script>
function loadAboutContent() {
    const content = window.getWebsiteContent();
    if (content) {
        updateAboutContent(content);
    } else {
        setTimeout(() => {
            const content = window.getWebsiteContent();
            if (content) {
                updateAboutContent(content);
            } else {
                fetch('./controllers/getContent.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateAboutContent(data.data);
                        } else {
                            document.getElementById('aboutUsContent').innerHTML = 
                                'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading about content:', error);
                        document.getElementById('aboutUsContent').innerHTML = 
                            'Welcome to SkyHigh Motorcycle - your premier destination for motorcycle services and parts.';
                    });
            }
        }, 500);
    }
}

// Function to update about content
function updateAboutContent(content) {
    const aboutContainer = document.getElementById('aboutUsContent');
    if (aboutContainer && content.about_us) {
        aboutContainer.innerHTML = content.about_us;
    }
}

// Load content when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadAboutContent();
});
</script>

<script src="./js/changeWindows.js"></script>

<?php
include_once './includes/footer.php';
?>