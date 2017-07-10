import defaultState from './default.state.json';

export default Object.assign(Object.assign({}, defaultState), {
	"subscription": {
		"stripe_plan": "product-9-monthly",
		"cancelled": false,
		"on_grace_period": false,
		"ends_at": null
	},
	"payment_info": {
		"card_brand": "Visa",
		"card_last_four": "4242",
		"billing_address": "1 Example Place",
		"billing_city": "New York",
		"billing_state": "NY",
		"billing_zip": "12345",
		"billing_country": "USA"
	},
	"invoices": [
		{"date": "Jun 1, 2017", "id": "in_AlPSE4hBoFK0lc", "total": "$9.00", "link": "/invoice/1234"}
	],
});