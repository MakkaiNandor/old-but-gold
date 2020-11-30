<template>
    <div id="ship-box">
        <div v-for="(ship, index) in ships" :key="index" :id="'ship-' + index + '-size-' + ship" class="ship rotate-ship" :style="'width: ' + ship * 38 + 'px;'" v-on:dragstart="drag($event)" draggable="true"></div>
    </div>
</template>

<script>
    export default {
        props: {
            ships: {
                type: Array,
                default: [5, 4, 3, 3, 2]
            }
        },
        methods: {
            drag(event){
                event.dataTransfer.setData("id", event.target.id);
                event.dataTransfer.setData("className", event.target.className);
            }
        }
    }
</script>

<style>
    #ship-box {
        height: 200px;
    }

    #ship-box .ship {
        display: inline-block;
        position: relative;
        height: 38px;
        border-radius: 50px;
        background-color: brown;
        margin-left: 5px;
        margin-right: 5px;
        margin-top: 50px;
        transition: transform 0.5s ease-out;
        cursor: move;
    }

    .rotate-ship {
        transform: rotate(90deg);
    }
</style>