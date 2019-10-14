<template>
    <div class="container">
        <nav class="navbar navbar-light navbar-expand-lg">

            <!-- Left Side -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link to="/admin/categories" class="nav-link">Categories</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/products" class="nav-link">Products</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/users" class="nav-link">Users</router-link>
                </li>
            </ul>

            <!-- Right Side -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="" class="nav-link">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
</template>