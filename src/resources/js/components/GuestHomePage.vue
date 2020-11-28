<template>
    <div class="container text-center">
        <p class="mt-5 h4">The Battelship game is the best in the world, try it yourself now as guest or you can registrate!</p>
        <p><img :src="logo" alt="image"></p>
        <my-button :route="route" text="Play as Guest"></my-button>
    </div>
</template>

<script>
import MyButton from './MyButton.vue'
    export default {
  components: { MyButton },
        props: {
            logo: {
                type: String,
                required: true
            },
            route: {
                type: String,
                required: true
            }
        },
        mounted() {
            console.log("Guest home page mounted!")
        }
    }
</script>