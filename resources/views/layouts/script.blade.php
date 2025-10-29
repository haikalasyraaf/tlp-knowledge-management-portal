<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.3.2/af-2.7.0/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/cr-2.1.1/cc-1.0.7/date-1.5.6/fc-5.0.4/fh-4.0.3/kt-2.12.1/r-3.0.5/rg-1.5.2/rr-1.5.0/sc-2.4.3/sb-1.8.3/sp-2.3.4/sl-3.0.1/sr-1.4.1/datatables.min.js" integrity="sha384-yfkD8va9Znrrqcsxc6hNLsvosW5XNoVn3qADDMUKQV5nHvGcgfvrD3P/Gv4WSNmt" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal').forEach(modal => {
            // Blur focus before it's hidden
            modal.addEventListener('hide.bs.modal', () => {
                if (document.activeElement && modal.contains(document.activeElement)) {
                    document.activeElement.blur();
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropAreas = document.querySelectorAll('.drop-area');
        if (!dropAreas.length) return; // Stop if no drop-area found (safe for other pages)

        dropAreas.forEach(dropArea => {
            const fileInput = dropArea.querySelector('.program_image_path');
            const preview = dropArea.querySelector('.image-preview');
            const clearBtn = dropArea.closest('.modal-body')?.querySelector('.clear-image-btn');
            const dragDropText = dropArea.querySelector('.drag-drop-text');

            if (!fileInput || !preview || !clearBtn) return;

            dropArea.addEventListener('click', () => fileInput.click());

            dropArea.addEventListener('dragover', e => {
                e.preventDefault();
                dropArea.style.borderColor = '#007bff';
                dropArea.style.backgroundColor = '#e9f5ff';
            });

            dropArea.addEventListener('dragleave', e => {
                e.preventDefault();
                dropArea.style.borderColor = '#ccc';
                dropArea.style.backgroundColor = '';
            });

            dropArea.addEventListener('drop', e => {
                e.preventDefault();
                dropArea.style.borderColor = '#ccc';
                dropArea.style.backgroundColor = '';
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    showPreview(fileInput.files[0]);
                }
            });

            fileInput.addEventListener('change', () => {
                if (fileInput.files && fileInput.files[0]) {
                    showPreview(fileInput.files[0]);
                }
            });

            clearBtn.addEventListener('click', () => {
                fileInput.value = '';
                preview.src = '#';
                preview.style.display = 'none';
                clearBtn.style.display = 'none';
                dragDropText.style.display = 'inline-block';
                dropArea.style.borderColor = '#ccc';
                dropArea.style.backgroundColor = '';
            });

            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    clearBtn.style.display = 'inline-block';
                    dragDropText.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>

<script>
    function refreshIframe(iframe, src) {
        // Reload iframe if content not rendered properly
        setTimeout(() => {
            if (!iframe.contentDocument || iframe.contentDocument.body.innerHTML.trim() === '') {
                iframe.src = src; // force reload
            }
        }, 500); // small delay to allow initial load
    }

    $(document).on('click', '.view-doc-btn', function () {
        const fileUrl = this.dataset.file;
        const modalId = this.getAttribute('data-bs-target');
        const id = modalId.replace(/^#view.*Modal/, ''); // extract the training ID

        const iframe = document.getElementById('previewFrame' + id);
        const fallback = document.getElementById('downloadContainer' + id);
        const downloadBtn = document.getElementById('downloadBtn' + id);

        // Reset view
        iframe.style.display = 'none';
        fallback.style.display = 'none';
        iframe.src = '';

        const ext = fileUrl.split('.').pop().toLowerCase();
        const viewable = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'html', 'htm'];

        if (viewable.includes(ext)) {
            let src = fileUrl;

            if (ext === 'pdf') {
                src += '#toolbar=0&navpanes=0&scrollbar=0';
                iframe.src = src;
                refreshIframe(iframe, src);
            } 
            else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                const imgHTML = `
                    <html><body style="margin:0;overflow:hidden;">
                        <img src='${fileUrl}' style="width:100%;height:100%;object-fit:contain;">
                    </body></html>
                `;
                src = 'data:text/html;charset=utf-8,' + encodeURIComponent(imgHTML);
                iframe.src = src;
                refreshIframe(iframe, src);
            } 
            else {
                iframe.src = src;
                refreshIframe(iframe, src);
            }

            iframe.style.display = 'block';
        } else {
            downloadBtn.href = fileUrl;
            fallback.style.display = 'block';
        }
    });

    // Clear iframe when modal closes
    document.querySelectorAll('[id^="viewModal"]').forEach(modal => {
        modal.addEventListener('hidden.bs.modal', () => {
            const iframe = modal.querySelector('iframe');
            if (iframe) iframe.src = '';
        });
    });
</script>