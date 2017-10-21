<template>
	<div>
		<a :href="routes.change_plan + '?plan_id=' + plan.id" class="btn"
				:class="[isCurrentPlan(plan.id) ? 'btn-default' : 'btn-primary']"
				:disabled="isCurrentPlan(plan.id)"
				v-if="showChangeButton(plan.id)"
				@click="confirmChange">{{ changeButtonText(plan.id) }}</a>

		<div v-if="showUpgradeButton(plan.id)">
			<button type="button" class="btn btn-default" disabled v-if="isCurrentPlan(plan.id)">Current Plan</button>
			<stripe-upgrade :form-data="stripeForm" :action="routes.form_post_subscribe" text="Upgrade" :plan="plan" :coupon="coupon" v-else></stripe-upgrade>
		</div>
	</div>
</template>

<script>
	import _ from 'lodash';
	import StripeUpgrade from '../Stripe/StripeUpgrade.vue';

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
			plan: {
				type: Object,
				required: true,
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
			}
		},

		methods: {
			isCurrentPlan(planId) {
				if (!this.hasSubscription && !planId) {
					// Free plan
					return true;
				}

				return this.hasSubscription && this.subscription.stripe_plan == planId;
			},

			showChangeButton(planId) {
				return this.hasActiveSubscription && planId;
			},
			changeButtonText(planId) {
				if (this.isCurrentPlan(planId)) {
					return 'Current Plan';
				}

				return 'Change Plan';
			},
			confirmChange(e) {
				if (e.target.getAttribute('disabled')) {
					e.preventDefault();
					return;
				}

				if (!confirm('Are you sure you want to change your subscription? You will be charged a prorated amount now, then the new rate going forward.')) {
					e.preventDefault();
				}
			},

			showUpgradeButton(planId) {
				return !this.hasActiveSubscription && planId;
			}
		},

		components: {
			'stripe-upgrade': StripeUpgrade,
		}
	}
</script>