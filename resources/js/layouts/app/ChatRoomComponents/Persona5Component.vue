<script>
export default {
  name: 'PersonaChat',
  props: {
    title: { type: String, default: 'Group Chat' },
    messages: { type: Array, default: () => [] },
    typing: { type: Boolean, default: false },
    choices: { type: Array, default: null }, // [{ label, value }]
    placeholder: { type: String, default: 'Tulis pesan…' },
    showAvatars: { type: Boolean, default: true },
    theme: { type: String, default: 'theme-default' }, // theme-default | theme-dark | theme-phantom
  },
  emits: ['send', 'choose', 'refresh', 'more'],
  data() {
    return { draft: '' };
  },
  watch: {
    messages: {
      handler() { this.$nextTick(this.scrollToBottom); },
      deep: true,
    },
    typing() { this.$nextTick(this.scrollToBottom); },
    choices() { this.$nextTick(this.scrollToBottom); },
  },
  mounted() {
    this.scrollToBottom();
  },
  methods: {
    send() {
      if (!this.draft.trim()) return;
      this.$emit('send', this.draft.trim());
      this.draft = '';
    },
    scrollToBottom() {
      const el = this.$refs.scrollArea;
      if (!el) return;
      el.scrollTop = el.scrollHeight;
    },
  },
};
</script>

