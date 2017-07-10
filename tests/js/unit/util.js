import Vue from 'vue';

export default {
	mountComponent(Component, propsData) {
		const Ctor = Vue.extend(Component);
		const vm = new Ctor({ propsData: propsData }).$mount();
		return vm;
	},

	mockStripeCheckout() {
		window.StripeCheckout = { configure: function() {} };
	}
}