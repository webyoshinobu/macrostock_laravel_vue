<template>
  <div class="loader">
    <p class="loading__text">
      <slot>Loading...</slot>
    </p>
    <div class="loader__item loader__item--heart"><div></div></div>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted } from "vue"
import { storeToRefs } from 'pinia'
import { useRoute, useRouter } from 'vue-router'


export default defineComponent({
    name: 'Loader',
    components: {

    },

    setup() {
        // data
        const router = useRouter();
        const route = useRoute();

        //methods

        onMounted(() => {

        });

        return { router, route, onMounted };
    },

});
</script>

<style lang="scss" scoped>
</style>
