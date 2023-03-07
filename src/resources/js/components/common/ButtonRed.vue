<template>
  <button class="button-red">
    <slot/>
  </button>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { useRoute, useRouter } from 'vue-router';
    import router from '../../router'
    export default defineComponent({
        name: 'ButtonRed',
        components: {

        },
    });
</script>

<style lang="scss" scoped>
.button-red {
    background-color: #F54335;
    color: #ffffff;
    font-weight: bold;
    border-radius: 20px;
    // padding: 22px 68px;
    padding: 22px 10px;
    outline: none;
    cursor: pointer;
}
</style>
