<script setup>
import axios from "axios";
import {format, compareAsc} from "date-fns";
import {nextTick, onMounted, ref, watch} from "vue";
import data from "emoji-mart-vue-fast/data/all.json";
import {Picker, EmojiIndex} from "emoji-mart-vue-fast/src";

const props = defineProps({
    friend: {
        type: Object,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    },
});

const skeletons = ref([
    'end', 'end', 'end', 'start', 'start', 'end', 'start', 'start', 'end'
]);
const firstOpen = ref(true);
const isLoading = ref(true);
const messages = ref([]);
const newMessage = ref("");
const messagesContainer = ref(null);
const endOfChat = ref(null);
const isFriendTyping = ref(false);
const isFriendTypingTimer = ref(null);

const emojiPickerSelected = ref(false)

let emojiIndex = new EmojiIndex(data)

const toggle = () => {
    emojiPickerSelected.value = !emojiPickerSelected.value
}

const convertEmoji = (emoji) => {
    //context.emit('updateEmoji', emoji.native)
    newMessage.value += emoji.native;
}

watch(
    messages,
    () => {
        nextTick(() => {
            if (!firstOpen.value) {
                endOfChat.value?.scrollIntoView({behavior: 'smooth'})
            } else {
                firstOpen.value = false;
                endOfChat.value?.scrollIntoView();
            }
        });
    },
    {deep: true}
);

const sendMessage = () => {
    if (newMessage.value.trim() !== "") {
        axios
            .post(`/messages/${props.friend.id}`, {
                message: newMessage.value,
            })
            .then((response) => {
                messages.value.push(response.data);
                newMessage.value = "";
            });
    }
};

const sendTypingEvent = () => {
    Echo.private(`chat.${props.friend.id}`).whisper("typing", {
        userID: props.currentUser.id,
    });
};

onMounted(() => {
    axios.get(`/messages/${props.friend.id}`).then((response) => {
        isLoading.value = false;
        messages.value = response.data;
    });

    Echo.private(`chat.${props.currentUser.id}`)
        .listen("MessageSent", (response) => {
            console.log("Listen -> MessageSent");
            messages.value.push(response.message);
        })
        .listenForWhisper("typing", (response) => {
            isFriendTyping.value = response.userID === props.friend.id;

            if (isFriendTypingTimer.value) {
                clearTimeout(isFriendTypingTimer.value);
            }

            isFriendTypingTimer.value = setTimeout(() => {
                isFriendTyping.value = false;
            }, 1000);
        });
});
</script>

<template>
    <div class="flex w-full flex-col p-6 overflow-y-auto max-h-[870px] overflow-x-auto">
        <div v-if="isLoading" class="flex w-full rounded-box grid px-10 overflow-y-auto max-h-fit">
            <div
                v-for="(type, index) in skeletons"
                :key="index"
            >
                <div
                    class="chat chat-end mt-3"
                    v-if="type === 'end'"
                >
                    <div class="chat-image avatar">
                        <div class="skeleton h-10 w-10 shrink-0 rounded-full"></div>
                    </div>
                    <div class="chat-header mb-2">
                        <div class="skeleton h-4 w-10"></div>
                    </div>
                    <div class="skeleton h-4 w-28"></div>
                </div>
                <div
                    class="chat chat-start mt-3"
                    v-else
                >
                    <div class="chat-image avatar">
                        <div class="skeleton h-10 w-10 shrink-0 rounded-full"></div>
                    </div>
                    <div class="chat-header mb-2">
                        <div class="skeleton h-4 w-10"></div>
                    </div>
                    <div class="skeleton h-4 w-28"></div>
                </div>
            </div>
        </div>
        <div v-if="messages.length <= 0" role="alert" class="alert">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                class="stroke-info h-6 w-6 shrink-0">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>There are no messages for this chat!</span>
        </div>
        <div ref="messagesContainer"
             class="flex w-full rounded-box grid px-10 overflow-y-auto max-h-fit">
            {{ lastDate = null }}
            <div
                v-for="(message, index) in messages"
                :key="index"
            >
                <div class="divider" v-if="!lastDate">{{ lastDate = format(message.created_at, 'iii i LLL') }}</div>
                <div class="divider" v-if="lastDate ? lastDate !== format(message.created_at, 'iii i LLL') : false">
                    {{ lastDate = format(message.created_at, 'iii i LLL') }}
                </div>
                <div
                    class="chat chat-end mt-3"
                    v-if="message.sender_id === currentUser.id"
                >
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img
                                :src="'https://ui-avatars.com/api/?size=128&background=random&name=' + currentUser.name">
                        </div>
                    </div>
                    <div class="chat-header pb-2">{{ currentUser.name }}
                        <time class="text-xs opacity-50">{{ format(message.created_at, 'H:mm') }}</time>
                    </div>
                    <div class="chat-bubble max-w-2xl">{{ message.text }}</div>
                </div>
                <div class="chat chat-start mt-3" v-else>
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img :src="'https://ui-avatars.com/api/?size=128&background=random&name=' + friend.name">
                        </div>
                    </div>
                    <div class="chat-header pb-2">{{ friend.name }}
                        <time class="text-xs opacity-50">{{ format(message.created_at, 'H:mm') }}</time>
                    </div>
                    <div class="chat-bubble max-w-2xl">{{ message.text }}</div>
                </div>
            </div>
            <div ref="endOfChat" tabindex="0"></div>
        </div>
        <div class="divider"></div>
        <div>
            <div class="flex items-center">
                <input
                    type="text"
                    v-model="newMessage"
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    placeholder="Type a message..."
                    class="input input-bordered me-2 w-full"
                />
                <button class="btn btn-outline me-2" @click="toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z"/>
                    </svg>
                </button>
                <Picker
                    v-if="emojiPickerSelected"
                    :data="emojiIndex"
                    title="Pick your emoji…"
                    emoji="point_up"
                    @select="convertEmoji"
                    :style="{ position: 'absolute', bottom: '100px', right: '146px' }"
                />
                <button
                    @click="sendMessage"
                    class="btn btn-primary"
                >
                    Send
                </button>
            </div>
            <small v-if="isFriendTyping" class="text-green-600">
                {{ friend.name }} is typing...
            </small>
        </div>
    </div>
</template>
