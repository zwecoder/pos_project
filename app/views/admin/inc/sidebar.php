<?php
$page = $_SERVER['REQUEST_URI'];
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= $page == '/admin' ? 'active' : ''; ?>" href="/admin">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <!-- create order -->
                <a class="nav-link <?= $page == '/admin/order_create' ? 'active' : ''; ?>" href="/admin/order_create">
                    <div class="sb-nav-link-icon"><i class="fas fa-bell"></i></div>
                    Create Order
                </a>
                <!--  order -->
                <a class="nav-link <?= $page == '/admin/orders' ? 'active' : ''; ?>" href="/admin/orders">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Orders
                </a>
                <div class="sb-sidenav-menu-heading">Interface</div>
                <!--  category -->
                <a class="nav-link  <?= ($page == '/admin/cat_create' || $page == '/admin/cat_view') ? 'collapse active' : 'collapsed'; ?>"
                    href=" #"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Categories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == '/admin/cat_create' || $page == '/admin/cat_view') ? 'show' : ''; ?>"
                    id="collapseCategory"
                    aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == '/admin/cat_create' ? 'active' : ''; ?>" href="/admin/cat_create">Create Category</a>
                        <a class="nav-link <?= $page == '/admin/cat_view' ? 'active' : ''; ?>" href="/admin/cat_view">View Category</a>
                    </nav>
                </div>
                <!--  product -->
                <a class="nav-link <?= ($page == '/admin/product_create' || $page == '/admin/product_view') ? 'collapse active' : 'collapsed'; ?>" href="#"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Products
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == '/admin/product_create' || $page == '/admin/product_view') ? 'show' : ''; ?>"
                    id="collapseProduct"
                    aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == '/admin/product_create' ? 'active' : ''; ?>" href="/admin/product_create">Create Product</a>
                        <a class="nav-link <?= $page == '/admin/product_view' ? 'active' : ''; ?>" href="/admin/product_view">View Product</a>
                    </nav>
                </div>
                <!--  manage user -->
                <div class="sb-sidenav-menu-heading">Mange Users</div>
                <!--  manage user end-->
                <!--  admin  -->
                <a class="nav-link <?= ($page == '/admin/ad_create' || $page == '/admin/ad_view') ? 'collapse active' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmins" aria-expanded="false" aria-controls="collapseAdmins">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Admins/Staff
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == '/admin/ad_create' || $page == '/admin/ad_view') ? 'show' : ''; ?>"
                    id="collapseAdmins"
                    aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == '/admin/ad_create' ? 'active' : ''; ?>" href="/admin/ad_create">Add Admins</a>
                        <a class="nav-link <?= $page == '/admin/ad_view' ? 'active' : ''; ?>" href="/admin/ad_view">View Admins</a>
                    </nav>
                </div>
                <!-- customer -->
                <a class="nav-link <?= ($page == '/admin/customer_create' || $page == '/admin/customer_view') ? 'collapse active' : 'collapsed'; ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCustomers" aria-expanded="false" aria-controls="collapseAdmins">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Customers
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= ($page == '/admin/customer_create' || $page == '/admin/customer_view') ? 'show' : ''; ?>"
                    id="collapseCustomers"
                    aria-labelledby="headingOne"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= $page == '/admin/customer_create' ? 'active' : ''; ?>" href="/admin/customer_create">Add Customers</a>
                        <a class="nav-link <?= $page == '/admin/customer_view' ? 'active' : ''; ?>" href="/admin/customer_view">View Customers</a>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            moon corp
        </div>
    </nav>
</div>