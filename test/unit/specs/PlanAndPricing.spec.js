import Vue from 'vue';
import PlanAndPricing from '@/components/PlanAndPricing.vue';

describe('PlanAndPricing.vue', () => {
	it('should render correct contents', () => {
		const Constructor = Vue.extend(PlanAndPricing);
		const vm = new Constructor().$mount();
		expect(vm.$el.querySelector('.hello h1').textContent)
			.to.equal('Welcome to Your Vue.js App');
	})
})
