<template>
	<form :action="action" method="post">
		<input type="hidden" name="_token" v-model="formData.csrf_token">
		<input type="hidden" name="plan_id" v-model="plan.id" v-if="plan">

		<input type="hidden" name="stripeToken" v-model="stripeToken">
		<input type="hidden" name="billing_name" v-model="billing_name">
		<input type="hidden" name="billing_address_country" v-model="billing_address_country">
		<input type="hidden" name="billing_address_zip" v-model="billing_address_zip">
		<input type="hidden" name="billing_address_state" v-model="billing_address_state">
		<input type="hidden" name="billing_address_line1" v-model="billing_address_line1">
		<input type="hidden" name="billing_address_city" v-model="billing_address_city">
		<input type="hidden" name="billing_address_country_code" v-model="billing_address_country_code">
		<input type="hidden" name="coupon" v-model="coupon" v-if="coupon">

		<button type="button" class="btn btn-primary" @click="open">{{ text }}</button>
	</form>
</template>

<script>
	import Vue from 'vue';

	export default {
		props: ['formData', 'action', 'text', 'plan', 'coupon', 'currency'],

		data() {
			return {
				stripe: null,
				stripeToken: '',
				billing_name: '',
				billing_address_country: '',
				billing_address_zip: '',
				billing_address_state: '',
				billing_address_line1: '',
				billing_address_city: '',
				billing_address_country_code: '',
			}
		},

		created() {
			this.stripe = StripeCheckout.configure({
				key: this.formData.stripe_key,
				name: this.formData.app_name,
				email: this.formData.user_email,
				currency: this.currency.code,
				locale: 'auto',
				zipCode: true,
				billingAddress: true,
				allowRememberMe: false,
				token: (token, args) => {
					this.stripeToken = token.id;
					this.billing_name = args.billing_name;
					this.billing_address_country = args.billing_address_country;
					this.billing_address_zip = args.billing_address_zip;
					this.billing_address_state = args.billing_address_state;
					this.billing_address_line1 = args.billing_address_line1;
					this.billing_address_city = args.billing_address_city;
					this.billing_address_country_code = args.billing_address_country_code;

					Vue.nextTick(() => {
						this.$el.submit();
					});
				}
			});
		},

		methods: {
			open() {
				if (this.plan) {
					this.stripe.open({
						description: this.plan.name + ' plan',
						amount: this.plan.price * 100,
						panelLabel: 'Pay {{amount}} ' + this.plan.interval,
					});
				} else {
					this.stripe.open({
						panelLabel: 'Update Card Details',
					});
				}
			}
		}
	}
</script>
