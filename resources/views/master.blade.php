<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{asset('')}}">
    <meta id="token" name="csrf-token" content="{{csrf_token()}}">
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Dashboard</title>

    <!-- Fontfaces CSS-->
    <link  href="public_admin/css/material-design-iconic-font.min.css" rel="stylesheet" >
    <link href="public_admin/css/font-face.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="public_admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="public_admin/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="public_admin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="public_admin/css/theme.css" rel="stylesheet" media="all">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

</head>

    <body class="animsition">
        <div class="page-wrapper">
            @yield('content')
        </div>




        <!-- Jquery JS-->
        <script src="public_admin/vendor/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="public_admin/vendor/bootstrap-4.1/popper.min.js"></script>
        <script src="public_admin/vendor/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="public_admin/vendor/slick/slick.min.js">
        </script>
        <script src="public_admin/vendor/wow/wow.min.js"></script>
        <script src="public_admin/vendor/animsition/animsition.min.js"></script>
        <script src="public_admin/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
        </script>
        <script src="public_admin/vendor/counter-up/jquery.waypoints.min.js"></script>
        <script src="public_admin/vendor/counter-up/jquery.counterup.min.js">
        </script>
        <script src="public_admin/vendor/circle-progress/circle-progress.min.js"></script>
        <script src="public_admin/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="public_admin/vendor/chartjs/Chart.bundle.min.js"></script>
        <script src="public_admin/vendor/select2/select2.min.js">
        </script>
        <!-- Main JS-->
        <script src="public_admin/js/main.js"></script>
        @yield('script')
    </body>
</html>
<!-- end document-->
