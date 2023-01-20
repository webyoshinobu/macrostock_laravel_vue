import { defineStore } from 'pinia'

export const cartCounter = defineStore('cart', {
    //保持したいデータ
    state: () => ({
        items: [] as any[],
    }),
    getters: ({

    }),
    actions: {
        addCart(image:any) {
            this.items.push(image);
            // this.items = image;
            console.log('action this.items', this.items);
        },
    },
  })
