import { defineStore } from 'pinia'
import axios from "axios"

export const auth = defineStore('auth', {
    //保持したいデータ
    state: () => ({
        user: [] as any[],
        csrf: document.querySelector('meta[name="csrf-token"]')!.getAttribute('content'),
    }),
    getters: ({

    }),
    actions: {
        async register (data:any) {
            this.user = data;
            const response = await axios.post('/api/register', data);
        }
    },
  })
