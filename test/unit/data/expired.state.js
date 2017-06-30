import subscribedState from './subscribed.state';

export default Object.assign(Object.assign({}, subscribedState), {
	"subscription": {
		"stripe_plan": "product-9-monthly",
		"cancelled": true,
		"on_grace_period": false,
		"ends_at": '2017-07-01 00:00:00'
	},
});