import util from '../util';
import PaymentInfo from '@/components/PaymentInfo.vue';

import defaultState from '../data/default.state.json';
import subscribedState from '../data/subscribed.state';
import cancelledState from '../data/cancelled.state';
import expiredState from '../data/expired.state';

function mountPaymentInfo(state) {
	return util.mountComponent(PaymentInfo, {
		routes: state.routes,
		stripeForm: state.stripe_form,
		paymentInfo: state.payment_info,
	});
}

util.mockStripeCheckout();

describe('PaymentInfo (default state)', () => {
	it('should have no data', () => {
		const vm = mountPaymentInfo(defaultState);

		assert.isNotTrue(vm.hasPaymentInfo);
		assert.isEmpty(vm.billingAddress);
	});
});

describe('PaymentInfo (subscribed state)', () => {
	it('should have data', () => {
		const vm = mountPaymentInfo(subscribedState);

		assert.isNotFalse(vm.hasPaymentInfo);
		assert.isNotEmpty(vm.billingAddress);
	});
});

describe('PaymentInfo (cancelled state)', () => {
	it('should have data', () => {
		const vm = mountPaymentInfo(cancelledState);

		assert.isNotFalse(vm.hasPaymentInfo);
		assert.isNotEmpty(vm.billingAddress);
	});
});

describe('PaymentInfo (expired state)', () => {
	it('should have data', () => {
		const vm = mountPaymentInfo(expiredState);

		assert.isNotFalse(vm.hasPaymentInfo);
		assert.isNotEmpty(vm.billingAddress);
	});
});
