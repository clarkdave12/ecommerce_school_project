<template>
    <div>
        <h2>Logging out</h2>
    </div>
</template>

<script>
export default {
    mounted () {
        const d = new Date()
        d.setTime(d.getTime() + (-1 * 24 * 60 * 60 * 1000));
        const expires = d.toUTCString();
        document.cookie = 'access_token=;expires=' + expires;
        window.localStorage.removeItem('access_token')
    }
}
</script>