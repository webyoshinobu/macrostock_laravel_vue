/**
 * クッキーの値を取得する
 * @param {String} searchKey 検索するキー
 * @returns {String} キーに対応する値
 */
export function getCookieValue (searchKey:String) {
    if (typeof searchKey === 'undefined') {
      return ''
    }

    let val = ''

    document.cookie.split(';').forEach(cookie => {
      const [key, value] = cookie.split('=')
      if (key === searchKey) {
        return val = value
      }
    })

    return val
}

/**
 * ステータスコード
 */
export const OK = 200
export const CREATED = 201
export const INTERNAL_SERVER_ERROR = 500
export const UNPROCESSABLE_ENTITY = 422
export const UNAUTHORIZED = 419 //419 は正式には定義されていないコードで、Laravel が独自で使用しているコード
export const NOT_FOUND = 404
