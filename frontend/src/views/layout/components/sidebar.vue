<template>
  <div class="layout-sider">
    <div class="layout-sider-children">
    <slot name="logo"></slot>
    <Menu v-show="!shrink"
          accordion
          ref="sideMenu"
          :active-name="$route.name"
          :open-names="openNames"
          :theme="menuTheme"
          width="auto"
          @on-select="changeRoute"
          @on-open-change="changeOpenNames">
      <template v-for="item in showMenuList">
        <MenuItem v-if="!item.hidden && item.children.length===1"
                  :name="item.children[0].name"
                  :key="'menuitem' + item.name">
        <Icon :type="item.meta.icon"
              :size="iconSize"
              :key="'menuicon' + item.name"></Icon>
        <span class="layout-text"
              :key="'title' + item.name">{{ item.children[0].meta.title }}</span>
        </MenuItem>

        <Submenu v-if="!item.hidden && item.children.length > 1"
                 :name="item.name"
                 :key="item.name">
          <template slot="title">
            <Icon :type="item.meta.icon"
                  :size="iconSize"></Icon>
            <span class="layout-text">{{ item.meta.title }}</span>
          </template>
          <template v-for="child in item.children">
            <MenuItem :name="child.name"
                      :key="'menuitem' + child.name">
            <Icon :type="child.meta.icon"
                  :size="iconSize"
                  :key="'icon' + child.name"></Icon>
            <span class="layout-text"
                  :key="'title' + child.name">{{ child.meta.title }}</span>
            </MenuItem>
          </template>
        </Submenu>
      </template>
    </Menu>
    <div v-show="shrink">
      <template v-for="(item, index) in showMenuList">
        <Dropdown transfer
                  v-if="!item.hidden && item.children.length>=1"
                  placement="right-start"
                  :key="index"
                  @on-click="changeRoute">
          <Button style="width: 50px;padding:10px 0;border:0"
                  type="text">
            <Icon :size="20"
                  :color="iconColor"
                  :type="item.meta.icon"></Icon>
          </Button>
          <DropdownMenu style="width: 180px;"
                        slot="list">
            <template v-for="(child, i) in item.children">
              <DropdownItem :name="child.name"
                            :key="i">

                <Icon v-if="child.meta && child.meta.icon"
                      :type="child.meta.icon"></Icon>
                <span style="padding-left:10px;"
                      v-if="child.meta && child.meta.title">{{child.meta.title }}</span>
              </DropdownItem>
            </template>
          </DropdownMenu>
        </Dropdown>

      </template>
    </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'sidebar',
  props: {
    menuList: Array,
    shrink: {
      type: Boolean,
      default: false
    },
    iconSize: {
      type: Number,
      default: 15
    },
    iconColor: {
      type: String,
      default: 'white'
    },
    menuTheme: {
      type: String,
      default: 'dark'
    },
    openNames: {
      type: Array
    }
  },
  components: {},
  data () {
    return {}
  },
  computed: {
    showMenuList () {
      let showMenuList = []
      this.menuList.forEach(item => {
        if (!item.hidden) {
          if (item.children && item.children.length) {
            let children = item.children.filter(element => {
              return !element.hidden
            })
            item.children = children
          }
          showMenuList.push(item)
        }
      })
      return showMenuList
    }
  },
  methods: {
    changeRoute (name) {
      this.$emit('on-select', name)
    },
    changeOpenNames (names) {
      this.$emit('on-open-change', names)
    }
  },
  watch: {},
  created () { },
  updated () {
    this.$nextTick(() => {
      if (this.$refs.sideMenu) {
        this.$refs.sideMenu.updateOpened()
      }
    })
  }
}
</script>

<style lang="less" scoped>
  .layout-sider-children{
    height: 100%;
    overflow-y: scroll;
    margin-right: -18px;
  }
</style>
