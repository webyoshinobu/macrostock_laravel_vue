<template>
  <!-- <div class="pagination">
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
  </div> -->
  <div class="pagination_wrap">
    <ul class="pagination">
        <!-- Previous Page Link -->
        <li class="pagination_item disabled" v-if="isFirstPage">
            <span class="page-link">&laquo; prev</span>
        </li>
        <li v-if="! isFirstPage" class="pagination_item">
            <router-link
            :to="`/gallery?page=${currentPage - 1}`"
            class="page-link">
            &laquo; prev
            </router-link>
        </li>

        <!-- Pagination Elements -->
        <li
            class="pagination_item"
            :class="{active: currentPage == page}"
            v-for="page in displayList"
            :key="page"
        >
            <router-link class="page-link" :to="`/gallery?page=${page}`" v-if="currentPage != page">{{page}}</router-link>
            <span class="page-link" v-if="currentPage == page">{{ page }}</span>
        </li>

         <!-- Next Page Link -->
        <li v-if="! isLastPage" class="pagination_item">
            <router-link
            :to="`/gallery?page=${currentPage + 1}`"
            class="page-link">
            next &raquo;
            </router-link>
        </li>
        <li class="pagination_item disabled" v-if="isLastPage">
            <span class="page-link">next &raquo;</span>
        </li>
    </ul>
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

        // const isFirstPage = computed(() => {
        //     return props.currentPage === 1
        // })
        // const isLastPage = computed(() => {
        //     return props.currentPage === props.lastPage
        // })

        const isFirstPage = computed(() => {
            return props.currentPage === 1
        })
        const isLastPage = computed(() => {
            return props.currentPage === props.lastPage
        })

        const displayList = computed(() => {
            //4は選択しているページの前後のページリスト表示数です。
            let first = props.currentPage - 4;
            if (first < 1) first = 1;

            let last = props.currentPage + 4;
            if (last > props.lastPage) last = props.lastPage;

            const list = [];
            for (let i = first; i <= last; i++) {
                list.push(i);
            }
            return list;
        })

        console.log('Pagination.vue isFirstPage', isFirstPage);
        console.log('Pagination.vue isLastPage', isLastPage);

        return { router, route, isFirstPage, isLastPage, displayList }
    },
})
</script>
<style lang="scss" scoped>
@import "../../sass/prepends.scss";
.pagination_wrap {
    display: flex;
    justify-content: center;
    align-items: center;
}
.pagination {
    list-style-type: none;
    display: flex;
    // font-size: 36px;
    @include f-36;

    &_item{
        border: 1px solid #000000;
        padding: 10px;

        &:first-child {
            border-radius: 10px 0 0 10px;
        }

        &:last-child {
            border-radius: 0 10px 10px 0;
        }
    }
}
.page-link {
    text-decoration: none;
    color: #000000;
}
.disabled {
    .page-link {
        color: #6c757d;
    }
}
</style>
