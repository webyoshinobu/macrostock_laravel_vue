import { defineStore } from 'pinia'
import axios from "axios"

type IMAGES = {
    product_imgs: string[],
}

export const galleryImgs = defineStore('gallery', {
    //保持したいデータ
    state: () =>({
        product_imgs: null as IMAGES|null,
        photo_list: null as IMAGES|null,
    }),
    getters: ({

    }),
    actions: {
        async getImages () {
            const response = await axios.get('/api/gallery');
            console.log('gallery.ts response.data', response.data);
            const product_ims = response.data || null;
            this.product_imgs = product_ims;
            console.log('gallery.ts this.product_imgs', this.product_imgs);
        },
        async getPhotoList (data:number) {
            // console.log('gallery.ts getPhotoList data', data)
            const response = await axios.post('/api/admin/photoList', data);
            console.log('gallery.ts getPhotoList response.data', response.data);
            this.photo_list = response.data
            console.log('gallery.ts getPhotoList this.photo_list', this.photo_list);
            return response.data
        },
        async deletePhoto (data:any) {
            console.log('gallery.ts deletePhoto');
            const response = await axios.post('/api/admin/photoDelete', data)
            console.log('gallery.ts deletePhoto response', response)
            return response
        },
    },
})
