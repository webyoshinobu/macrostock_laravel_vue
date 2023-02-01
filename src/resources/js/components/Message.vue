<template>
  <div class="message" v-show="message">
    {{ message }}
  </div>
</template>

<script lang="ts">
  import { defineComponent, computed, onMounted } from "vue";
  import { storeToRefs } from "pinia";
  import { useRoute, useRouter } from 'vue-router';
  import { message } from '../../../store/message';

  export default defineComponent({
    name: 'Message',
    components: {

    },

    setup() {
        // data
        let message:any = ''

        // computed
        const setContent = computed(()=> {
            return message = message().content
        })

        onMounted(() => {

        });

        return { onMounted, setContent, message, };
    },
  })
</script>
