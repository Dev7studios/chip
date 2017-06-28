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
	export default {
		data () {
			return {
				billingData: billingData,
			}
		}
	}
</script>
