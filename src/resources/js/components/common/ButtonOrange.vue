<template>
  <button class="button-orange">
    <slot/>
  </button>
</template>

<script lang="ts">
    import { defineComponent, ref, onMounted } from "vue";
    import { useRoute, useRouter } from 'vue-router';
    import router from '../../router'
    export default defineComponent({
        name: 'ButtonOrange',
        components: {

        },
    });
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.button-orange {
    background-color: #F87D09;
    color: #ffffff;
    font-weight: bold;
    border-radius: 20px;
    // padding: 22px 68px;
    padding: 22px 10px;
    border: none;
    outline: none;

    @include md {
        padding: 20px 10px;
    }
}
</style>
