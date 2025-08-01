<script setup lang="ts">
  import { onMounted, ref, onBeforeMount, toRef } from 'vue';
  import axios from 'axios';
  import { useEchoPublic } from '@laravel/echo-vue';
  import { User } from '@/types';

  const message = ref('');
  const messages = ref<string[]>([]);
  const props = defineProps<{user: User}>()
  const user = toRef(props, 'user');

  function handleSubmit(e: Event) {
    e.preventDefault();
    if (!message.value.trim()) return;
    messages.value.push(message.value.trim());
    // Post
    newMessage();
    message.value = '';
  }
  onMounted(()=>{
    console.log("Yeyyy");
    console.log(`Contenct ${user.value.name}`);
    window.Echo.channel('ChatRoom')
    .listen('.MessageSent', (event: any) => {
        console.log('New message:', event.message);
        messages.value.push(event.message);
    });
  })
  const newMessage = async () => {
    if (!message.value.trim()) return;
    await axios.post('/send-message', {
      message: message.value,
    })
  }
</script>

<style lang="css" scoped>
    .message {
      max-width: 75%;
      padding: 12px 16px;
      border-radius: 20px;
      line-height: 1.4;
      font-size: 0.95rem;
      word-wrap: break-word;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
      user-select: text;
      background-color: grey;
    }
</style>

<template>
    <form  @submit="handleSubmit" style="display: flex; width: 100%; height: 100vh;flex-direction: column;background-color: white;">
        <div style="height: 80px; width: 100%;flex: none;background-color: black;">
            <h1 style="font-size: 50px; text-align: center;">Judul Group Chat</h1>
        </div>
        <div style="flex: 1;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            overflow-y: auto;">
        <div v-for="(msg, i) in messages" :key="i" class="message">{{ msg }}</div>
        </div>
        <div style="padding: 0 5px;">
        <div style="height: 65px;
                    width: 100%;
                    background-color: darkgray;
                    flex: none;
                    display: flex;
                    flex-direction: row;
                    border-radius: 20px;
                    padding: 0 5px;">
            <input v-model="message" style="flex: 1;outline:none;" placeholder="Ketik pesan..." />
            <button type="submit" class="send-button" id="sendButton" style="min-width: 25px; height: 100%;padding-right: 5px; cursor:pointer;">Send</button>
        </div>
        </div>
    </form>
            
</template>