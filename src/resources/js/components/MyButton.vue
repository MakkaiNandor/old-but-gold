<template>
    <a v-if="big_button" :id="id" :href="route" class="my-button big-button card mx-5">{{ text }}</a>
    <a v-else :id="id" :href="route" class="my-button card">{{ text }}</a>
</template>

<script>
    export default {
        props: {
            id: {
                type: String,
                default: ''
            },
            route: {
                type: String,
                default: "#"
            },
            text: {
                type: String,
                default: "Button"
            },
            big_button: {
                type: Boolean,
                default: false
            }
        }
    }
</script>

<style>
    .my-button {
        display: inline-block;
        text-decoration: none;
        color: black;
        padding: 20px;
        border: 1px solid black;
        border-radius: 50px;
        font-size: 18pt;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        cursor: pointer;
        user-select: none;
    }

    .my-button:hover {
        box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
        text-decoration: none;
        color: black;
    }

    .big-button {
        width: 200px;
        height: 300px;
        line-height: 280px;
    }

</style>