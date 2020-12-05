<template>
    <div class="container">
        <div id="user-info" class="row text-center h5">
            <div class="col">{{ "Lvl. " + user.level }}</div>
            <div class="col font-weight-bold h4">{{ user.username }}</div>
            <div class="col">{{ "Played games: " + user.played_games }}</div>
            <div class="col">{{ "Victories: " + user.victories }}</div>
            <div class="col">{{ "Defeats: " + user.defeats }}</div>
        </div>
        <div id="buttons" class="text-center">
            <my-button :route="sp_route" text="Singleplayer" :big_button="true"></my-button>
            <my-button :route="mp_route" text="Multiplayer" :big_button="true"></my-button>
        </div>
        <div class="rules">
            Now only the singleplayer mode is available.<br>
            If you click the <strong>singleplayer</strong> button, you can play Battleship's singleplayer mode against the <strong>computer</strong>. <br>
            The object of Battleship is to try and sink all of the <strong>computer's</strong> before he sink all of your ships. You try and hit them by clicking the squares on the sea. The <strong>computer</strong> also tries to hit your ships.<br>  
            Each player places the 5 ships somewhere on their sea. The ships can only be placed vertically or horizontally. Diagonal placement is not allowed. No part of a ship may hang off the edge of the sea.  Ships may not overlap each other.<br>
            Your data will be saved. You can check statistics or your profile if you want. 
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user_data: {
                type: String,
                required: true
            },
            sp_route: {
                type: String,
                default: "#"
            },
            mp_route: {
                type:String,
                default: "#"
            }
        },
        data() {
            return {
                user: {}
            }
        },
        mounted() {
            this.parseUser();
        },
        methods: {
            parseUser() {
                this.user = JSON.parse(this.user_data);
            }
        }
    }
</script>

<style>
    #user-info {
        border-bottom: 1px solid black;
    }

    #buttons {
        width: max-content;
        margin-left: auto;
        margin-right: auto;
        margin-top: 10%;
    }
    .rules{
        margin-top: 20px;
        word-wrap: break-word;
        text-align: center;
    }
</style>