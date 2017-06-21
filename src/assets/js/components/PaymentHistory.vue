<template>
	<div class="panel panel-default payment-history-panel">
		<div class="panel-heading">Payment History</div>
		<div class="panel-body">
			<table class="table payment-history-table" v-if="invoices.length">
				<thead>
				<tr>
					<th>Date</th>
					<th class="text-right">Total</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<tr v-for="invoice in invoices">
					<td><div class="table-spacer">{{ invoice.date }}</div></td>
					<td class="text-right"><div class="table-spacer">{{ invoice.total }}</div></td>
					<td class="text-right">
						<a :href="invoice.link" class="btn btn-default btn-sm" v-if="invoice.link">Download</a>
					</td>
				</tr>
				</tbody>
			</table>
			<em v-else>No invoices yet</em>
		</div>
	</div>
</template>

<style>
	.payment-history-table .table-spacer {
		padding: 4px 5px;
	}
</style>

<script>
	export default {
		props: {
			invoices: {
				type: Array,
				required: true,
			}
		}
	}
</script>
