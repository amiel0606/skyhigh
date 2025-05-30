<?php include_once('./includes/header.php'); ?>
<?php include './includes/notification.php'; ?>
<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ./login.php');
    exit();
}

// Fetch current content
include_once('./controller/getContent.php');
?>

<div class="main-content">
    <div class="container">
        <h1 class="title is-2">Content Management</h1>
        
        <div class="columns">
            <div class="column">
                <div class="box">
                    <h2 class="title is-4">Website Content</h2>
                    
                    <form id="contentForm" enctype="multipart/form-data">
                        <!-- About Us Section -->
                        <div class="field">
                            <label class="label">About Us</label>
                            <div class="control">
                                <div id="aboutUs"><?php echo $content['about_us'] ?? ''; ?></div>
                            </div>
                        </div>

                        <!-- Logo Title -->
                        <div class="field">
                            <label class="label">Logo Title</label>
                            <div class="control">
                                <div id="logoTitle"><?php echo $content['logo_title'] ?? ''; ?></div>
                            </div>
                        </div>

                        <!-- Logo Subtitle -->
                        <div class="field">
                            <label class="label">Logo Subtitle</label>
                            <div class="control">
                                <div id="logoSubtitle"><?php echo $content['logo_subtitle'] ?? ''; ?></div>
                            </div>
                        </div>

                        <!-- FAQs Section -->
                        <div class="field">
                            <label class="label">FAQs</label>
                            <div class="control">
                                <div id="faqs"><?php echo $content['faqs'] ?? ''; ?></div>
                            </div>
                        </div>

                        <!-- Logo Picture Upload -->
                        <div class="field">
                            <label class="label">Logo Picture</label>
                            <div class="control">
                                <div class="file has-name">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="logoPicture" id="logoPicture" accept="image/*">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose logo image...</span>
                                        </span>
                                        <span class="file-name" id="logoFileName">
                                            <?php echo $content['logo_picture'] ?? 'No file selected'; ?>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <?php if (!empty($content['logo_picture'])): ?>
                                <div class="mt-3">
                                    <img src="./uploads/<?php echo $content['logo_picture']; ?>" alt="Current Logo" style="max-width: 200px; height: auto;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Background Picture Upload -->
                        <div class="field">
                            <label class="label">Background Picture</label>
                            <div class="control">
                                <div class="file has-name">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="backgroundPicture" id="backgroundPicture" accept="image/*">
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose background image...</span>
                                        </span>
                                        <span class="file-name" id="backgroundFileName">
                                            <?php echo $content['background_picture'] ?? 'No file selected'; ?>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <?php if (!empty($content['background_picture'])): ?>
                                <div class="mt-3">
                                    <img src="./uploads/<?php echo $content['background_picture']; ?>" alt="Current Background" style="max-width: 200px; height: auto;">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-primary">
                                    <span class="icon">
                                        <i class="fas fa-save"></i>
                                    </span>
                                    <span>Save Content</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CKEditor 5 with Font Color Features -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/decoupled-document/ckeditor.js"></script>

<style>
/* Custom styles for CKEditor */
.ck-editor__editable {
    min-height: 200px;
    border: 1px solid #dbdbdb;
    border-radius: 4px;
    padding: 15px;
}
.ck-toolbar {
    border: 1px solid #dbdbdb;
    border-bottom: none;
    border-radius: 4px 4px 0 0;
}
</style>

<script>
// Initialize CKEditor for each textarea
let aboutUsEditor, logoTitleEditor, logoSubtitleEditor, faqsEditor;

