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
        async createPdf(data:any) {
            await axios.post('api/orderHistoryPdf', data, { responseType: "blob", })
            .then((response)=>{
                let mineType = response.headers["content-type"];
                // const name = response.headers["content-disposition"];
                const contentDisposition = response.headers["content-disposition"];
                // const fileName = getFileName(contentDisposition)
                // const fileName = contentDisposition
                const blob = new Blob([response.data], { type: mineType });
                // saveAs(blob, decodeURIComponent( fileName ));
                const fileUrl = URL.createObjectURL(blob)
                console.log('order.ts createPdf fileUrl', fileUrl)
                window.open(fileUrl)
            })
        },
        // //laravelからのレスポンスで$headersのContent-Dispositionを指定してダウンロードするとtmpファイルには正常に保存されるが、
        // // ダウンロードしたタイミングでファイルが壊れるので、Content-Dispositionのfilenameからファイル名を取り出して返す。
        // getFileName (contentDisposition:string) {
        //     let fileName = contentDisposition.substring(contentDisposition.indexOf("''") + 2,
        //     contentDisposition.length
        //     );
        //     //デコードするとスペースが"+"になるのでスペースへ置換します
        //     fileName = decodeURI(fileName).replace(/\+/g, " ");

        //     return fileName;
        // },
    },
  })
