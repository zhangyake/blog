
const app = {
  state: {
    openedSubmenuArr: [], // 要展开的菜单数组,
    openedTags: [{
      meta: { title: '欢迎页' },
      path: '',
      name: 'welcome'
    }], // 打开过的标签,
    shrink: false,
    timeOut: '',
    timeInterval: ''
  },
  mutations: {
    SET_TIME_INTERVAL (state, val) {
      state.timeInterval = val
    },
    SET_TIME_OUT (state, val) {
      state.timeOut = val
    },
    SET_SHRINK (state, boolval) {
      state.shrink = boolval
    },
    SET_OPENEDTAGS (state, openedTags) {
      state.openedTags = openedTags
    },
    addOpenSubmenu (state, name) {
      let hasThisName = false
      let isEmpty = false
      if (name.length === 0) {
        isEmpty = true
      }
      if (state.openedSubmenuArr.indexOf(name) > -1) {
        hasThisName = true
      }
      if (!hasThisName && !isEmpty) {
        state.openedSubmenuArr.push(name)
      }
    },
    removeOpenTag (state, name) {
      const index = state.openedTags.findIndex(item => {
        return item.name === name
      })
      state.openedTags.splice(index, 1)
    },
    addOpenTag (state, tag) {
      let isHas = state.openedTags.some(item => {
        return item.name === tag.name
      })
      if (!isHas) {
        state.openedTags.push(tag)
      }
    },
    clearAllTags (state) {
      state.openedTags.splice(1)
    },
    clearOtherTags (state, vm) {
      // let currentName = vm.$route.name
      // state.openedTags = [vm.$route]
      let currentName = vm.$route.name
      let currentIndex = 0
      state.openedTags.forEach((item, index) => {
        if (item.name === currentName) {
          currentIndex = index
        }
      })
      if (currentIndex === 0) {
        state.openedTags.splice(1)
      } else {
        state.openedTags.splice(currentIndex + 1)
        state.openedTags.splice(1, currentIndex - 1)
      }
    },
    setOpenSubMenu (state, names) {
      state.openedSubmenuArr = names
    }
  },
  actions: {
    ToggleSideBar: ({ commit }) => {
      commit('')
    }

  }
}

export default app
