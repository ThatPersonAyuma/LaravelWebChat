<script setup lang="ts">
import GroupRoom from './GroupRoom.vue';
</script>

<template>
    <div style="height: 100vh;flex:1;padding: 10px;display: flex; align-items: center; flex-direction: column;">
        <div style="width: 100%; height: 100px; flex: none;">
            <h1 style="font-size: 25px;align-content:flex-end;"><b>WhitsIpp</b></h1>
        </div>
        <div style="width: 100%;
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    overflow-y: auto;
                    gap: 0.5rem;">
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
        </div>
    </div>
</template>