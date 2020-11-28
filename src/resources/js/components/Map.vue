<template>
    <table>
        <map-header></map-header>
        <map-row v-for="n in 10" :key="n-1" :row="n-1"></map-row>
    </table>
</template>

<script>
    export default {
        
    }
</script>