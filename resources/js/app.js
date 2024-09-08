import './bootstrap';

import { createApp } from 'vue';
import Chat from '../js/Components/Chat.vue';
import 'emoji-mart-vue-fast/css/emoji-mart.css'

const app = createApp({});

app.component('chat-room', Chat);
app.mount('#app');
