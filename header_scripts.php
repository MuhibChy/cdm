<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- icheck bootstrap -->
<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<!-- JQVMap -->
<link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- summernote -->
<link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- BS Stepper -->
<link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
<!-- dropzonejs -->
<link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Custom styles -->
<style type="text/css">
    table.dataTable td,
    table.dataTable th,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-size: 12px;
    }
    .btn-group .dropdown-item {
        font-size: 12px;
    }
    .dt-button {
        font-size: 12px !important;
        border: 1px solid white;
        background-color: white;
        color: black;
        padding: 5px 10px;
        margin: 2px;
        transition: background-color 0.3s, color 0.3s;
    }
    .dt-button:hover {
        background-color: #f1f1f1;
        color: black;
    }
    .buttons-csv {
        background-color: #ff851b;
        color: white;
        border: none;
    }
    .buttons-csv:hover {
        background-color: #e07b17;
    }
    .buttons-excel {
        background-color: #3d9970;
        color: white;
        border: none;
    }
    .buttons-excel:hover {
        background-color: #35855d;
    }
    .buttons-pdf {
        background-color: #dc3545;
        color: white;
        border: none;
    }
    .buttons-pdf:hover {
        background-color: #c32b35;
    }
    .buttons-colvis {
        background-color: white;
        color: black;
        border: none;
    }
    .buttons-colvis:hover {
        background-color: #f1f1f1;
        color: black;
    }
    .btn-group .dropdown-item {
        font-size: 12px;
    }
    .btn-group {
        background-color: white;
        border: 1px solid white;
    }
    .btn-group .btn-xs {
        font-size: 12px;
        background-color: white;
        border: 1px solid white;
        color: black;
    }
    .btn-group .btn-xs:hover {
        background-color: #f1f1f1;
        color: black;
    }
    .fa {
        margin-right: 5px;
        transition: transform 0.3s;
    }
    .dt-button:hover .fa {
        transform: scale(1.2);
    }
    .role-filter {
        margin-bottom: 20px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: none;
        font-size: 10px;
    }
    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #14452f;
        border-color: #14452f;
    }
    .page-link {
        position: relative;
        display: block;
        padding: .5rem .75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: black;
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    .xhire-outline {
        border-top: 3px solid #18392b;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .xhire-redline {
        border-top: 3px solid #970101;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .xhire-grayline {
        border-top: 3px solid #535353;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    /* Buttons Colors */
    .xhire-success {
        background-color: #0f5132;
        color: white;
        font-size: 12px;
    }
    .xhire-success:hover {
        background-color: #14452f;
        color: white;
        font-size: 12px;
    }
    .xhire-danger {
        background-color: #ae0d01;
        color: white;
        font-size: 12px;
    }
    .xhire-danger:hover {
        background-color: #970101;
        color: white;
        font-size: 12px;
    }
    .xhire-secondary {
        background-color: #535353;
        color: white;
        font-size: 12px;
    }
    .xhire-secondary:hover {
        background-color: #2c2c2c;
        color: white;
        font-size: 12px;
    }
    .xhire-astros {
        background-color: #002D62;
        color: white;
        font-size: 12px;
    }
    .xhire-astros:hover {
        background-color: #002244;
        color: white;
        font-size: 12px;
    }
    .xhire-warning {
        background-color: #FFC72C;
        color: black;
        font-size: 12px;
    }
    .xhire-warning:hover {
        background-color: #FEBE10;
        color: black;
        font-size: 12px;
    }
    .xhire-info {
        background-color: #0076CE;
        color: white;
        font-size: 12px;
    }
    .xhire-info:hover {
        background-color: #1560bd;
        color: white;
        font-size: 12px;
    }
    .xhire-orange {
        background-color: #FF3800;
        color: white;
        font-size: 12px;
    }
    .xhire-orange:hover {
        background-color: #E25822;
        color: white;
        font-size: 12px;
    }
    /* Text Colors */
    .xhire-redex {
        color: #ae0d01;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    /* Badge Colors */
    .xhire-redning {
        background-color: #ae0d01;
        color: white;
        font-size: 10px;
        border-radius: 20%;
    }
    .xhire-bdgreen {
        background-color: #0f5132;
        color: white;
        font-size: 10px;
    }
    .xhire-bdblue {
        background-color: #1560bd;
        color: white;
        font-size: 10px;
    }
    .xhire-bdred {
        background-color: #ae0d01;
        color: white;
        font-size: 10px;
    }
    .xhire-bdyellow {
        background-color: #FFC72C;
        color: black;
        font-size: 10px;
    }
    .xhire-bdorange {
        background-color: #FF3800;
        color: white;
        font-size: 10px;
    }
    /* Card Colors */
    .xhire-carinfo {
        background: linear-gradient(0deg, rgba(0,118,206,1) 0%, rgba(21,96,189,1) 100%);
        color: white;
        font-size: 12px;
    }
    .xhire-carsuccess {
        background: linear-gradient(0deg, rgba(15,81,50,1) 0%, rgba(20,69,47,1) 100%);
        color: white;
        font-size: 12px;
    }
    .xhire-cardanger {
        background: linear-gradient(0deg, rgba(174,13,1,1) 0%, rgba(151,1,1,1) 100%);
        color: white;
        font-size: 12px;
    }
    .xhire-carwarning {
        background: linear-gradient(0deg, rgba(255,199,44,1) 0%, rgba(254,190,16,1) 100%);
        color: white;
        font-size: 12px;
    }
    .xhire-carflame {
        background: linear-gradient(0deg, rgba(255,56,0,1) 0%, rgba(226,88,34,1) 100%);
        color: white;
        font-size: 12px;
    }
    /* Define the keyframes for sliding gradient animation */
    @keyframes slideNavy {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideOlive {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideDanger {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideWarning {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideOrange {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideSuccess {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideDark {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideDarkRed {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    @keyframes slideSecondary {
        0% {
            background-position: 100% 0;
        }
        100% {
            background-position: 0% 0;
        }
    }
    /* Apply the animation classes to the table cells */
    .animation-navy {
        background: linear-gradient(45deg, #001f3f, #003366);
        background-size: 200% 200%;
        animation: slideNavy 10s linear infinite;
    }
    .animation-olive {
        background: linear-gradient(45deg, #3d9970, #2c6c40);
        background-size: 200% 200%;
        animation: slideOlive 10s linear infinite;
    }
    .animation-danger {
        background: linear-gradient(45deg, #dc3545, #a70000);
        background-size: 200% 200%;
        animation: slideDanger 10s linear infinite;
    }
    .animation-warning {
        background: linear-gradient(45deg, #ffc107, #e0a800);
        background-size: 200% 200%;
        animation: slideWarning 10s linear infinite;
    }
    .animation-orange {
        background: linear-gradient(45deg, #ff851b, #e06c00);
        background-size: 200% 200%;
        animation: slideOrange 10s linear infinite;
    }
    .animation-success {
        background: linear-gradient(45deg, #28a745, #1e7e34);
        background-size: 200% 200%;
        animation: slideSuccess 10s linear infinite;
    }
    .animation-dark {
        background: linear-gradient(45deg, #343a40, #212529);
        background-size: 200% 200%;
        animation: slideDark 10s linear infinite;
    }
    .animation-dark-red {
        background: linear-gradient(45deg, #8B0000, #600000);
        background-size: 200% 200%;
        animation: slideDarkRed 10s linear infinite;
    }
    .animation-secondary {
        background: linear-gradient(45deg, #6c757d, #5a6268);
        background-size: 200% 200%;
        animation: slideSecondary 10s linear infinite;
    }
</style>
<!-- Logout confirmation script -->
<script type="text/javascript">
    function confirmLogout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = "logout.php";
        }
    }
</script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
