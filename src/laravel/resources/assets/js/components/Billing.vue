<template>
	<div>
		<plan-and-pricing :routes="billingData.routes"
				:stripe-form="billingData.stripe_form"
				:plans="billingData.plans"
				:subscription="billingData.subscription"
				:coupon="billingData.coupon"></plan-and-pricing>

		<payment-info :routes="billingData.routes"
				:stripe-form="billingData.stripe_form"
				:payment-info="billingData.payment_info"></payment-info>

		<payment-history :invoices="billingData.invoices"></payment-history>
	</div>
</template>

<script>
	import {PlanAndPricing, PaymentInfo, PaymentHistory} from 'saas-billing';

	export default {
		data () {
			return {
				billingData: billingData,
			}
		},

		components: {
			'plan-and-pricing': PlanAndPricing,
			'payment-info': PaymentInfo,
			'payment-history': PaymentHistory,
		}
	}
</script>
