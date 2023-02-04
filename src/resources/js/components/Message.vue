<template>
  <div class="message" v-show="isVisible" :showMessage="showMessage">
        {{ showMessage }}test
  </div>
</template>

<script lang="ts">
  import { defineComponent, ref, computed, onMounted, watch } from "vue";
  import { storeToRefs } from "pinia";
  import { message } from '../../../store/message';

  export default defineComponent({
    name: 'Message',

    setup() {
        // data
        const messageStore = message()
        const { getMessage, content } = storeToRefs(messageStore)
        let showMessage = ref<any>(null)
        let isVisible = ref<boolean>(false)

        watch(getMessage, () => setVisible())

        const setVisible = () => {
            isVisible.value = true
            console.log('Message.vue isVisible', isVisible.value);
            console.log('Message.vue getMessage', getMessage.value)
            showMessage.value = getMessage.value
            console.log('Message.vue showMessage', showMessage)
            console.log('Message.vue content', messageStore.content)
        }

        // const setMessage = computed(() =>{
        //     return messageStore.content
        // })

        onMounted(() => {

        });

        return { onMounted, message, messageStore, getMessage, setVisible, isVisible, content, showMessage };
    },
  })
</script>
