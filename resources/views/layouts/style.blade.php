<style>
    body {
        font-family: 'Public Sans', sans-serif;
        font-size: 13px !important;
        color: #343a40 !important;
    }

    .layout-wrapper {
        display: flex;
        min-height: 100vh;
    }

    .main-content {
        flex: 1;
        background-color: #f8f9fa;
    }

    a {
        text-decoration: none;
    }

    .btn {
        font-size: 12px !important;
        /* padding: 5px 15px !important; */
        border-radius: 6px !important;
    }

    .btn-sm {
        font-size: 11px !important;
    }

    .dropdown-item {
        font-size: 13px !important;
        padding: 8px 16px !important;
    }

    .dropdown-divider {
        border-top: 1px solid #dee2e6 !important;
        margin: 0;
    }

    .icon-10 {
        font-size: 10px !important;
    }

    .icon-13 {
        font-size: 13px !important;
    }

    .card {
        border: 0 !important;
        box-shadow: 0 0.1875rem 0.75rem 0 rgba(47, 43, 61, 0.14) !important;
    }

    .card-img-top {
        border-top-left-radius: 6px !important; 
        border-top-right-radius: 6px !important;
    }

    #image-preview {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
        margin-top: 10px;
        display: none;
    }

    .drop-area {
        display: flex;
        flex-direction: column;
        align-items: center;    /* center horizontally */
        justify-content: center; /* center vertically if you want */
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        position: relative;
        min-height: 150px; /* optional so container has some height */
    }

    .image-preview {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
        margin-top: 0px;
        display: none;
    }

    /* sidebar styling */
    .sidebar {
        width: 240px;
        flex-shrink: 0;
        background-color: #fff;
        border-right: 1px solid #dee2e6;
    }

    .nav-link {
        padding: 12px 14px;
        font-weight: 500;
        color: #343a40;
    }

    .nav-link.active {
        background-color: #c3ecec;
        color: #2c3b71;
    }

    .toggle-icon {
        filter: drop-shadow(0 0 1px rgba(0,0,0,0.3));
        transition: transform 0.3s ease;
    }

    .sidebar-icon-md {
        margin-right: 8px !important;
        font-size: 16px;
    }

    /* Rotate arrow when submenu is expanded */
    a[aria-expanded="true"] .toggle-icon {
        transform: rotate(90deg);
    }

    /* navbar styling */
    .bg-gradient-blue {
        background: linear-gradient(to right, #2c3b71, #0aaead);
        color: white;
    }

    .navbar .dropdown-item {
        font-weight: 500;
        color: #343a40;
    }

    /* color overwrite */
    .bg-primary {
        background-color: #2c3b71 !important;
    }

    .bg-light-second-primary {
        background-color: #0aaead !important;
    }
    .border-bottom-primary {
        border-bottom: 4px solid #2c3b71 !important; /* light teal/blue tone */
    }

    .text-primary {
        color: #2c3b71 !important;
    }

    .btn-primary {
        background-color: #2c3b71 !important;
        border-color: #2c3b71 !important;
    }

    /* dataTable style */
    table.dataTable thead tr th {
        padding: 12px 16px;
        text-transform: uppercase;
        border-top: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6 !important;
    }

    table.dataTable tbody tr td {
        padding: 12px 16px;
        border-bottom: 1px solid #dee2e6 !important;
    }

    .page-item {
        margin-left: 6px !important;
    }

    .page-item .page-link {
        font-size: 12px !important;
        border-radius: 6px !important;
        min-width: 30px !important;
        height: 30px !important;

    }

    .page-item.active .page-link {
        background-color: #2c3b71 !important;
        border-color: transparent !important;
    }

    .form-label {
        margin: 0 !important;
    }

    .form-control, .form-select {
        font-size: 13px !important;
        box-shadow: none !important;
    }

    .modal-header, .modal-footer {
        border: 0 !important;
    }


    /* toastr styling */
    .toast-success {
        opacity: 1 !important;
        background-color: #51a351 !important; /* Bootstrap success green */
    }

    .toast-error {
        opacity: 1 !important;
        background-color: #bd362f !important; /* Bootstrap danger red */
    }

    .toast-info {
        opacity: 1 !important;
        background-color: #2f96b4 !important; /* Bootstrap info blue */
    }

    .toast-warning {
        opacity: 1 !important;
        background-color: #f89406 !important; /* Bootstrap warning orange */
    }

    .login-container {
        display: flex;
        height: 100vh;
    }

    /* Image section */
    .image-side {
        flex: 3;
        overflow: hidden;
    }

    .carousel-item img {
        width: 100%;
        height: 100vh;
        object-fit: cover;
        object-position: center center !important;
    }

    /* Form section */
    .form-side {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        padding: 2rem;
        height: 100vh;
    }

    /* Responsive (stack for mobile) */
    @media (max-width: 992px) {
        .login-container {
            flex-direction: column;
        }

        .image-side {
            flex: none;
            height: 65vh;
        }

        .carousel-item img {
            height: 65vh;
            object-fit: cover;
            object-position: center center !important;
        }

        .form-side {
            flex: none;
            height: 35vh;
        }
    }
</style>