<template>
    <tr>
        <th v-for="(letter, index) in letters" :key="index">{{ letter }}</th>
    </tr>
</template>

<script>
    export default {
        data() {
            return {
                letters: ["", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"]
            }
        }
    }
</script>