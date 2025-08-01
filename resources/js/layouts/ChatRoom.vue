<script setup lang="ts">
import ChatRoomSidebar from '@/layouts/app/ChatRoomComponents/ChatRoomSidebar.vue';
import ChatRoomContent from '@/layouts/app/ChatRoomComponents/ChatRoomContent.vue';
import UserInfo from '@/components/UserInfo.vue';
import { Sidebar } from '@/components/ui/sidebar';
import AppSidebar from '@/components/AppSidebar.vue';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { usePage } from '@inertiajs/vue3';
import { User } from '@/types';
import { useSidebar } from '@/components/ui/sidebar';
const page = usePage();
const user = page.props.auth.user as User;
</script>

<template>
    <ChatRoomSidebar :user="user">
        <ChatRoomContent :user="user"/>
    </ChatRoomSidebar>
</template>