// About Us Editor with full features
DecoupledEditor
    .create(document.querySelector('#aboutUs'), {
        toolbar: [
            'heading', '|',
            'fontSize', 'fontFamily', '|',
            'fontColor', 'fontBackgroundColor', '|',
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'alignment', '|',
            'numberedList', 'bulletedList', '|',
            'outdent', 'indent', '|',
            'link', 'blockQuote', 'insertTable', '|',
            'undo', 'redo'
        ],
        fontSize: {
            options: [
                9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36
            ]
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ]
        },
        fontColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 0%, 30%)',
                    label: 'Dim grey'
                },
                {
                    color: 'hsl(0, 0%, 60%)',
                    label: 'Grey'
                },
                {
                    color: 'hsl(0, 0%, 90%)',
                    label: 'Light grey'
                },
                {
                    color: 'hsl(0, 0%, 100%)',
                    label: 'White',
                    hasBorder: true
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(90, 75%, 60%)',
                    label: 'Light green'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(150, 75%, 60%)',
                    label: 'Aquamarine'
                },
                {
                    color: 'hsl(180, 75%, 60%)',
                    label: 'Turquoise'
                },
                {
                    color: 'hsl(210, 75%, 60%)',
                    label: 'Light blue'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        },
        fontBackgroundColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 0%, 30%)',
                    label: 'Dim grey'
                },
                {
                    color: 'hsl(0, 0%, 60%)',
                    label: 'Grey'
                },
                {
                    color: 'hsl(0, 0%, 90%)',
                    label: 'Light grey'
                },
                {
                    color: 'hsl(0, 0%, 100%)',
                    label: 'White',
                    hasBorder: true
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(90, 75%, 60%)',
                    label: 'Light green'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(150, 75%, 60%)',
                    label: 'Aquamarine'
                },
                {
                    color: 'hsl(180, 75%, 60%)',
                    label: 'Turquoise'
                },
                {
                    color: 'hsl(210, 75%, 60%)',
                    label: 'Light blue'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        }
    })
    .then(editor => {
        aboutUsEditor = editor;
        
        // Add toolbar to the page
        const toolbarContainer = document.createElement('div');
        toolbarContainer.id = 'aboutUs-toolbar';
        document.querySelector('#aboutUs').parentNode.insertBefore(toolbarContainer, document.querySelector('#aboutUs'));
        toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        
        console.log('About Us editor loaded successfully');
    })
    .catch(error => {
        console.error('Error loading About Us editor:', error);
    });

// Logo Title Editor
DecoupledEditor
    .create(document.querySelector('#logoTitle'), {
        toolbar: [
            'fontSize', 'fontFamily', '|',
            'fontColor', 'fontBackgroundColor', '|',
            'bold', 'italic', 'underline', '|',
            'link', '|',
            'undo', 'redo'
        ],
        fontSize: {
            options: [
                9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36
            ]
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ]
        },
        fontColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        },
        fontBackgroundColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        }
    })
    .then(editor => {
        logoTitleEditor = editor;
        
        // Add toolbar to the page
        const toolbarContainer = document.createElement('div');
        toolbarContainer.id = 'logoTitle-toolbar';
        document.querySelector('#logoTitle').parentNode.insertBefore(toolbarContainer, document.querySelector('#logoTitle'));
        toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        
        console.log('Logo Title editor loaded successfully');
    })
    .catch(error => {
        console.error('Error loading Logo Title editor:', error);
    });

// Logo Subtitle Editor
DecoupledEditor
    .create(document.querySelector('#logoSubtitle'), {
        toolbar: [
            'fontSize', 'fontFamily', '|',
            'fontColor', 'fontBackgroundColor', '|',
            'bold', 'italic', 'underline', '|',
            'link', '|',
            'undo', 'redo'
        ],
        fontSize: {
            options: [
                9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36
            ]
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ]
        },
        fontColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        },
        fontBackgroundColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        }
    })
    .then(editor => {
        logoSubtitleEditor = editor;
        
        // Add toolbar to the page
        const toolbarContainer = document.createElement('div');
        toolbarContainer.id = 'logoSubtitle-toolbar';
        document.querySelector('#logoSubtitle').parentNode.insertBefore(toolbarContainer, document.querySelector('#logoSubtitle'));
        toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        
        console.log('Logo Subtitle editor loaded successfully');
    })
    .catch(error => {
        console.error('Error loading Logo Subtitle editor:', error);
    });

