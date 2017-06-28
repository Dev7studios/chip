import Vue from 'vue';
import App from './App.vue';
import SaaSBilling from '../../dist/saas-billing';

Vue.use(SaaSBilling);

new Vue({
  el: '#app',
  render: h => h(App)
})
