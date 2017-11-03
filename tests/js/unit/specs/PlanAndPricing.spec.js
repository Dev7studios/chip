import util from '../util';
import PlanAndPricing from '@/components/PlanAndPricing.vue';

import defaultState from '../data/default.state.json';
import couponState from '../data/coupon.state';
import subscribedState from '../data/subscribed.state';
import cancelledState from '../data/cancelled.state';
import expiredState from '../data/expired.state';

function mountPlanAndPricing(state) {
	return util.mountComponent(PlanAndPricing, {
		routes: state.routes,
		stripeForm: state.stripe_form,
		plans: state.plans,
		subscription: state.subscription,
		coupon: state.coupon,
	});
}

util.mockStripeCheckout();

describe('PlanAndPricing (default state)', () => {
	it('should list the plans', () => {
		const vm = mountPlanAndPricing(defaultState);

		assert.equal(vm.plans.length, 3);
		assert.isTrue(vm.showPricingTable);
	});

	it('should not show the cancel button', () => {
		const vm = mountPlanAndPricing(defaultState);

		assert.isFalse(vm.showCancelButton());
	});
});

describe('PlanAndPricing (coupon state)', () => {
	it('should show the coupon alert', () => {
		const vm = mountPlanAndPricing(couponState);

		assert.equal(vm.$el.getElementsByClassName('coupon-alert').length, 1);
	});
});

describe('PlanAndPricing (subscribed state)', () => {
	it('should have a subscription', () => {
		const vm = mountPlanAndPricing(subscribedState);

		assert.isTrue(vm.hasSubscription);
	});

	it('should show the cancel button', () => {
		const vm = mountPlanAndPricing(subscribedState);

		assert.isTrue(vm.showCancelButton());
	});
});

describe('PlanAndPricing (cancelled state)', () => {
	it('should show the resume notice', () => {
		const vm = mountPlanAndPricing(cancelledState);

		assert.isTrue(vm.showResumeAlert);
		assert.isFalse(vm.showPricingTable);
	});
});

describe('PlanAndPricing (expired state)', () => {
	it('should list the plans', () => {
		const vm = mountPlanAndPricing(expiredState);

		assert.isTrue(vm.showPricingTable);
	});

	it('should not show the cancel button', () => {
		const vm = mountPlanAndPricing(expiredState);

		assert.isFalse(vm.showCancelButton());
	});
});
