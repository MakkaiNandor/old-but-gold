<template>
    <table id="enemy-map">
        <tr>
            <th v-for="(letter, index) in letters" :key="index">{{ letter }}</th>
        </tr>
        <tr v-for="row in numbers" :key="row" :id="'enemy-row-' + row">
            <td style="padding-right: 10px; font-weight: bold;">{{ row }}</td>
            <td v-for="col in numbers" :key="col">
                <div :id="'enemy-' + row + '-' + col" class="section shootable" v-on:click="sectionClicked($event)"></div>
            </td>
        </tr>
    </table>
</template>

<script>
    export default {
        data() {
            return {
                letters: ["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"],
                numbers: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }
        },
        methods: {
            sectionClicked(event){
                var temp = event.target.id.split('-');
                var row = parseInt(temp[1]);
                var col = parseInt(temp[2]);
                gameplay.myShot(row, col, event.target);
            }
        }
    }
</script>

<style>

</style>