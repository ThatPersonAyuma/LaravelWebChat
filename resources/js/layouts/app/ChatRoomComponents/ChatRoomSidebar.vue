<script setup lang="ts">
import MiddleSidebar from '@/layouts/app/ChatRoomComponents/MiddleSidebar.vue';
import LeftestSidebar from '@/layouts/app/ChatRoomComponents/LeftestSidebar.vue';
import { onMounted, ref, toRef, watch } from 'vue';
import { ChatRoom, User } from '@/types';

const emit = defineEmits<{
  (e: 'update:chatRoom', value: ChatRoom | null): void
}>()
const props = defineProps<{user: User, chatRoom: ChatRoom|null}>()
const user = toRef(props, 'user');
onMounted(()=>{
    console.log(`Child ${user.value.name}`);
})
watch(() => props.chatRoom, (val) => {
  console.log('Parent chat_room changed:', val);
})

</script>

<template>
    <div style="display:flex; width: 100%;height: 100%;">
    <div style="flex: 5;">
        <div style="display:flex; width: 100%;height: 100%;">
                <LeftestSidebar />
                <MiddleSidebar v-model:chatRoom="props.chatRoom" :user="user" 
                                @update:chatRoom="val => emit('update:chatRoom', val)"/>
        </div>
    </div>
    <div style="flex: 10;">
            <slot />
    </div>
    </div>
</template>
