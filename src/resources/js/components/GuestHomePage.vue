<template>
    <div class="container text-center">
        <p class="mt-5 h4">The Battelship game is the best in the world, try it yourself now as guest or you can registrate!</p>
        <p><img :src="logo" alt="image"></p>
        <my-button :route="route" text="Play as Guest"></my-button>
    </div>
</template>

<script>
    export default {
        props: {
            logo: {
                type: String,
                required: true
            },
            route: {
                type: String,
                required: true
            }
        }
    }
</script>