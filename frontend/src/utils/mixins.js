export const myMixin = {
  methods: {

    handleResult (result, keys) {
      let res = { arrKeys: [], arrTitles: [], tableDatas: [], total: 0 }
      if (result && result.data) {
        let data = result.data
        if (data.arrTitles && data.arrTitles.arrString && data.arrTitles.arrString.length) {
          res.arrTitles = data.arrTitles.arrString
        }
        if (data.arrKeys && data.arrKeys.arrString && data.arrKeys.arrString.length) {
          res.arrKeys = data.arrKeys.arrString
        }
        if (!res.arrKeys.length) {
          res.arrKeys = res.arrTitles
        }
        if (!keys) {
          keys = res.arrKeys
        }
        if (data.arrDatas && data.arrDatas.length) {
          for (let i = 0; i < data.arrDatas.length; i++) {
            var rowObj = {}
            for (let index = 0; index < keys.length; index++) {
              rowObj[keys[index]] = data.arrDatas[i].arrString[index]
            }
            res.tableDatas.push(rowObj)
          }
        }
        res.total = data.nTotal ? data.nTotal : 0
      }
      return res
    },
    IUDSuccess (res) {
      if (res && res.data && res.data.hasOwnProperty('result') && res.data.result === 1) {
        return false
      }
      return true
    },
    exportData (refName, filename) {
      this.$refs[refName].exportCsv({
        filename
      })
    }

  }
}
