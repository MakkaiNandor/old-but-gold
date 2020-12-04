<template>
    <table id="my-map">
        <tr>
            <th v-for="(letter, index) in letters" :key="index">{{ letter }}</th>
        </tr>
        <tr v-for="row in numbers" :key="row" :id="'my-row-' + row">
            <td style="padding-right: 10px; font-weight: bold;">{{ row }}</td>
            <td v-for="col in numbers" :key="col">
                <div :id="'my-' + row + '-' + col" class="section">
                    <div v-if="map[row][col] == 1" class="ship-end-up"></div>
                    <div v-else-if="map[row][col] == -1" class="ship-end-left"></div>
                    <div v-else-if="map[row][col] == 2" class="ship-end-down"></div>
                    <div v-else-if="map[row][col] == -2" class="ship-end-right"></div>
                    <div v-else-if="map[row][col] == 3" class="ship-body-vertical"></div>
                    <div v-else-if="map[row][col] == -3" class="ship-body-horizontal"></div>
                </div>
            </td>
        </tr>
    </table>
</template>

<script>
    export default {
        props: {
            map: Array
        },
        data() {
            return {
                letters: ["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"],
                numbers: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }
        }
    }
</script>

<style>
    .section {
        position: relative;
        width: 38px;
        height: 38px;
        background-color: lightblue;
    }

    .ship-body-horizontal {
        position: absolute;
        background-color: brown;
        top: 2px;
        left: -1px;
        right: -1px;
        bottom: 2px;
    }

    .ship-body-vertical {
        position: absolute;
        background-color: brown;
        top: -1px;
        left: 2px;
        right: 2px;
        bottom: -1px;
    }

    .ship-end-up {
        position: absolute;
        background-color:brown;
        top: 2px;
        left: 2px;
        right: 2px;
        bottom: -1px;
        border-radius: 50px 50px 0 0;
    }

    .ship-end-down {
        position: absolute;
        background-color:brown;
        top: -1px;
        left: 2px;
        right: 2px;
        bottom: 2px;
        border-radius: 0 0 50px 50px;
    }

    .ship-end-left {
        position: absolute;
        background-color:brown;
        top: 2px;
        left: 2px;
        right: -1px;
        bottom: 2px;
        border-radius: 50px 0 0 50px;
    }

    .ship-end-right {
        position: absolute;
        background-color:brown;
        top: 2px;
        left: -1px;
        right: 2px;
        bottom: 2px;
        border-radius: 0 50px 50px 0;
    }
</style>