<style scoped>
/* Wrapper */
.persona-wrap { 
  display: grid; 
  grid-template-rows: auto 1fr auto; 
  height: 100%;
  max-height: 100vh;
  background: linear-gradient(180deg, #fafafa 0%, #f0f2f6 100%);
  font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, 'Noto Sans', 'Helvetica Neue', Arial;
}
.theme-dark { background: linear-gradient(180deg, #121212 0%, #171a21 100%); }
.theme-phantom { background: radial-gradient(100% 100% at 0% 0%, #ffffff 0%, #f7f6fb 40%, #e9e6ff 100%); }

/* Header */
.chat-header { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; border-bottom: 1px solid rgba(0,0,0,0.06); }
.title { display: flex; gap: 8px; align-items: center; font-weight: 700; letter-spacing: 0.2px; }
.game-badge { background: #111; color: #fff; padding: 2px 6px; border-radius: 6px; font-size: 12px; border: 2px solid #f33; text-shadow: 0 1px 0 rgba(0,0,0,0.25); }
.actions .btn { background: transparent; border: 0; font-size: 18px; padding: 6px; cursor: pointer; }

/* Chat area */
.chat-area { overflow: auto; padding: 14px; display: grid; gap: 8px; align-content: start; }

.system-pill { margin: 6px auto; background: #fff; color: #1f2328; border: 2px solid #1f2328; padding: 4px 10px; border-radius: 999px; font-weight: 700; box-shadow: 2px 2px 0 #1f2328; }

.row { display: grid; grid-template-columns: 40px 1fr; gap: 8px; align-items: end; }
.row.right { grid-template-columns: 1fr 40px; }
.row.right .bubble-wrap { order: 1; }
.row.right .avatar { order: 2; }

.avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid #111; box-shadow: 2px 2px 0 #111; background: #fff; }

.bubble-wrap { display: grid; gap: 2px; }
.meta { display: flex; align-items: baseline; gap: 8px; font-size: 11px; padding: 0 4px; color: #555; }
.theme-dark .meta { color: #a6adbb; }
.name { font-weight: 800; text-transform: uppercase; letter-spacing: .6px; }
.time { opacity: .7; }

.bubble { position: relative; max-width: min(78vw, 580px); padding: 10px 12px; border-radius: 14px; border: 2px solid #111; box-shadow: 4px 4px 0 #111; background: #fff; animation: pop .25s ease-out; }
.bubble-left { border-top-left-radius: 2px; }
.bubble-right { border-top-right-radius: 2px; background: #e9f2ff; }
.theme-dark .bubble { background: #1d222a; color: #ebeff5; border-color: #0c0f14; box-shadow: 4px 4px 0 #0c0f14; }
.theme-dark .bubble-right { background: #21374d; }

/* Persona-ish tails */
.bubble-left:after, .bubble-right:after { content: ""; position: absolute; width: 0; height: 0; border: 8px solid transparent; top: -2px; }
.bubble-left:after { left: -2px; border-right-color: #111; transform: translate(-6px, -2px) rotate(20deg); }
.bubble-right:after { right: -2px; border-left-color: #111; transform: translate(6px, -2px) rotate(-20deg); }

/* Reply context */
.reply-context { font-size: 12px; padding: 6px 8px; margin: -6px -6px 8px; border: 1px dashed rgba(17,17,17,0.3); border-radius: 10px; opacity: .85; }
.reply-name { font-weight: 700; margin-right: 6px; }
.reply-text { opacity: .85; }

.text { white-space: pre-wrap; word-break: break-word; line-height: 1.4; }

.attachments { display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 6px; margin-top: 8px; }
.attachments .img { border: 2px solid #111; border-radius: 12px; overflow: hidden; background: #f6f8fa; }
.attachments img { width: 100%; height: 100%; object-fit: cover; display: block; }

.reactions { display: flex; gap: 6px; margin-top: 6px; }
.react { background: #fff; border: 2px solid #111; padding: 2px 6px; border-radius: 999px; font-size: 12px; box-shadow: 2px 2px 0 #111; }
.theme-dark .react { background: #111; border-color: #0c0f14; }

/* Typing */
.typing { display: inline-flex; gap: 6px; align-items: center; padding: 10px 12px; width: fit-content; }
.dot { width: 6px; height: 6px; background: currentColor; border-radius: 50%; opacity: .4; animation: blink 1.2s infinite; }
.dot:nth-child(2) { animation-delay: .2s; }
.dot:nth-child(3) { animation-delay: .4s; }

/* Choices */
.choices { display: grid; gap: 8px; margin: 10px auto 0; max-width: 520px; }
.choice { position: relative; text-align: left; font-weight: 800; letter-spacing: .3px; border: 2px solid #111; background: #fff; padding: 10px 12px; border-radius: 12px; box-shadow: 4px 4px 0 #111; cursor: pointer; transition: transform .08s ease, box-shadow .08s ease; }
.choice:hover { transform: translate(-2px, -2px); box-shadow: 6px 6px 0 #111; }
.caret { margin-right: 8px; }
.theme-dark .choice { background: #1d222a; color: #ebeff5; border-color: #0c0f14; box-shadow: 4px 4px 0 #0c0f14; }

/* Composer */
.composer { display: grid; grid-template-columns: 1fr auto; gap: 8px; padding: 10px; border-top: 1px solid rgba(0,0,0,0.06); backdrop-filter: blur(4px); }
.input { border: 2px solid #111; border-radius: 999px; padding: 10px 14px; font-size: 14px; outline: none; box-shadow: 2px 2px 0 #111; background: #fff; }
.theme-dark .input { background: #0f1218; color: #ebeff5; border-color: #0c0f14; box-shadow: 2px 2px 0 #0c0f14; }
.send { border: 2px solid #111; background: #f33; color: #fff; font-weight: 900; padding: 8px 14px; border-radius: 12px; box-shadow: 3px 3px 0 #111; cursor: pointer; }
.send:active { transform: translate(1px,1px); box-shadow: 1px 1px 0 #111; }

/* Animations */
@keyframes pop { from { transform: scale(.98) translateY(6px); opacity: 0; } to { transform: scale(1) translateY(0); opacity: 1; } }
@keyframes blink { 0%, 100% { opacity: .25; } 50% { opacity: .85; } }

/* Drop-in transition for list */
.drop-enter-active, .drop-leave-active { transition: all .2s ease; }
.drop-enter-from { opacity: 0; transform: translateY(10px); }
.drop-leave-to { opacity: 0; transform: translateY(-6px); }
</style>

<template>
  <div class="persona-wrap" :class="theme">
    <div class="chat-header">
      <div class="title">
        <span class="game-badge">IM</span>
        <span>{{ title }}</span>
      </div>
      <div class="actions">
        <button class="btn" @click="$emit('refresh')">↻</button>
        <button class="btn" @click="$emit('more')">⋮</button>
      </div>
    </div>

    <div ref="scrollArea" class="chat-area">
      <transition-group name="drop" tag="div">
        <template v-for="(item, idx) in messages" :key="item.id || idx">
          <!-- System / Day change -->
          <div v-if="item.type === 'system'" class="system-pill">{{ item.text }}</div>

          <!-- Message bubble -->
          <div v-else class="row" :class="{ right: item.side === 'right' }">
            <img v-if="item.avatar && showAvatars" :src="item.avatar" class="avatar" :alt="item.name || 'avatar'" />

            <div class="bubble-wrap">
              <div class="meta" v-if="item.name || item.time">
                <span class="name" v-if="item.name">{{ item.name }}</span>
                <span class="time" v-if="item.time">{{ item.time }}</span>
              </div>

              <div class="bubble" :class="[ item.side === 'right' ? 'bubble-right' : 'bubble-left', item.variant ]">
                <div v-if="item.replyTo" class="reply-context">
                  <span class="reply-name">{{ item.replyTo.name }}</span>
                  <span class="reply-text">{{ item.replyTo.text }}</span>
                </div>

                <p class="text" v-html="item.text"></p>

                <div class="attachments" v-if="item.images?.length">
                  <div class="img" v-for="(img, i) in item.images" :key="i">
                    <img :src="img" alt="attachment" />
                  </div>
                </div>

                <div class="reactions" v-if="item.reactions?.length">
                  <span class="react" v-for="(r, i) in item.reactions" :key="i">{{ r }}</span>
                </div>
              </div>
            </div>
          </div>
        </template>

        <!-- Typing indicator -->
        <div v-if="typing" key="__typing" class="row">
          <div class="bubble-wrap">
            <div class="bubble bubble-left typing">
              <span class="dot"></span><span class="dot"></span><span class="dot"></span>
            </div>
          </div>
        </div>

        <!-- Choices style (Persona-style prompt) -->
        <div v-if="choices?.length" key="__choices" class="choices">
          <button class="choice" v-for="(c, i) in choices" :key="i" @click="$emit('choose', c)">
            <span class="caret">▶</span> {{ c.label }}
          </button>
        </div>
      </transition-group>
    </div>

    <div class="composer">
      <input
        v-model="draft"
        class="input"
        :placeholder="placeholder"
        @keydown.enter.prevent="send"
      />
      <button class="send" @click="send">Kirim</button>
    </div>
  </div>
</template>