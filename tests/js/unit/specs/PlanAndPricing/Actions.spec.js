import util from '../../util';
import Actions from '@/components/PlanAndPricing/Actions.vue';

import defaultState from '../../data/default.state.json';
import subscribedState from '../../data/subscribed.state';
import expiredState from '../../data/expired.state';

function mountActions(state, plan) {
	return util.mountComponent(Actions, {
		routes: state.routes,
		stripeForm: state.stripe_form,
		subscription: state.subscription,
		coupon: state.coupon,
		plan: plan,
	});
}

describe('Actions (default state)', () => {
	it('should show the upgrade button', () => {
		const plan = defaultState.plans[0];
		const vm = mountActions(defaultState, plan);

		assert.isFalse(vm.showChangeButton(plan.id));
		assert.isNotFalse(vm.showUpgradeButton(plan.id));
	});
});

describe('Actions (subscribed state)', () => {
	it('should show the change button', () => {
		const plan = defaultState.plans[1];
		const vm = mountActions(subscribedState, plan);

		assert.isNotFalse(vm.showChangeButton(plan.id));
		assert.isFalse(vm.showUpgradeButton(plan.id));
	});

	it('should show the current plan button', () => {
		const plan = defaultState.plans[0];
		const vm = mountActions(subscribedState, plan);

		assert.isTrue(vm.isCurrentPlan(plan.id));
		assert.equal(vm.changeButtonText(plan.id), 'Current Plan');
	});
});

describe('Actions (expired state)', () => {
	it('should show the upgrade button', () => {
		const plan = defaultState.plans[0];
		const vm = mountActions(expiredState, plan);

		assert.isFalse(vm.showChangeButton(plan.id));
		assert.isNotFalse(vm.showUpgradeButton(plan.id));
	});
});
