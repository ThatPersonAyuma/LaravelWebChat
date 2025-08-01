<script setup lang="ts">
import MiddleSidebar from '@/layouts/app/ChatRoomComponents/MiddleSidebar.vue';
import LeftestSidebar from '@/layouts/app/ChatRoomComponents/LeftestSidebar.vue';
import { onMounted, toRef } from 'vue';
import { User } from '@/types';
const props = defineProps<{user: User}>()
const user = toRef(props, 'user');
onMounted(()=>{
    console.log(`Child ${user.value.name}`);
})
</script>

<template>
    <div style="display:flex; width: 100%;height: 100%;">
    <div style="flex: 5;">
        <div style="display:flex; width: 100%;height: 100%;">
                <LeftestSidebar />
                <MiddleSidebar />
        </div>
    </div>
    <div style="flex: 10;">
            <slot />
    </div>
    </div>
</template>
