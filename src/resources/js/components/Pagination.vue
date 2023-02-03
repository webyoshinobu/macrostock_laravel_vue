<template>
  <div class="pagination">
    <RouterLink
      v-if="! isFirstPage"
      :to="`/?page=${currentPage - 1}`"
      class="button"
    >&laquo; prev</RouterLink>
    <RouterLink
      v-if="! isLastPage"
      :to="`/?page=${currentPage + 1}`"
      class="button"
    >next &raquo;</RouterLink>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
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

        const isFirstPage = computed(() => {
            return props.currentPage === 1
        })
        const isLastPage = computed(() => {
            return props.currentPage === props.lastPage
        })

        return { isFirstPage, isLastPage }
    },
})
</script>
