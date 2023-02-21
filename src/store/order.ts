import { defineStore } from 'pinia'
import axios from "axios"

export const order = defineStore('order', {
    //保持したいデータ
    state: () => ({
        order_history: [] as any[],
    }),
    getters: ({

    }),
    actions: {
        async orderHistory(data:any) {
            const response = await axios.post('api/orderHistory', data)
            console.log('order.ts orderHistory response', response)
            this.order_history = response.data
            return response.data
        },
    },
  })
