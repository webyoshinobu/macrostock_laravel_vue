<template>
  <button class="button-green">
    <slot/>
  </button>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { useRoute, useRouter } from 'vue-router';
    import router from '../../router'
    export default defineComponent({
        name: 'ButtonGreen',
        components: {

        },
    });
</script>

<style lang="scss" scoped>
.button-green {
    background-color: #3cb371;
    color: #ffffff;
    font-weight: bold;
    border-radius: 20px;
    padding: 22px 68px;
    border: none;
    outline: none;
}
</style>
