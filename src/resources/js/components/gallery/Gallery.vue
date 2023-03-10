<template>
  <section class="gallery">

    <Indicator :isLoading="isLoading"></Indicator>

    <h2 class="gallery_title">Gallery</h2>
    <ul class="gallery_list">
        <li v-for="image in images" :key="image.index" :images="images" class="gallery_list_item">
            <!-- <img :src="image.src" :alt="image.alt" @click="pushImg(image)"> -->
            <img :src="image.url" :alt="image.filename" @click="pushImg(image)" oncontextmenu="return false;" onselectstart="return false;" onmousedown="return false;">
        </li>
    </ul>
    <Pagination :current-page="currentPage" :last-page="lastPage" class="pagination_component" />
  </section>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, reactive, watch, toRefs, computed, onUpdated } from "vue";
import { useRoute, useRouter } from 'vue-router';
import { storeToRefs } from 'pinia';
// import { galleryImgs } from '../../../../store/gallery';
import axios from "axios"
import { OK } from '../../util'
import { error } from "../../../../store/error";
import Pagination from '../Pagination.vue';
import Indicator from '../../Indicator.vue';

export default defineComponent({
    name: 'Gallery',
    components: {
        Pagination,
        Indicator,
    },

    setup() {
        //data
        const router = useRouter()
        const route = useRoute()
        let images = ref({})
        let currentPage = ref(0)
        let lastPage = ref(0)
        const selectImg = ref()
        let isLoading = ref(true)

        // console.log('Gallery.vue setup route', route)

        // methods
        const pushImg = (image:any) => {
            selectImg.value = image;
            // router.push( { name:'photo', query: selectImg.value } );
            router.push( { name:'photo', params: selectImg.value } );
            // router.push( { path: '/gallery/photo', params: selectImg.value } );
            // router.push( { name:'photo', params: {index:selectImg.value.index, src:selectImg.value.src, alt:selectImg.value.alt} } );
        };

        const galleryList = async () => {
            // const response = await axios.get('/api/gallery');
            // console.log('Gallery.vue props props.page', props.page);
            // console.log('Gallery.vue galleryList route', route)
            // console.log('Gallery.vue galleryList route.query', route.query.page);
            const page = route.query.page
            const response = await axios.get(`/api/gallery?page=${page}`);

            if (response.status !== OK) {
                error().setCode(response.status);
                return false
            }

            // console.log('Gallery.vue response', response.data);

            images.value = response.data.data
            // console.log('Gallery.vue images', images.value)

            currentPage.value = response.data.current_page
            // console.log('Gallery.vue currentPage', currentPage.value)

            lastPage.value = response.data.last_page
            // console.log('Gallery.vue lastPage', lastPage.value)
        }

        watch(route, () => {
            galleryList()
        },{
            immediate: true
        })

        onMounted(() => {

        });

        onUpdated(() => {
            isLoading.value = false
            // console.log("on update", isLoading.value)
        })

        return { router, selectImg, pushImg, galleryList, images, currentPage, lastPage, isLoading };
    },

    // watch: {
    //     route: {
    //         async handler () {
    //             await this.galleryList()
    //         },
    //         immediate: true
    //     }
    // }
});
</script>

<style lang="scss" scoped>
@import "../../../sass/prepends.scss";
.gallery {
    width: 80%;
    padding: 170px 10% 0 10%;
    margin: 0 0 100px 0;

    @include sm {
        padding: 107px 10% 100px 10%;
    }

    &_title {
        // font-size: 70px;
        @include f-80;
        margin-bottom: 20px;
    }

    &_list {
        columns: 3;/*段組みの数*/
        list-style-type: none;

        @include sm {
            columns: 1;
        }

        &_item{
            margin-bottom: 20px;/*各画像下に余白をつける*/

            img {
                width:100%;
                height:auto;
                vertical-align: bottom;/*画像の下にできる余白を削除*/
                cursor: pointer;
            }
        }
    }
}

.pagination_component{
    margin: 100px 0 0 0;
}

</style>
