<script setup lang="ts">
defineProps<{
    title: string
    imagePath: string
}>()
</script>

<style lang="css" scoped>
    img{
        border-radius: 50%;
    }
</style>

<template>
    <div style="display: flex;flex-direction: row;direction: ltr; height: 65px;">
        <img :src="'/storage/img/'+imagePath" alt="message icon" height="auto" width="auto"> 
        <div style="padding-left: 10px;">
            <h1 style="font-size: 20px;color: white;">{{title}}</h1>
        </div>
    </div>
</template>