<template>
    <nav class="navbar navbar-light navbar-expand-lg">
        <router-link to="/" class="navbar-brand">E-Commerce</router-link>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">Contact Us</a>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">About Us</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <router-link to="/register" class="nav-link">Register</router-link>
            </li>
            <li class="nav-item">
                <a href="" class="nav-link">Login</a>
            </li>
        </ul>
    </nav>
</template>
