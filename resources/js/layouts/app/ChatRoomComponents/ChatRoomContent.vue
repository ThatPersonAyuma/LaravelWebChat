<script setup lang="ts">
  import { onMounted, ref, onBeforeMount, toRef, computed, watch } from 'vue';
  import axios from 'axios';
  import { useEchoPublic } from '@laravel/echo-vue';
  import { ChatRoom, User } from '@/types';
  import Message from './Message.vue';

  const message = ref('');
  const messages = ref<any[]>([]);
  const props = defineProps<{user: User, chatRoom: ChatRoom|null}>()
  const user = toRef(props, 'user');
  const localChatRoom = toRef(props, 'chatRoom');

  function handleSubmit(e: Event) {
    e.preventDefault();
    if (!message.value.trim()) return;
    messages.value.push({Message:message.value.trim(), SenderName:user.value.name, SenderId: user.value.id});
    // Post
    newMessage();
    message.value = '';
  }
  onMounted(()=>{
    console.log("Chatroom", localChatRoom.value);
    console.log("Yeyyy");
    console.log(`Contenct ${user.value.name}`);
    window.Echo.channel('ChatRoom')
    .listen('.MessageSent', (event: any) => {
        console.log('New message:', event.message);
        if(String(event.SenderId) != String(user.value.id)){
          messages.value.push(event.message);
        }
    });
  })
  const newMessage = async () => {
    if (!message.value.trim()) return;
    await axios.post('/send-message', {
      message: message.value,
    })
  }
  watch(() => props.chatRoom, (val) => {
    localChatRoom.value = val;
    if (localChatRoom.value){
      getAllMessage(localChatRoom.value.ChatRoomId, localChatRoom.value.IsGroup);
    }
  });
  const getAllMessage = async (chat_room_id: number, is_group: boolean) => {
        try{
          let uri_string: string|null = null;
          // let params;
          if (is_group){
            console.log('chat_room_id:', chat_room_id);
            uri_string = '/api/get-user-cr-messages';
            // params= {chat_room_id:chat_room_id};
          }else{
            uri_string = '/api/get-user-cr-messages';
            // params= {};
          }
          if (uri_string){
            const response = await axios.get(uri_string, {
                params: {chat_room_id:chat_room_id}
            });
            messages.value = response.data.data_query // kalau .data aja bentuknya proxy target
            console.log('Berhasil query: ', messages.value);
            console.log('Berhasil response data: ', response.data);
            console.log(JSON.stringify(response.data, null, 2));
            for (const room of messages.value){
                console.log('Iterasi: ', room); // If you see a proxy data type just treat it as its type json, list etc
            }
          }
        }catch (err){
            console.error('Failed query: ', err);
        }
    }
</script>

<style lang="css" scoped>
    .message-container {
      max-width: 75%;
      padding: 12px 16px;
      border-radius: 20px;
      line-height: 1.4;
      font-size: 0.95rem;
      word-wrap: break-word;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
      user-select: text;
      display: grid;
      grid-template-rows: 20px auto;
    }

    .from-me {
      align-self: flex-end;
      background-color: #dcf8c6;
    }

    .from-them {
      align-self: flex-start;
      background-color: #e5e5ea;
    }
    .chat-wrapper {
      display: flex;
      flex-direction: column;
      gap: 12px;
      padding: 16px;
    }

    .bubbles {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    /* Bubble Style
    .bubble {
      max-width: 60%;
      padding: 10px 14px;
      border: 2px solid #111;
      border-radius: 14px;
      box-shadow: 3px 3px 0 #111;
      background: #fff;
      font-weight: 600;
      position: relative;
    }
    .bubble.left {
      align-self: flex-start;
    }
    .bubble.right {
      align-self: flex-end;
      background: #e9f2ff;
    } */

    /* ---- Animasi Persona 5 style ---- */
    .bubble-enter-active,
    .bubble-leave-active {
      transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
    }

    .bubble-enter-from {
      opacity: 0;
      transform: translateX(120%) skewX(-10deg) scale(0.9);
    }
    .bubble-enter-to {
      opacity: 1;
      transform: translateX(0) skewX(0deg) scale(1);
    }

    .bubble-leave-to {
      opacity: 0;
      transform: translateX(120%) skewX(10deg) scale(0.9);
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
        <TransitionGroup name="bubble" tag="div" class="bubbles">
          <div v-for="(msg, i) in messages" :key="i" :class="['message-container',user.id === msg.SenderId ? 'from-me' : 'from-them']" ><Message :username="msg.SenderName" :message="msg.Message"></Message>
          </div> 
        </TransitionGroup>
        </div>
        <div style="padding: 0 5px;" v-if="chatRoom">
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