<template>
    <div class="container">
        <nav class="navbar navbar-light navbar-expand-md">

            <!-- Left Side -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link to="/admin/categories" class="nav-link" id="link">Categories</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/users" class="nav-link" id="link">Users</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/products" class="nav-link" id="link">Products</router-link>
                </li>
                <li class="nav-item">
                    <router-link to="/admin/products/add" class="nav-link" id="link">Add Product</router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<style scoped>
    #link {
        font-size: 1.2em;
        font-weight: 400;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #ffffff;
    }
</style>