// FAQs Editor
DecoupledEditor
    .create(document.querySelector('#faqs'), {
        toolbar: [
            'heading', '|',
            'fontSize', 'fontFamily', '|',
            'fontColor', 'fontBackgroundColor', '|',
            'bold', 'italic', 'underline', 'strikethrough', '|',
            'alignment', '|',
            'numberedList', 'bulletedList', '|',
            'outdent', 'indent', '|',
            'link', 'blockQuote', 'insertTable', '|',
            'undo', 'redo'
        ],
        fontSize: {
            options: [
                9, 10, 11, 12, 13, 14, 15, 16, 18, 20, 22, 24, 26, 28, 30, 32, 34, 36
            ]
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ]
        },
        fontColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 0%, 30%)',
                    label: 'Dim grey'
                },
                {
                    color: 'hsl(0, 0%, 60%)',
                    label: 'Grey'
                },
                {
                    color: 'hsl(0, 0%, 90%)',
                    label: 'Light grey'
                },
                {
                    color: 'hsl(0, 0%, 100%)',
                    label: 'White',
                    hasBorder: true
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(90, 75%, 60%)',
                    label: 'Light green'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(150, 75%, 60%)',
                    label: 'Aquamarine'
                },
                {
                    color: 'hsl(180, 75%, 60%)',
                    label: 'Turquoise'
                },
                {
                    color: 'hsl(210, 75%, 60%)',
                    label: 'Light blue'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        },
        fontBackgroundColor: {
            colors: [
                {
                    color: 'hsl(0, 0%, 0%)',
                    label: 'Black'
                },
                {
                    color: 'hsl(0, 0%, 30%)',
                    label: 'Dim grey'
                },
                {
                    color: 'hsl(0, 0%, 60%)',
                    label: 'Grey'
                },
                {
                    color: 'hsl(0, 0%, 90%)',
                    label: 'Light grey'
                },
                {
                    color: 'hsl(0, 0%, 100%)',
                    label: 'White',
                    hasBorder: true
                },
                {
                    color: 'hsl(0, 75%, 60%)',
                    label: 'Red'
                },
                {
                    color: 'hsl(30, 75%, 60%)',
                    label: 'Orange'
                },
                {
                    color: 'hsl(60, 75%, 60%)',
                    label: 'Yellow'
                },
                {
                    color: 'hsl(90, 75%, 60%)',
                    label: 'Light green'
                },
                {
                    color: 'hsl(120, 75%, 60%)',
                    label: 'Green'
                },
                {
                    color: 'hsl(150, 75%, 60%)',
                    label: 'Aquamarine'
                },
                {
                    color: 'hsl(180, 75%, 60%)',
                    label: 'Turquoise'
                },
                {
                    color: 'hsl(210, 75%, 60%)',
                    label: 'Light blue'
                },
                {
                    color: 'hsl(240, 75%, 60%)',
                    label: 'Blue'
                },
                {
                    color: 'hsl(270, 75%, 60%)',
                    label: 'Purple'
                }
            ]
        }
    })
    .then(editor => {
        faqsEditor = editor;
        
        // Add toolbar to the page
        const toolbarContainer = document.createElement('div');
        toolbarContainer.id = 'faqs-toolbar';
        document.querySelector('#faqs').parentNode.insertBefore(toolbarContainer, document.querySelector('#faqs'));
        toolbarContainer.appendChild(editor.ui.view.toolbar.element);
        
        console.log('FAQs editor loaded successfully');
    })
    .catch(error => {
        console.error('Error loading FAQs editor:', error);
    });

// File input handlers
document.getElementById('logoPicture').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'No file selected';
    document.getElementById('logoFileName').textContent = fileName;
});

document.getElementById('backgroundPicture').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'No file selected';
    document.getElementById('backgroundFileName').textContent = fileName;
});

// Form submission
document.getElementById('contentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('aboutUs', aboutUsEditor.getData());
    formData.append('logoTitle', logoTitleEditor.getData());
    formData.append('logoSubtitle', logoSubtitleEditor.getData());
    formData.append('faqs', faqsEditor.getData());
    
    // Add files if selected
    const logoFile = document.getElementById('logoPicture').files[0];
    const backgroundFile = document.getElementById('backgroundPicture').files[0];
    
    if (logoFile) {
        formData.append('logoPicture', logoFile);
    }
    if (backgroundFile) {
        formData.append('backgroundPicture', backgroundFile);
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="icon"><i class="fas fa-spinner fa-spin"></i></span><span>Saving...</span>';
    submitBtn.disabled = true;
    
    fetch('./controller/updateContent.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success notification
            showNotification('Content updated successfully!', 'success');
            // Reload page to show updated images
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Error updating content', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error updating content', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

// Notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification is-${type === 'success' ? 'success' : 'danger'}`;
    notification.innerHTML = `
        <button class="delete"></button>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    // Position the notification
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    
    // Add delete functionality
    notification.querySelector('.delete').addEventListener('click', () => {
        notification.remove();
    });
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>

<?php include_once('./includes/footer.php'); ?>