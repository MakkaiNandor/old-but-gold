<template>
    <div class="container text-center">
        <p class="mt-5 h4">The Battelship game is the best in the world, try it yourself now as guest or you can register!</p>
        <p><img :src="logo" alt="image"></p>
        <my-button :route="route" text="Play as Guest"></my-button>
        <div class="rules">
            If you click the <strong>play as guest</strong> button, you can play Battleship's singleplayer mode against the <strong>computer</strong>. <br>
            The object of Battleship is to try and sink all of the <strong>computer's</strong> before he sink all of your ships. You try and hit them by clicking the squares on the sea. The <strong>computer</strong> also tries to hit your ships.<br>  
            Each player places the 5 ships somewhere on their sea. The ships can only be placed vertically or horizontally. Diagonal placement is not allowed. No part of a ship may hang off the edge of the sea.  Ships may not overlap each other.<br>
            Your data will not be saved, if you want you can register or login. 
        </div>
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

<style>
    .rules{
        margin-top: 20px;
        word-wrap: break-word;
    }
</style>