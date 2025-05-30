<?php
include_once './includes/header.php';
?>
<style>
    .content {
        width: 1800px;
    }
    
    .faq-content {
        line-height: 1.6;
    }
    
    .faq-content h1, .faq-content h2, .faq-content h3, .faq-content h4, .faq-content h5, .faq-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .faq-content p {
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

<p class="is-size-2 has-text-weight-bold">FAQs.</p>
<div id="faqContent" class="ml-6 is-size-5 faq-content">
    <div class="loading-spinner"></div> Loading FAQ content...
</div>

<script>
function loadFaqContent() {
    const content = window.getWebsiteContent();
    if (content) {
        updateFaqContent(content);
    } else {
        setTimeout(() => {
            const content = window.getWebsiteContent();
            if (content) {
                updateFaqContent(content);
            } else {
                fetch('./controllers/getContent.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateFaqContent(data.data);
                        } else {
                            document.getElementById('faqContent').innerHTML = 
                                '<h3>Frequently Asked Questions</h3><p><strong>Q: What services do you offer?</strong><br>A: We offer motorcycle repair, maintenance, parts sales, and customization services.</p><p><strong>Q: Do you work on all motorcycle brands?</strong><br>A: Yes, we work on all major motorcycle brands and models.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading FAQ content:', error);
                        document.getElementById('faqContent').innerHTML = 
                            '<h3>Frequently Asked Questions</h3><p><strong>Q: What services do you offer?</strong><br>A: We offer motorcycle repair, maintenance, parts sales, and customization services.</p><p><strong>Q: Do you work on all motorcycle brands?</strong><br>A: Yes, we work on all major motorcycle brands and models.</p>';
                    });
            }
        }, 500);
    }
}

// Function to update FAQ content
function updateFaqContent(content) {
    const faqContainer = document.getElementById('faqContent');
    if (faqContainer && content.faqs) {
        faqContainer.innerHTML = content.faqs;
    }
}

// Load content when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadFaqContent();
});
</script>

<script src="./js/changeWindows.js"></script>

<?php
include_once './includes/footer.php';
?>