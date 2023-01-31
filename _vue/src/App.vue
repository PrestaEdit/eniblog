<template>
  <div id="app">
    <UIKit />
    <ps-number value="test"></ps-number>
  </div>
</template>

<script>
//import PSPagination from '../../../../admin-dev/themes/new-theme/js/app/widgets/ps-pagination.vue';
import UIKit from './components/UIKit.vue'

export default {
  name: 'App',
  components: {
    UIKit
  }
}
</script>

<style lang="scss">
  #app {
    @import '~bootstrap-vue/dist/bootstrap-vue';
    @import '~prestakit/dist/css/bootstrap-prestashop-ui-kit';
  }
    #app {
    margin: 0;
    font-family: Open Sans, Helvetica, Arial, sans-serif;
    font-size: 14px;
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.5;
    background: white;
    color: #363a41;
    text-align: left;
  }
</style>
