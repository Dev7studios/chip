<template>
	<div id="app">
		<nav class="navbar navbar-inverse navbar-static-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">Stripe Vue Components Demo</a>
				</div>
			</div>
		</nav>

		<div class="container">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="text-center" style="margin-bottom: 40px;">
						<p>Select a state:</p>
						<div class="state-switcher btn-group" role="group">
							<button type="button" class="btn btn-default" :class="{'active': currentState == 'default'}"      @click="stateDefault">Default</button>
							<button type="button" class="btn btn-default" :class="{'active': currentState == 'default-list'}" @click="stateDefaultListView">Default (List View)</button>
							<button type="button" class="btn btn-default" :class="{'active': currentState == 'coupon'}"       @click="stateCoupon">Coupon Applied</button>
							<button type="button" class="btn btn-default" :class="{'active': currentState == 'subscribed'}"   @click="stateSubscribed">Subscribed</button>
							<button type="button" class="btn btn-default" :class="{'active': currentState == 'cancelled'}"    @click="stateCancelled">Cancelled</button>
							<button type="button" class="btn btn-default" :class="{'active': currentState == 'expired'}"      @click="stateExpired">Expired</button>
						</div>
					</div>

					<plan-and-pricing :routes="billingInfo.routes"
									  :stripe-form="billingInfo.stripe_form"
									  :plans="billingInfo.plans"
									  :subscription="billingInfo.subscription"
									  :coupon="billingInfo.coupon"></plan-and-pricing>

					<payment-info :routes="billingInfo.routes"
								  :stripe-form="billingInfo.stripe_form"
								  :payment-info="billingInfo.payment_info"></payment-info>

					<payment-history :invoices="billingInfo.invoices"></payment-history>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import _ from 'lodash';
	import billingInfo from './data';

	export default {
		name: 'app',

		data () {
			return {
				billingInfo: _.cloneDeep(billingInfo),
				currentState: 'default',
			}
		},

		methods: {
			stateDefault() {
				this.billingInfo = _.cloneDeep(billingInfo);
				this.currentState = 'default';
			},
			stateDefaultListView() {
				var newBillingInfo = _.cloneDeep(billingInfo);
				newBillingInfo.plans = this.morePlans();
				this.billingInfo = newBillingInfo;
				this.currentState = 'default-list';
			},
			stateCoupon() {
				this.billingInfo = _.cloneDeep(billingInfo);
				this.billingInfo.coupon = 'exmaple-coupon'
				this.currentState = 'coupon';
			},
			stateSubscribed() {
				this.billingInfo = _.cloneDeep(billingInfo);
				this.billingInfo.subscription = this.exampleSubscription();
				this.billingInfo.payment_info = this.examplePaymentInfo();
				this.billingInfo.invoices = this.exampleInvoices();
				this.currentState = 'subscribed';
			},
			stateCancelled() {
				this.billingInfo = _.cloneDeep(billingInfo);
				this.billingInfo.subscription = this.exampleSubscription(true);
				this.billingInfo.payment_info = this.examplePaymentInfo();
				this.billingInfo.invoices = this.exampleInvoices();
				this.currentState = 'cancelled';
			},
			stateExpired() {
				this.billingInfo = _.cloneDeep(billingInfo);
				this.billingInfo.payment_info = this.examplePaymentInfo();
				this.billingInfo.invoices = this.exampleInvoices();
				this.currentState = 'expired';
			},

			morePlans() {
				return [
					{"id": "product-9-monthly",   "name": "Freelancer", "price": 9,   "interval": "monthly", "features": ["1 user"]},
					{"id": "product-29-monthly",  "name": "Small Team", "price": 29,  "interval": "monthly", "features": ["5 users"]},
					{"id": "product-59-monthly",  "name": "Big Team",   "price": 59,  "interval": "monthly", "features": ["15 users"]},
					{"id": "product-99-monthly",  "name": "Agency",     "price": 99,  "interval": "monthly", "features": ["50 users"]},
					{"id": "product-199-monthly", "name": "Enterprise", "price": 199, "interval": "monthly", "features": ["150 users"]},
				];
			},
			exampleSubscription(cancelled = false) {
				return {
					stripe_plan: 'product-29-monthly',
					cancelled: cancelled,
					on_grace_period: cancelled,
					ends_at: cancelled ? '1st July 2017 at 12:00' : null,
				};
			},
			examplePaymentInfo() {
				return {
					card_brand: 'Visa',
					card_last_four: '4242',
					billing_address: '1 Example Place',
					billing_city: 'New York',
					billing_state: 'NY',
					billing_zip: '12345',
					billing_country: 'USA',
				};
			},
			exampleInvoices() {
				return [{
					date: 'Jun 1, 2017',
					id: 'in_AlPSE4hBoFK0lc',
					total: '$29.00',
					link: '/invoice/1234'
				}];
			},
		}
	}
</script>
