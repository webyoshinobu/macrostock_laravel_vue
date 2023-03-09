<template>
    <vue-element-loading :active="loading_status" spinner="line-scale" is-full-screen />
</template>
<script lang="ts">
import { defineComponent, ref, onMounted, computed } from "vue";
export default defineComponent({
    name: 'Indicator',
    props: {
        isLoading: {
            type: Boolean,
        }
    },

    setup(props) {

        // computed
        const loading_status = computed(() => props.isLoading);

        // lifecycle hooks
        onMounted(() => {

        });

        return { loading_status }
    }
})
</script>
