import Vue from 'vue';
import App from './App.vue';
import Chip from '../../dist/chip';

Vue.use(Chip);

new Vue({
  el: '#app',
  render: h => h(App)
})
