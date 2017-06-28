import PlanAndPricing from './components/PlanAndPricing.vue';
import PaymentInfo from './components/PaymentInfo.vue';
import PaymentHistory from './components/PaymentHistory.vue';

export default {
	install (Vue) {
		Vue.component('plan-and-pricing', PlanAndPricing);
		Vue.component('payment-info', PaymentInfo);
		Vue.component('payment-history', PaymentHistory);
	}
}

export {
	PlanAndPricing,
	PaymentInfo,
	PaymentHistory
};