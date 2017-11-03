<template>
	<table class="table pricing-table pricing-table-list-view">
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
						{{ currency.symbol }}{{ plan.price }} {{ plan.interval }}
						<span v-if="coupon">*</span>
					</div>
				</td>
				<td class="text-right">
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
				required: true,
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
				required: true,
			},
			coupon: {
				type: String,
				required: true,
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