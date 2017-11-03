<template>
	<div class="panel panel-default payment-info-panel">
		<div class="panel-heading">Payment Information</div>
		<div class="panel-body">
			<div v-if="hasPaymentInfo">
				<div class="pull-right">
					<stripe-upgrade text="Update Details"
									:form-data="stripeForm"
									:action="routes.form_post_update"
									:currency="currency"></stripe-upgrade>
				</div>
				<div class="payment-info-spacer">
					<p><strong>Card:</strong> {{ paymentInfo.card_brand }} ending in <strong>{{ paymentInfo.card_last_four }}</strong></p>
					<p v-if="billingAddress" style="margin-bottom: 0;"><strong>Address:</strong> {{ billingAddress }}</p>
				</div>
			</div>
			<em v-else>No payment information added yet</em>
		</div>
	</div>
</template>

<style>
	.payment-info-spacer {
		padding: 7px 5px;
	}
</style>

<script>
	import StripeUpgrade from './Stripe/StripeUpgrade.vue';

	export default {
		props: {
			routes: {
				type: Object,
				default: {
					form_post_update: '',
				}
			},
			stripeForm: {
				type: Object,
				required: true,
			},
			paymentInfo: {
				type: Object,
				default() {
					return {
						card_brand: '',
						card_last_four: '',
						billing_address: '',
						billing_city: '',
						billing_state: '',
						billing_zip: '',
						billing_country: '',
					}
				},
			},
			currency: {
				type: Object,
				default() {
					return {
						symbol: '$',
						code: 'USD'
					}
				},
			}
		},

		computed: {
			hasPaymentInfo() {
				return this.paymentInfo.card_brand;
			},
			billingAddress() {
				var address = '';

				address += this.paymentInfo.billing_address ? this.paymentInfo.billing_address + ', ' : '';
				address += this.paymentInfo.billing_city ? this.paymentInfo.billing_city + ', ' : '';
				address += this.paymentInfo.billing_state ? this.paymentInfo.billing_state + ', ' : '';
				address += this.paymentInfo.billing_zip ? this.paymentInfo.billing_zip + ', ' : '';
				address += this.paymentInfo.billing_country ? this.paymentInfo.billing_country + ', ' : '';
				address = address.replace(/\, $/, '');

				return address;
			}
		},

		components: {
			'stripe-upgrade': StripeUpgrade,
		}
	}
</script>
