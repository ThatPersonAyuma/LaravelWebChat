<script setup lang="ts">
    import { toRef } from 'vue';

    const props = defineProps<{username: string, message: string}>()
    const username = toRef(props, 'username');
    const message = toRef(props, 'message');
</script>

<style scoped>
    .message-container {
        display: grid;
        grid-template-rows: 20px auto;
    }
    .username {
        background-color: blue;
        font-weight: bold;
        font-size: 14px;
        color: #555;
    }
    .message {
        background-color: green;
        font-size: 16px;
    }
</style>

<template>
    <div class="message-container">
        <span class="username">{{ username }}</span>
        <span class="message">{{ message }}</span>
    </div>
</template>