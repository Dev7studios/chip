<template>
	<div class="panel panel-default plan-and-pricing-panel">
		<div class="panel-heading">Plan and Pricing</div>
		<div class="panel-body">
			<div class="alert alert-warning resume-alert" v-if="showResumeAlert">
				<p>You have cancelled your subscription to the
					<strong v-if="activePlan">{{ activePlan.name }} ({{ currency.symbol }}{{ activePlan.price }} {{ activePlan.interval }})</strong> plan.
				</p>
				<p>The benefits of your subscription will continue until your current billing period ends on
					<strong v-if="hasSubscription">{{ subscription.ends_at }}</strong>. You may resume your subscription at no
					extra cost until the end of the billing period.</p>

				<p style="margin-top: 20px">
					<a :href="routes.resume_subscription" class="btn btn-primary">Resume Subscription</a>
				</p>
			</div>

			<div v-if="showPricingTable">
				<column-view :routes="routes"
							:stripe-form="stripeForm"
							:plans="plans"
							:subscription="subscription"
							:coupon="coupon"
							:currency="currency"
							v-if="plans.length < listViewMinPlans"></column-view>

				<list-view :routes="routes"
						:stripe-form="stripeForm"
						:plans="plans"
						:subscription="subscription"
						:coupon="coupon"
						:currency="currency"
						v-else></list-view>
			</div>

			<a :href="routes.cancel_subscription" class="btn btn-danger cancel-btn"
					v-if="showCancelButton()"
					@click="confirmCancel">Cancel Subscription</a>

			<div class="alert alert-info coupon-alert" v-if="coupon">
				* price before coupon is applied
			</div>
		</div>
	</div>
</template>

<style>
	.pricing-table {
		margin-bottom: 0;
	}
	.pricing-table-column-view th,
	.pricing-table-column-view td { text-align: center; }
	.pricing-table tbody tr td {
		border: 0;
	}
	.pricing-table .features {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.pricing-table .table-spacer {
		padding: 7px 5px;
	}
	.resume-alert {
		margin-bottom: 0;
	}
	.plan-and-pricing-panel .cancel-btn {
		margin-top: 20px;
	}
	.coupon-alert {
		margin-top: 20px;
		margin-bottom: 0;
	}
</style>

<script>
	import _ from 'lodash';
	import ColumnView from './PlanAndPricing/ColumnView.vue';
	import ListView from './PlanAndPricing/ListView.vue';

	export default {
		props: {
			routes: {
				type: Object,
				default: {
					cancel_subscription: '',
					resume_subscription: '',
					change_plan: '',
					form_post_subscribe: '',
				}
			},
			stripeForm: {
				type: Object,
				required: true,
			},
			plans: {
				type: Array,
				required: true,
			},
			subscription: {
				type: Object,
				default() {
					return {
						stripe_plan: '',
						cancelled: false,
						on_grace_period: false,
						ends_at: null,
					}
				},
			},
			coupon: {
				type: String,
				default: '',
			},
			currency: {
				type: Object,
				default() {
					return {
						symbol: '$',
						code: 'USD'
					}
				},
			},
			listViewMinPlans: {
				type: Number,
				default: 4,
			}
		},

		data() {
			return {
				activePlan: null
			}
		},

		computed: {
			hasSubscription() {
				return !_.isEmpty(this.subscription);
			},
			hasActiveSubscription() {
				return this.hasSubscription && !this.subscriptionIsExpired;
			},
			subscriptionIsExpired() {
				if (!this.hasSubscription) {
					return false;
				}

				return this.subscription.cancelled && !this.subscription.on_grace_period;
			},
			showResumeAlert() {
				if (!this.hasSubscription) {
					return false;
				}

				return this.subscription.cancelled && this.subscription.on_grace_period;
			},
			showPricingTable() {
				if (!this.hasSubscription) {
					return true;
				}

				return !this.subscription.cancelled || this.subscriptionIsExpired;
			}
		},

		mounted() {
			this.setActivePlan();
		},

		methods: {
			setActivePlan() {
				if (this.hasSubscription && this.plans.length) {
					this.activePlan = _.find(this.plans, { 'id': this.subscription.stripe_plan });
				}
			},
			isCurrentPlan(planId) {
				if (!this.hasSubscription && !planId) {
					// Free plan
					return true;
				}

				return this.hasSubscription && this.subscription.stripe_plan == planId;
			},

			showCancelButton() {
				if (!this.hasSubscription) {
					return false;
				}

				return !this.subscription.cancelled;
			},
			confirmCancel(e) {
				if (!confirm('Are you sure you want to cancel your subscription?')) {
					e.preventDefault();
				}
			},
		},

		watch: {
			subscription() {
				this.setActivePlan();
			}
		},

		components: {
			'column-view': ColumnView,
			'list-view': ListView,
		}
	}
</script>
