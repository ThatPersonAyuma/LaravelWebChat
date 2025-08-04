<script setup lang="ts">
import ChatRoomSidebar from '@/layouts/app/ChatRoomComponents/ChatRoomSidebar.vue';
import ChatRoomContent from '@/layouts/app/ChatRoomComponents/ChatRoomContent.vue';
import UserInfo from '@/components/UserInfo.vue';
import { Sidebar } from '@/components/ui/sidebar';
import AppSidebar from '@/components/AppSidebar.vue';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { usePage } from '@inertiajs/vue3';
import { ChatRoom, User } from '@/types';
import { useSidebar } from '@/components/ui/sidebar';
import {ConnectWebSocket} from '@/echo';
import { ref } from 'vue';

const page = usePage();
const user = page.props.auth.user as User;
const chatRoom = ref<ChatRoom |null>(null);
</script>

<template>
    <ChatRoomSidebar v-model:chatRoom="chatRoom" :user="user">
        <ChatRoomContent v-model:chatRoom="chatRoom" :user="user" />
    </ChatRoomSidebar>
</template>