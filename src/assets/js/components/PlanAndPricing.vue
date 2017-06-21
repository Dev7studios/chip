<template>
	<div class="panel panel-default plan-and-pricing-panel">
		<div class="panel-heading">Plan and Pricing</div>
		<div class="panel-body">
			<div class="alert alert-warning resume-alert" v-if="showResumeAlert">
				<p>You have cancelled your subscription to the
					<strong v-if="activePlan">{{ activePlan.name }} (${{ activePlan.price }} {{ activePlan.interval }})</strong> plan.
				</p>
				<p>The benefits of your subscription will continue until your current billing period ends on
					<strong v-if="hasSubscription">{{ subscription.ends_at }}</strong>. You may resume your subscription at no
					extra cost until the end of the billing period.</p>

				<p style="margin-top: 20px">
					<a :href="routes.resume_subscription" class="btn btn-primary">Resume Subscription</a>
				</p>
			</div>

			<table class="table pricing-table" v-if="showPricingTable">
				<tbody>
				<tr v-for="plan in plans">
					<td>
						<div class="table-spacer"><strong>{{ plan.name }}</strong></div>
					</td>
					<td class="text-center">
						<div class="table-spacer">
							<ul class="features">
								<li v-for="feature in plan.features">{{ feature }}</li>
							</ul>
						</div>
					</td>
					<td class="text-center">
						<div class="table-spacer">
							${{ plan.price }} {{ plan.interval }}
							<span v-if="coupon">*</span>
						</div>
					</td>
					<td class="text-right">
						<a :href="routes.cancel_subscription" class="btn btn-danger"
								v-if="showCancelButton(plan.id)"
								@click="confirmCancel">Cancel Subscription</a>

						<a :href="routes.change_plan + '?plan_id=' + plan.id" class="btn"
								:class="[isCurrentPlan(plan.id) ? 'btn-default' : 'btn-primary']"
								:disabled="isCurrentPlan(plan.id)"
								v-if="showChangeButton(plan.id)"
								@click="confirmChange">{{ changeButtonText(plan.id) }}</a>

						<div v-if="showUpgradeButton(plan.id)">
							<button type="button" class="btn btn-default" disabled v-if="isCurrentPlan(plan.id)">Current Plan</button>
							<stripe-upgrade :form-data="stripeForm" :action="routes.form_post_subscribe" text="Upgrade" :plan="plan" :coupon="coupon" v-else></stripe-upgrade>
						</div>
					</td>
				</tr>
				</tbody>
			</table>

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
	.coupon-alert {
		margin-top: 20px;
		margin-bottom: 0;
	}
</style>

<script>
	import _ from 'lodash';
	import StripeUpgrade from './stripe/StripeUpgrade.vue';

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

				return !this.subscription.cancelled;
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

			showCancelButton(planId) {
				if (!this.hasSubscription) {
					return false;
				}

				return !this.subscription.cancelled && !planId;
			},
			confirmCancel(e) {
				if (!confirm('Are you sure you want to cancel your subscription?')) {
					e.preventDefault();
				}
			},

			showChangeButton(planId) {
				return this.hasSubscription && planId;
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
				return !this.hasSubscription;
			}
		},

		watch: {
			subscription() {
				if (this.hasSubscription) {
					this.activePlan = _.find(this.plans, { 'id': this.subscription.stripe_plan });
				}
			}
		},

		components: {
			'stripe-upgrade': StripeUpgrade,
		}
	}
</script>
