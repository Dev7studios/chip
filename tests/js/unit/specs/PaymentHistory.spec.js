import util from '../util';
import PaymentHistory from '@/components/PaymentHistory.vue';

import defaultState from '../data/default.state.json';
import subscribedState from '../data/subscribed.state';
import cancelledState from '../data/cancelled.state';
import expiredState from '../data/expired.state';

function mountPaymentHistory(state) {
	return util.mountComponent(PaymentHistory, {
		invoices: state.invoices,
	});
}

util.mockStripeCheckout();

describe('PaymentHistory (default state)', () => {
	it('should have no invoices', () => {
		const vm = mountPaymentHistory(defaultState);

		assert.isEmpty(vm.invoices);
	});
});

describe('PaymentHistory (subscribed state)', () => {
	it('should have invoices', () => {
		const vm = mountPaymentHistory(subscribedState);

		assert.isNotEmpty(vm.invoices);
	});
});

describe('PaymentHistory (cancelled state)', () => {
	it('should have invoices', () => {
		const vm = mountPaymentHistory(cancelledState);

		assert.isNotEmpty(vm.invoices);
	});
});

describe('PaymentHistory (expired state)', () => {
	it('should have invoices', () => {
		const vm = mountPaymentHistory(expiredState);

		assert.isNotEmpty(vm.invoices);
	});
});
