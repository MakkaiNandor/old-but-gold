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
</style>