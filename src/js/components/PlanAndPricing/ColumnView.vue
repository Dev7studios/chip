<template>
	<table class="table pricing-table pricing-table-column-view">
		<thead>
			<tr>
				<th v-for="plan in plans"><strong>{{ plan.name }}</strong></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td v-for="plan in plans">
					{{ currency.symbol }}{{ plan.price }} {{ plan.interval }}
					<span v-if="coupon">*</span>
				</td>
			</tr>
			<tr>
				<td v-for="plan in plans">
					<ul class="features">
						<li v-for="feature in plan.features">{{ feature }}</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td v-for="plan in plans">
					<actions :routes="routes"
							:stripe-form="stripeForm"
							:subscription="subscription"
							:coupon="coupon"
							:plan="plan"
							:currency="currency"></actions>
				</td>
			</tr>
		</tbody>
	</table>
</template>

<script>
	import Actions from './Actions.vue';

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
				required: true,
			}
		},

		components: {
			'actions': Actions,
		}
	}
</script>