<template>
  <div class="pagination">
    <router-link
      v-if="! isFirstPage"
      :to="`/gallery?page=${currentPage - 1}`"
      class="button"
    >&laquo; prev</router-link>
    <router-link
      v-if="! isLastPage"
      :to="`/gallery?page=${currentPage + 1}`"
      class="button"
    >next &raquo;</router-link>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import { useRoute, useRouter } from 'vue-router';

export default defineComponent({
    name: 'Pagination',

    props: {
        currentPage: {
            type: Number,
            required: true
        },
        lastPage: {
            type: Number,
            required: true
        }
    },

    setup(props) {

        const router = useRouter();
        const route = useRoute();

        const isFirstPage = computed(() => {
            return props.currentPage === 1
        })
        const isLastPage = computed(() => {
            return props.currentPage === props.lastPage
        })

        console.log('Pagination.vue isFirstPage', isFirstPage);
        console.log('Pagination.vue isLastPage', isLastPage);

        return { router, route, isFirstPage, isLastPage }
    },
})
</script>
