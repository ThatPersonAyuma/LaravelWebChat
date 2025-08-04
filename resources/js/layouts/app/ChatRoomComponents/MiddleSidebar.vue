<script setup lang="ts">
    import { computed, onMounted, ref, toRaw, toRef } from 'vue';
    import GroupRoom from './GroupRoom.vue';
    import { ChatRoom, User } from '@/types';
    import axios from 'axios';

    const emit = defineEmits<{
        (e: 'update:chatRoom', value: ChatRoom | null): void
    }>()
    function handleClick(index: number){
        emit('update:chatRoom', {
            Id:chatRooms.value[index].id,
            IsGroup: chatRooms.value[index].is_group
        });//selected_cr.value = {Id:chatRooms.value[index].id, // ini udah akses nilai ChatRoom dengan .value jadi tinggal assign nilainya
                                // IsGroup: chatRooms.value[index].is_group};
        activeIndex.value = index;
        // console.log("Handle index: ", selected_cr.value);
        // if (selected_cr.value != null){
        //     activeIndex.value = index;
        //     console.log("Handle index: ", index);
        //     selected_cr.value.Id = chatRooms.value[index].id;
        //     selected_cr.value.IsGroup = chatRooms.value[index].is_group;
        //     console.log("Handle index: ", selected_cr.value);
        // }else{
        //     selected_cr.value = {Id:chatRooms.value[index].id, // ini udah akses nilai ChatRoom dengan .value jadi tinggal assign nilainya
        //                         IsGroup: chatRooms.value[index].is_group};
        // }
    }

    const props = defineProps<{user: User, chatRoom: ChatRoom | null}>()
    const user = toRef(props, 'user');
    const chatRooms = ref<any[]>([]);
    const activeIndex = ref<number | null>(null);
    
    onMounted(()=>{
        ChatRoomList();
        console.log('Middle Component, id: ', user.value.id);
    });
    const ChatRoomList = async () => {
        try{
            const response = await axios.get('/api/get-user-chat-rooms', {
                params: {user_id: user.value.id}
            })
            chatRooms.value = response.data.data_query // kalau .data aja bentuknya proxy target
            console.log('Berhasil query: ', chatRooms.value);
            console.log('Berhasil response data: ', response.data);
            console.log(JSON.stringify(response.data, null, 2));
            for (const room of chatRooms.value){
                console.log('Iterasi: ', room.id); // If you see a proxy data type just treat it as its type json, list etc
            }
        }catch (err){
            console.error('Failed query: ', err);
        }
    }
</script>

<style scoped>
.active {
  background-color: #007bff;
  color: white;
  border: 2px solid #0056b3;
}
</style>

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
                    gap: 0.5rem;"
            >
            <button v-for="(room, i) in chatRooms" :key="i" type="button" @click="handleClick(i)" style="display: flex;flex-direction: row;direction: ltr; height: 65px; cursor: pointer;" :class="{'active': activeIndex === i}">
                <GroupRoom :title="room.name" image-path="personIcon.jpg"/>
            </button>
            <!-- <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/>
            <GroupRoom title="Group Mancing Mania" image-path="personIcon.jpg"/> -->
        </div>
    </div>
</template>